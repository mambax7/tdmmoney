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

require_once __DIR__ . '/header.php';
// template d'affichage
$GLOBALS['xoopsOption']['template_main'] = 'tdmmoney_viewaccount.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

$account_id = TdmmoneyUtility::cleanVars($_REQUEST, 'account_id', 0, 'int');

if ($account_id == 0) {
    redirect_header('index.php', 2, _MD_TDMMONEY_VIEWACCOUNT_REDIRECT_NOACCOUNT);
}

// pour les permissions
if (!$gpermHandler->checkRight('tdmmoney_view', $account_id, $groups, $xoopsModule->getVar('mid'))) {
    redirect_header('index.php', 2, _NOPERM);
}

// affichage des filtres
$criteria        = new CriteriaCompo();
$display_account = true;
$criteria->add(new Criteria('operation_account', $account_id));
if (isset($_REQUEST['date_start']) && isset($_REQUEST['date_end'])) {
    $date_start = strtotime(TdmmoneyUtility::cleanVars($_REQUEST, 'date_start', 0, 'int'));
    $date_end   = strtotime(TdmmoneyUtility::cleanVars($_REQUEST, 'date_end', 0, 'int'));
} else {
    //sans filtre
    if ($xoopsModuleConfig['TdmMoneyFilter'] == 1) {
        $date_start = 0;
        $date_end   = mktime(0, 0, 0, 12, 31, date('Y'));
    }
    //filtre mois actuel
    if ($xoopsModuleConfig['TdmMoneyFilter'] == 2) {
        $date_start = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $date_end   = mktime(0, 0, 0, date('m'), date('t'), date('Y'));
    }
    //filtre année actuelle
    if ($xoopsModuleConfig['TdmMoneyFilter'] == 3) {
        $date_start = mktime(0, 0, 0, 1, 1, date('Y'));
        $date_end   = mktime(0, 0, 0, 12, 31, date('Y'));
    }
}
$criteria->add(new Criteria('operation_date', $date_start, '>='));
$criteria->add(new Criteria('operation_date', $date_end, '<='));
$form = new XoopsThemeForm(_MD_TDMMONEY_VIEWACCOUNT_FILTER, 'form', 'viewaccount.php', 'post', true);
$form->setExtra('enctype="multipart/form-data"');
$filer = new XoopsFormElementTray(_MD_TDMMONEY_VIEWACCOUNT_FILTER);
$filer->addElement(new XoopsFormTextDateSelect(_MD_TDMMONEY_VIEWACCOUNT_START, 'date_start', '', $date_start));
$filer->addElement(new XoopsFormTextDateSelect(_MD_TDMMONEY_VIEWACCOUNT_END, 'date_end', '', $date_end));
$filer->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
$form->addElement($filer);
$form->addElement(new XoopsFormHidden('op', 'list'));
$form->addElement(new XoopsFormHidden('account_id', $account_id));
$xoopsTpl->assign('form', $form->render());

//pour faire une jointure de table
$operationHandler->table_link   = $operationHandler->db->prefix('tdmmoney_account'); // Nom de la table en jointure
$operationHandler->field_link   = 'account_id'; // champ de la table en jointure
$operationHandler->field_object = 'operation_account'; // champ de la table courante
// extraction des données
$criteria->setSort('operation_date');
$criteria->setOrder('DESC');
$operation_arr = $operationHandler->getByLink($criteria);

