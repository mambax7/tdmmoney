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

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class TDMMoney_category extends XoopsObject
{
    //Constructor
    function __construct()
    {
        $this->XoopsObject();
        $this->initVar("cat_cid",XOBJ_DTYPE_INT,null,false,5);
        $this->initVar("cat_pid",XOBJ_DTYPE_INT,null,false,5);
        $this->initVar("cat_title",XOBJ_DTYPE_TXTBOX,null,false);
        $this->initVar("cat_desc",XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("cat_weight",XOBJ_DTYPE_INT,null,false,5);
        // Pour autoriser le html
        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);

    }
    function tdmmoney_category()
    {
        $this->__construct();
    }

    function getForm($action = false)
    {
        global $xoopsDB, $xoopsModuleConfig;

        if ($action === false) {
            $action = $_SERVER["REQUEST_URI"];
        }
        //nom du formulaire selon l'action (editer ou ajouter):
        $title = $this->isNew() ? sprintf(_AM_TDMMONEY_CAT_ADD) : sprintf(_AM_TDMMONEY_CAT_EDIT, $this->getVar("cat_title"));
        //cr�ation du formulaire
        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        //titre
        $form->addElement(new XoopsFormText(_AM_TDMMONEY_CAT_TITLE, 'cat_title', 50, 255, $this->getVar('cat_title')), true);
        //editeur
        $editor_configs=array();
    	$editor_configs["name"] ="cat_desc";
    	$editor_configs["value"] = $this->getVar('cat_desc', 'e');
    	$editor_configs["rows"] = 10;
    	$editor_configs["cols"] = 150;
    	$editor_configs["width"] = "100%";
    	$editor_configs["height"] = "400px";
    	$editor_configs["editor"] = $xoopsModuleConfig['TDMMoney_editor'];
		$form->addElement( new XoopsFormEditor(_AM_TDMMONEY_CAT_DSC, "cat_desc", $editor_configs), false);
        // Pour faire une sous-cat�gorie
        $categoryHandler =& xoops_getModuleHandler("tdmmoney_category", "TDMMoney");
        $criteria = new CriteriaCompo();
        $criteria->setSort('cat_weight ASC, cat_title');
        $criteria->setOrder('ASC');
		$category_arr = $categoryHandler->getall($criteria);
		$mytree = new XoopsObjectTree($category_arr, 'cat_cid', 'cat_pid');
		$form->addElement(new XoopsFormLabel(_AM_TDMMONEY_CAT_SUBCAT, $mytree->makeSelBox('cat_pid', 'cat_title','--',$this->getVar('cat_pid'),true)));
        //poids de la cat�gorie
        $form->addElement(new XoopsFormText(_AM_TDMMONEY_CAT_WEIGHT, 'cat_weight', 5, 5, $this->getVar('cat_weight', 'e')), true);
        //pour enregistrer le formulaire
        $form->addElement(new XoopsFormHidden('op', 'save'));
        // pour passer "cid" si on modifie la cat�gorie
        if (!$this->isNew()) {
        	$form->addElement(new XoopsFormHidden('cid', $this->getVar('cat_cid')));
        }
        //boutton d'envoi du formulaire
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        return $form;
    }
}
class TDMMoneytdmmoney_categoryHandler extends XoopsPersistableObjectHandler
{

    function __construct(&$db)
    {
        parent::__construct($db, "tdmmoney_category", "tdmmoney_category", "cat_cid", "cat_title");
    }

}

?>