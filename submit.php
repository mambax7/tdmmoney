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
$GLOBALS['xoopsOption']['template_main'] = 'tdmmoney_submit.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';
//pemissions
$perm_submit = $grouppermHandler->checkRight('tdmmoney_ac', 4, $groups, $xoopsModule->getVar('mid')) ? true : false;
$perm_edit   = $grouppermHandler->checkRight('tdmmoney_ac', 8, $groups, $xoopsModule->getVar('mid')) ? true : false;

// Get Action type
$op = Tdmmoney\Utility::cleanVars($_REQUEST, 'op', 'new', 'string');

//Les valeurs de op qui vont permettre d'aller dans les differentes parties de la page
switch ($op) {
    // vue création
    case 'new':
    default:
        //permissions
        if (false === $perm_submit) {
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
        if (false === $perm_edit) {
            redirect_header('index.php', 2, _NOPERM);
        }
        //Affichage du formulaire de création des opérations
        $operation_id = Tdmmoney\Utility::cleanVars($_REQUEST, 'operation_id', 0, 'int');
        $obj          = $operationHandler->get($operation_id);
        $form         = $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
        break;

    // Pour supprimer une opération
    case 'del':
        //permissions
        if (false === $perm_edit) {
            redirect_header('index.php', 2, _NOPERM);
        }
        global $xoopsModule;
        $operation_id = Tdmmoney\Utility::cleanVars($_REQUEST, 'operation_id', 0, 'int');
        $account_id   = Tdmmoney\Utility::cleanVars($_REQUEST, 'account_id', 0, 'int');
        $obj          = $operationHandler->get($operation_id);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
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
            xoops_confirm([
                              'ok'           => 1,
                              'operation_id' => $operation_id,
                              'op'           => 'del',
                              'account_id'   => $account_id
                          ], $_SERVER['REQUEST_URI'], sprintf(_AM_TDMMONEY_SUREDEL, $obj->getVar('operation_id')) . ' (' . $obj->getVar('operation_amount') . ')');
        }
        break;

    // Pour sauver une opération
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('operation.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $operation_id = Tdmmoney\Utility::cleanVars($_REQUEST, 'operation_id', 0, 'int');
        if (isset($_REQUEST['operation_id'])) {
            $obj = $operationHandler->get($operation_id);
        } else {
            $obj = $operationHandler->create();
        }
        $erreur         = false;
        $message_erreur = '';
        //Récupération des variables:
        $obj->setVar('operation_account', Xmf\Request::getInt('operation_account', 0, 'POST'));
        $obj->setVar('operation_category', Xmf\Request::getInt('operation_category', 0, 'POST'));//$_POST['operation_category']);
        $obj->setVar('operation_type', Xmf\Request::getInt('operation_type', 0, 'POST'));//$_POST['operation_type']);
        $obj->setVar('operation_date', strtotime(Xmf\Request::getInt('operation_date', 0, 'POST')));
        $obj->setVar('operation_amount', Xmf\Request::getFloat('operation_amount', 0, 'POST'));//$_POST['operation_amount']);
        $obj->setVar('operation_description', Xmf\Request::getText('operation_description', 0, 'POST'));//$_POST['operation_description']);
        $obj->setVar('operation_submitter', !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0);
        $obj->setVar('operation_date_created', time());
        if (0 == $_POST['operation_sender']) {
            $obj->setVar('operation_sender', 0);
            $obj->setVar('operation_outsender', Xmf\Request::getInt('operation_outsender', 0, 'POST'));//$_POST['operation_outsender']);
        } else {
            $obj->setVar('operation_sender', Xmf\Request::getInt('operation_sender', 0, 'POST'));//$_POST['operation_sender']);
            $obj->setVar('operation_outsender', '');
        }
        //vérification que operation_amount soit un entier
        if (0 == (int)$_REQUEST['operation_amount'] && '0' != $_REQUEST['operation_amount']) {
            $erreur         = true;
            $message_erreur = _AM_TDMMONEY_OPERATION_ERREUR_AMOUNT . '<br>';
            $obj->setVar('operation_amount', '');
        }
        if (true === $erreur) {
            $xoopsTpl->assign('error_message', $message_erreur);
        } else {
            if ($operationHandler->insert($obj)) {
                redirect_header('viewaccount.php?account_id=' . $_POST['operation_account'], 1, _AM_TDMMONEY_OPERATION_SAVE);
            }
            echo $obj->getHtmlErrors();
        }
        $form = $obj->getForm();
        $xoopsTpl->assign('form', $form->render());
        break;
}

require_once XOOPS_ROOT_PATH . '/footer.php';