if (count($operation_arr) > 0) {
    // calcul des soldes
    $operation_balance_arr = array_reverse($operation_arr, true);
    $account_balance       = $accountHandler->get($account_id);
    $balance               = $account_balance->getVar('account_balance');
    $criteria_amount       = new CriteriaCompo();
    $criteria_amount->add(new Criteria('operation_account', $account_id));
    $criteria_amount->add(new Criteria('operation_date', $date_start, '<'));
    $operation_ammount = $operationHandler->getall($criteria_amount);
    $balance_ammount   = 0;
    foreach (array_keys($operation_ammount) as $i) {
        $balance_ammount = $operation_ammount[$i]->getVar('operation_type') == 1 ? $balance_ammount - $operation_ammount[$i]->getVar('operation_amount') : $balance_ammount + $operation_ammount[$i]->getVar('operation_amount');
    }
    $balance      += $balance_ammount;
    $balance_save = $balance;
    foreach (array_keys($operation_balance_arr) as $i) {
        $balance               = $operation_balance_arr[$i]->getVar('operation_type') == 1 ? $balance - $operation_balance_arr[$i]->getVar('operation_amount') : $balance + $operation_balance_arr[$i]->getVar('operation_amount');
        $operation_balance[$i] = $balance;
    }
    // début de l'affichage des opérations
    $category_arr = $categoryHandler->getall();
    $mytree       = new XoopsObjectTree($category_arr, 'cat_cid', 'cat_pid');
    foreach (array_keys($operation_arr) as $i) {
        $category = TdmmoneyUtility::getPathTree($mytree, $operation_arr[$i]->getVar('operation_category'), $category_arr, 'cat_title', $prefix = ' <img src="assets/images/deco/arrow.gif"> ');
        if ($operation_arr[$i]->getVar('operation_sender') == 0) {
            if ($operation_arr[$i]->getVar('operation_outsender') == '') {
                $sender = XoopsUser::getUnameFromId($operation_arr[$i]->getVar('operation_sender'), 1);
            } else {
                $sender = $operation_arr[$i]->getVar('operation_outsender');
            }
        } else {
            $sender = XoopsUser::getUnameFromId($operation_arr[$i]->getVar('operation_sender'), 1);
        }
        $withdraw                  = $operation_arr[$i]->getVar('operation_type') == 1 ? $operation_arr[$i]->getVar('operation_amount') : '';
        $deposit                   = $operation_arr[$i]->getVar('operation_type') == 2 ? $operation_arr[$i]->getVar('operation_amount') : '';
        $display_operation_balance = $operation_balance[$i] < 0 ? '<span style="color: #ff0000; font-weight: bold">' . $operation_balance[$i] . '</span>' : '<span style="font-weight: bold">' . $operation_balance[$i] . '</span>';

        //action selon les permissions
        $perm_modif = $gpermHandler->checkRight('tdmmoney_ac', 8, $groups, $xoopsModule->getVar('mid')) ? true : false;
        $xoopsTpl->assign('perm_modif', $perm_modif);
        if ($perm_modif === true) {
            $action = '<a href="submit.php?op=edit&operation_id='
                      . $i
                      . '"><img src="'
                      . $pathIcon16
                      . '/edit.png" alt="'
                      . _MD_TDMMONEY_EDIT
                      . '" title="'
                      . _MD_TDMMONEY_EDIT
                      . '"></a> '
                      . '<a href="submit.php?op=del&operation_id='
                      . $i
                      . '&account_id='
                      . $account_id
                      . '"><img src="'
                      . $pathIcon16
                      . '/delete.png" alt="'
                      . _MD_TDMMONEY_DEL
                      . '" title="'
                      . _MD_TDMMONEY_DEL
                      . '"></a>';
        }
        $xoopsTpl->append('operation', [
            'operation_date'        => formatTimestamp($operation_arr[$i]->getVar('operation_date'), 's'),
            'operation_sender'      => $sender,
            'operation_category'    => $category,
            'operation_description' => $operation_arr[$i]->getVar('operation_description'),
            'operation_withdraw'    => $withdraw,
            'operation_deposit'     => $deposit,
            'operation_balance'     => $display_operation_balance . ' ' . $operation_arr[$i]->getVar('account_currency'),
            'operation_action'      => $action
        ]);
    }
    //Solde initial
    $xoopsTpl->assign('operation_report', _MD_TDMMONEY_VIEWACCOUNT_REPORT . formatTimestamp($date_start - 86400, 's'));
    $display_account_balance = $balance_save < 0 ? '<span style="color: #ff0000; font-weight: bold">' . $balance_save . '</span>' : '<span style="font-weight: bold">' . $balance_save . '</span>';
    $xoopsTpl->assign('operation_balance', $display_account_balance . ' ' . $operation_arr[$i]->getVar('account_currency'));
    $xoopsTpl->assign('numrows', count($operation_arr));
    $xoopsTpl->assign('account_id', $account_id);
    $xoopsTpl->assign('date_start', $date_start);
    $xoopsTpl->assign('date_end', $date_end);
    $xoopsTpl->assign('account_name', $account_balance->getVar('account_name'));

    //export pdf selon les permissions
    $perm_pdf = $gpermHandler->checkRight('tdmmoney_ac', 16, $groups, $xoopsModule->getVar('mid')) ? true : false;
    $xoopsTpl->assign('perm_pdf', $perm_pdf);

    //ajout selon les permissions
    $perm_add = $gpermHandler->checkRight('tdmmoney_ac', 4, $groups, $xoopsModule->getVar('mid')) ? true : false;
    $xoopsTpl->assign('perm_add', $perm_add);

    if ($moduleHelper->getConfig('displayPdf')) {
        $xoopsTpl->assign('displayPdf', 1);
    }

    //titre de la page
    $xoopsTpl->assign('xoops_pagetitle', $account_balance->getVar('account_name') . '&nbsp;-&nbsp;' . $xoopsModule->name());
}

require_once XOOPS_ROOT_PATH . '/footer.php';
