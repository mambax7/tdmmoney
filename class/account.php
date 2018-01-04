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

defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

/**
 * Class TdmMoneyAccount
 */
class TdmMoneyAccount extends XoopsObject
{
    //Constructor
    /**
     * TdmMoneyAccount constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initVar('account_id', XOBJ_DTYPE_INT, null, false, 8);
        $this->initVar('account_name', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('account_bank', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('account_adress', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('account_balance', XOBJ_DTYPE_OTHER, null, false, 8);
        $this->initVar('account_currency', XOBJ_DTYPE_TXTBOX, null, false);
    }

    //    public function tdmmoney_compte()
    //    {
    //        $this->__construct();
    //    }

    /**
     * @return int
     */
    public function get_new_enreg()
    {
        global $xoopsDB;
        $newEnreg = $xoopsDB->getInsertId();

        return $newEnreg;
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getForm($action = false)
    {
        global $xoopsDB, $xoopsModuleConfig;

        if (false === $action) {
            $action = $_SERVER['REQUEST_URI'];
        }

        //nom du formulaire selon l'action (editer ou ajouter):
        $title = $this->isNew() ? sprintf(_AM_TDMMONEY_ACCOUNT_ADD) : sprintf(_AM_TDMMONEY_ACCOUNT_EDIT, $this->getVar('account_name'));
        //création du formulaire
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        //nom
        $form->addElement(new XoopsFormText(_AM_TDMMONEY_ACCOUNT_NAME, 'account_name', 50, 255, $this->getVar('account_name')), true);
        //banque
        $form->addElement(new XoopsFormText(_AM_TDMMONEY_ACCOUNT_BANK, 'account_bank', 50, 255, $this->getVar('account_bank')), true);
        //adresse
        $form->addElement(new XoopsFormTextArea(_AM_TDMMONEY_ACCOUNT_ADRESS, 'account_adress', $this->getVar('account_adress', 'e'), 4, 47));
        //solde
        $form->addElement(new XoopsFormText(_AM_TDMMONEY_ACCOUNT_BALANCE, 'account_balance', 10, 10, $this->getVar('account_balance')), true);
        //devise
        $form->addElement(new XoopsFormText(_AM_TDMMONEY_ACCOUNT_CURRENCY, 'account_currency', 10, 10, $this->getVar('account_currency')), true);
        //permissions
        /* @var $memberHandler XoopsMemberHandler */
        $memberHandler = xoops_getHandler('member');
        $group_list    = $memberHandler->getGroupList();
        /* @var $gpermHandler XoopsGroupPermHandler */
        $gpermHandler = xoops_getHandler('groupperm');
        $full_list    = array_keys($group_list);
        global $xoopsModule;
        if (!$this->isNew()) {
            $groups_ids_view                 = $gpermHandler->getGroupIds('tdmmoney_view', $this->getVar('account_id'), $xoopsModule->getVar('mid'));
            $groups_ids_submit               = $gpermHandler->getGroupIds('tdmmoney_submit', $this->getVar('account_id'), $xoopsModule->getVar('mid'));
            $groups_ids_view                 = array_values($groups_ids_view);
            $groups_news_can_view_checkbox   = new XoopsFormCheckBox(_AM_TDMMONEY_PERMISSIONS_VIEW_DSC, 'groups_view[]', $groups_ids_view);
            $groups_ids_submit               = array_values($groups_ids_submit);
            $groups_news_can_submit_checkbox = new XoopsFormCheckBox(_AM_TDMMONEY_PERMISSIONS_SUBMIT_DSC, 'groups_submit[]', $groups_ids_submit);
        } else {
            $groups_news_can_view_checkbox   = new XoopsFormCheckBox(_AM_TDMMONEY_PERMISSIONS_VIEW_DSC, 'groups_view[]', $full_list);
            $groups_news_can_submit_checkbox = new XoopsFormCheckBox(_AM_TDMMONEY_PERMISSIONS_SUBMIT_DSC, 'groups_submit[]', $full_list);
        }
        // pour voir
        $groups_news_can_view_checkbox->addOptionArray($group_list);
        $form->addElement($groups_news_can_view_checkbox);
        // pour editer
        $groups_news_can_submit_checkbox->addOptionArray($group_list);
        $form->addElement($groups_news_can_submit_checkbox);

        //pour enregistrer le formulaire
        $form->addElement(new XoopsFormHidden('op', 'save'));
        // pour passer "account_id" si on modifie le compte
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('account_id', $this->getVar('account_id')));
        }
        //boutton d'envoi du formulaire
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

/**
 * Class TDMMoneytdmmoney_accountHandler
 */
class TdmMoneyAccountHandler extends XoopsPersistableObjectHandler
{
    /**
     * TdmMoneyAccountHandler constructor.
     * @param null|object|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'tdmmoney_account', 'TdmMoneyAccount', 'account_id', 'account_name');
    }
}
