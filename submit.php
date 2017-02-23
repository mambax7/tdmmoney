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

include_once __DIR__ . '/header.php';
// template d'affichage
$GLOBALS['xoopsOption']['template_main'] = 'tdmmoney_submit.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';
//pemissions
$perm_submit = $gpermHandler->checkRight('tdmmoney_ac', 4, $groups, $xoopsModule->getVar('mid')) ? true : false;
$perm_edit   = $gpermHandler->checkRight('tdmmoney_ac', 8, $groups, $xoopsModule->getVar('mid')) ? true : false;

// Get Action type
$op = TDMMoney_CleanVars($_REQUEST, 'op', 'new', 'string');

//Les valeurs de op qui vont permettre d'aller dans les differentes parties de la page
switch ($op) {
    // vue création
    case 'new':
    default:
        //permissions
        if ($perm_submit === false) {
            redirect_header('index.php', 2, _NOPERM);
        }
        //Affichage du formulaire de création des opérations
        $obj  = $operationHandler->create();
        $form = $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
        break;

    // Pour éditer une opération
    case 'edit':
        //permissions
        if ($perm_edit === false) {
            redirect_header('index.php', 2, _NOPERM);
        }
        //Affichage du formulaire de création des opérations
        $operation_id = TDMMoney_CleanVars($_REQUEST, 'operation_id', 0, 'int');
        $obj          = $operationHandler->get($operation_id);
        $form         = $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
        break;

    // Pour supprimer une opération
    case 'del':
        //permissions
        if ($perm_edit === false) {
            redirect_header('index.php', 2, _NOPERM);
        }
        global $xoopsModule;
        $operation_id = TDMMoney_CleanVars($_REQUEST, 'operation_id', 0, 'int');
        $account_id   = TDMMoney_CleanVars($_REQUEST, 'account_id', 0, 'int');
        $obj          =& $operationHandler->get($operation_id);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('operation.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // supression de l'opération
            if ($operationHandler->delete($obj)) {
                redirect_header('viewaccount.php?account_id=' . $account_id, 1, _AM_TDMMONEY_OPERATION_DELOK);
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            xoops_confirm(array('ok'           => 1,
                                'operation_id' => $operation_id,
                                'op'           => 'del',
                                'account_id'   => $account_id
                          ), $_SERVER['REQUEST_URI'], sprintf(_AM_TDMMONEY_SUREDEL, $obj->getVar('operation_id')) . ' (' . $obj->getVar('operation_amount') . ')');
        }
        break;

    // Pour sauver une opération
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('operation.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $operation_id = TDMMoney_CleanVars($_REQUEST, 'operation_id', 0, 'int');
        if (isset($_REQUEST['operation_id'])) {
            $obj =& $operationHandler->get($operation_id);
        } else {
            $obj = $operationHandler->create();
        }
        $erreur         = false;
        $message_erreur = '';
        //Récupération des variables:
        $obj->setVar('operation_account', $_POST['operation_account']);
        $obj->setVar('operation_category', $_POST['operation_category']);
        $obj->setVar('operation_type', $_POST['operation_type']);
        $obj->setVar('operation_date', strtotime($_POST['operation_date']));
        $obj->setVar('operation_amount', $_POST['operation_amount']);
        $obj->setVar('operation_description', $_POST['operation_description']);
        $obj->setVar('operation_submitter', !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0);
        $obj->setVar('operation_date_created', time());
        if ($_POST['operation_sender'] == 0) {
            $obj->setVar('operation_sender', 0);
            $obj->setVar('operation_outsender', $_POST['operation_outsender']);
        } else {
            $obj->setVar('operation_sender', $_POST['operation_sender']);
            $obj->setVar('operation_outsender', '');
        }
        //vérification que operation_amount soit un entier
        if ((int)$_REQUEST['operation_amount'] == 0 && $_REQUEST['operation_amount'] != '0') {
            $erreur         = true;
            $message_erreur = _AM_TDMMONEY_OPERATION_ERREUR_AMOUNT . '<br>';
            $obj->setVar('operation_amount', '');
        }
        if ($erreur === true) {
            $xoopsTpl->assign('error_message', $message_erreur);
        } else {
            if ($operationHandler->insert($obj)) {
                redirect_header('viewaccount.php?account_id=' . $_POST['operation_account'], 1, _AM_TDMMONEY_OPERATION_SAVE);
            }
            echo $obj->getHtmlErrors();
        }
        $form =& $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
        break;
}

include_once XOOPS_ROOT_PATH . '/footer.php';
