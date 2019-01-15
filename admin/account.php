<?php
/**
 * TDMMoney
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   Gregory Mage (Aka Mage)
 * @license     GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author      Gregory Mage (Aka Mage)
 */

use XoopsModules\Tdmmoney;

require_once __DIR__ . '/admin_header.php';

//On recupere la valeur de l'argument op dans l'URL$
$op = Tdmmoney\Utility::cleanVars($_REQUEST, 'op', 'list', 'string');

//Les valeurs de op qui vont permettre d'aller dans les differentes parties de la page
switch ($op) {
    // Vue liste
    case 'list':
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();

        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_TDMMONEY_ACCOUNT_NEW, 'account.php?op=new', 'add');

        if ($helper->getConfig('ShowSampleDataButton')) {
            require_once dirname(__DIR__) . '/testdata/index.php';
            $adminObject->addItemButton(_AM_TDMMONEY_ADD_SAMPLEDATA, '__DIR__ . /../../testdata/index.php?op=load', 'add');
        }
        $adminObject->displayButton('left');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('account_name');
        $criteria->setOrder('ASC');
        $accountArray = $accountHandler->getAll($criteria);
        if (count($accountArray) > 0) {
            //pour le calcul des soldes:
            $criteria = new \CriteriaCompo();
            $criteria->setSort('operation_account');
            $criteria->setOrder('ASC');
            $operationArray = $operationHandler->getAll($criteria);

            echo '<table width="100%" cellspacing="1" class="outer">';
            echo '<tr>';
            echo '<th align="center">' . _AM_TDMMONEY_ACCOUNT_NAME . '</th>';
            echo '<th align="center">' . _AM_TDMMONEY_ACCOUNT_BANK . '</th>';
            echo '<th align="center">' . _AM_TDMMONEY_ACCOUNT_ADRESS . '</th>';
            echo '<th align="center">' . _AM_TDMMONEY_ACCOUNT_BALANCE . '</th>';
            echo '<th align="center">' . _AM_TDMMONEY_ACCOUNT_BALANCE2 . '</th>';
            echo '<th align="center" width="10%">' . _AM_TDMMONEY_ACTION . '</th>';
            echo '</tr>';
            $class = 'odd';
            foreach (array_keys($accountArray) as $i) {
                //calcul des soldes
                /** @var \XoopsModules\Tdmmoney\Account[] $accountArray */
                $balanceOperation = $accountArray[$i]->getVar('account_balance');
                foreach (array_keys($operationArray) as $j) {
                    if ($operationArray[$j]->getVar('operation_account') == $accountArray[$i]->getVar('account_id')) {
                        $balanceOperation = 1 == $operationArray[$j]->getVar('operation_type') ? $balanceOperation - $operationArray[$j]->getVar('operation_amount') : $balanceOperation + $operationArray[$j]->getVar('operation_amount');
                    }
                }
                echo '<tr class="' . $class . '">';
                echo '<td align="center" >' . $accountArray[$i]->getVar('account_name') . '</td>';
                echo '<td align="center">' . $accountArray[$i]->getVar('account_bank') . '</td>';
                echo '<td align="center">' . $accountArray[$i]->getVar('account_adress') . '</td>';
                $displayAccountBalance = $accountArray[$i]->getVar('account_balance') < 0 ? '<span style="color: #ff0000; font-weight: bold;">' . $accountArray[$i]->getVar('account_balance') . '</span>' : '<span style="font-weight: bold;">' . $accountArray[$i]->getVar('account_balance') . '</span>';
                echo '<td align="center">' . $displayAccountBalance . ' ' . $accountArray[$i]->getVar('account_currency') . '</td>';
                $displayBalanceOperation = $balanceOperation < 0 ? '<span style="color: #ff0000; font-weight: bold;">' . $balanceOperation . '</span>' : '<span style="font-weight: bold">' . $balanceOperation . '</span>';
                echo '<td align="center">' . $displayBalanceOperation . ' ' . $accountArray[$i]->getVar('account_currency') . '</td>';
                echo '<td align="center" width="10%">';
                echo '<a href="operation.php?op=list&account_id=' . $i . '"><img src="' . $pathIcon16 . '/view.png" alt="' . _AM_TDMMONEY_DISPLAY . '" title="' . _AM_TDMMONEY_DISPLAY . '"></a> ';
                echo '<a href="account.php?op=edit&account_id=' . $i . '"><img src="' . $pathIcon16 . '/edit.png" alt="' . _AM_TDMMONEY_EDIT . '" title="' . _AM_TDMMONEY_EDIT . '"></a> ';
                echo '<a href="account.php?op=del&account_id=' . $i . '"><img src="' . $pathIcon16 . '/delete.png" alt="' . _AM_TDMMONEY_DEL . '" title="' . _AM_TDMMONEY_DEL . '"></a>';
                echo '</td>';
                echo '</tr>';
                $class = ('even' === $class) ? 'odd' : 'even';
            }
            echo '</table>';
        }
        break;
    // vue création
    case 'new':
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();

        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_TDMMONEY_ACCOUNT_LIST, 'account.php?op=list', 'list');
        $adminObject->displayButton('left');

        //Affichage du formulaire de création des comptes
        $obj  = $accountHandler->create();
        /** @var \XoopsThemeForm $form */
        $form = $obj->getForm();
        $form->display();
        break;
    // Pour éditer un compte
    case 'edit':
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();

        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_TDMMONEY_ACCOUNT_NEW, 'account.php?op=new', 'add');
        $adminObject->addItemButton(_AM_TDMMONEY_ACCOUNT_LIST, 'account.php?op=list', 'list');
        $adminObject->displayButton('left');

        //Affichage du formulaire de création des comptes
        $accountId = Tdmmoney\Utility::cleanVars($_REQUEST, 'account_id', 0, 'int');
        $obj       = $accountHandler->get($accountId);
        $form      = $obj->getForm();
        $form->display();
        break;
    // Pour supprimer un compte
    case 'del':
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();

        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_TDMMONEY_ACCOUNT_NEW, 'account.php?op=new', 'add');
        $adminObject->addItemButton(_AM_TDMMONEY_ACCOUNT_LIST, 'account.php?op=list', 'list');
        $adminObject->displayButton('left');

        global $xoopsModule;
        $accountId = Tdmmoney\Utility::cleanVars($_REQUEST, 'account_id', 0, 'int');
        /** @var \XoopsModules\Tdmmoney\Account $obj */
        $obj = $accountHandler->get($accountId);
        if (\Xmf\Request::hasVar('ok', 'REQUEST') && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('account.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // supression des opérations du compte
            $criteria = new \CriteriaCompo();
            $criteria->add(new \Criteria('operation_account', $accountId));
            $contentsArray = $operationHandler->getAll($criteria);
            foreach (array_keys($contentsArray) as $i) {
                $objcontents = $operationHandler->get($contentsArray[$i]->getVar('operation_id'));
                $operationHandler->delete($objcontents) || $objcontents->getHtmlErrors();
            }
            if ($accountHandler->delete($obj)) {
                redirect_header('account.php', 1, _AM_TDMMONEY_ACCOUNT_DELOK);
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            $message  = '';
            $criteria = new \CriteriaCompo();
            $criteria->add(new \Criteria('operation_account', $accountId));
            $operationArray = $operationHandler->getAll($criteria);
            if (count($operationArray) > 0) {
                $message .= _AM_TDMMONEY_CAT_DELOPERATION . '<br>';
                foreach (array_keys($operationArray) as $i) {
                    $message .= '<span style="color : #ff0000;">' . $operationArray[$i]->getVar('operation_id') . ' - ' . formatTimestamp($operationArray[$i]->getVar('operation_date'), 's') . ' (' . $operationArray[$i]->getVar('operation_amount') . ')</span><br>';
                }
            }
            xoops_confirm([
                              'ok'         => 1,
                              'account_id' => $accountId,
                              'op'         => 'del',
                          ], $_SERVER['REQUEST_URI'], sprintf(_AM_TDMMONEY_SUREDEL, $obj->getVar('account_name')) . '<br><br>' . $message);
        }
        break;
    // Pour sauver un compte
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('category.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $accountId = Tdmmoney\Utility::cleanVars($_REQUEST, 'account_id', 0, 'int');
        if (\Xmf\Request::hasVar('account_id', 'REQUEST')) {
            $obj = $accountHandler->get($accountId);
        } else {
            $obj = $accountHandler->create();
        }
        $erreur       = false;
        $errorMessage = '';
        // Récupération des variables:
        $obj->setVar('account_name', $_POST['account_name']);
        $obj->setVar('account_bank', $_POST['account_bank']);
        $obj->setVar('account_adress', $_POST['account_adress']);
        $obj->setVar('account_balance', $_POST['account_balance']);
        $obj->setVar('account_currency', $_POST['account_currency']);
        //vérification que account_balance soit un entier
        if (0 == \Xmf\Request::getInt('account_balance', 0, 'REQUEST') && '0' != $_REQUEST['account_balance']) {
            $erreur       = true;
            $errorMessage = _AM_TDMMONEY_ACCOUNT_ERREUR_BALANCE . '<br>';
        }
        if (true === $erreur) {
            echo '<div class="errorMsg" style="text-align: left;">' . $errorMessage . '</div>';
        } else {
            if ($accountHandler->insert($obj)) {
                $newAccountId = $obj->get_new_enreg();
                //permission pour voir
                $permId = isset($_REQUEST['account_id']) ? $accountId : $newAccountId;
                /* @var XoopsGroupPermHandler $grouppermHandler */
                $grouppermHandler = xoops_getHandler('groupperm');
                $criteria         = new \CriteriaCompo();
                $criteria->add(new \Criteria('gperm_itemid', $permId, '='));
                $criteria->add(new \Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='));
                $criteria->add(new \Criteria('gperm_name', 'tdmmoney_view', '='));
                $grouppermHandler->deleteAll($criteria);
                if (\Xmf\Request::hasVar('groups_view', 'POST')) {
                    foreach ($_POST['groups_view'] as $onegroupId) {
                        $grouppermHandler->addRight('tdmmoney_view', $permId, $onegroupId, $xoopsModule->getVar('mid'));
                    }
                }
                //permission pour editer
                $permId           = isset($_REQUEST['account_id']) ? $accountId : $newAccountId;
                $grouppermHandler = xoops_getHandler('groupperm');
                $criteria         = new \CriteriaCompo();
                $criteria->add(new \Criteria('gperm_itemid', $permId, '='));
                $criteria->add(new \Criteria('gperm_modid', $xoopsModule->getVar('mid'), '='));
                $criteria->add(new \Criteria('gperm_name', 'tdmmoney_submit', '='));
                $grouppermHandler->deleteAll($criteria);
                if (\Xmf\Request::hasVar('groups_submit', 'POST')) {
                    foreach ($_POST['groups_submit'] as $onegroupId) {
                        $grouppermHandler->addRight('tdmmoney_submit', $permId, $onegroupId, $xoopsModule->getVar('mid'));
                    }
                }

                redirect_header('account.php?op=list', 1, _AM_TDMMONEY_ACCOUNT_SAVE);
            }
            echo $obj->getHtmlErrors();
        }
        $form = &$obj->getForm();
        $form->display();
        break;
}
require_once __DIR__ . '/admin_footer.php';
