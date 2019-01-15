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
        $adminObject->addItemButton(_AM_TDMMONEY_CAT_NEW, 'category.php?op=new', 'add');
        $adminObject->displayButton('left');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('cat_weight ASC, cat_title');
        $criteria->setOrder('ASC');
        $category_arr = $categoryHandler->getAll($criteria);
        if (count($category_arr) > 0) {
            echo '<table width="100%" cellspacing="1" class="outer">';
            echo '<tr>';
            echo '<th align="left" width="25%">' . _AM_TDMMONEY_CAT_TITLE . '</th>';
            echo '<th align="left" >' . _AM_TDMMONEY_CAT_DSC . '</th>';
            echo '<th align="center" width="10%">' . _AM_TDMMONEY_CAT_WEIGHT2 . '</th>';
            echo '<th align="center" width="10%">' . _AM_TDMMONEY_ACTION . '</th>';
            echo '</tr>';
            $class              = 'odd';
            $mytree             = new Tdmmoney\Tree($category_arr, 'cat_cid', 'cat_pid');
            $category_ArrayTree = $mytree->makeArrayTree('cat_title', '<img src="../assets/images/deco/arrow.gif">');
            foreach (array_keys($category_ArrayTree) as $i) {
                echo '<tr class="' . $class . '">';
                echo '<td align="left" >' . $category_ArrayTree[$i] . '</td>';
                echo '<td align="left">' . $category_arr[$i]->getVar('cat_desc') . '</td>';
                echo '<td align="center">' . $category_arr[$i]->getVar('cat_weight') . '</td>';
                echo '<td align="center">';
                echo '<a href="category.php?op=edit&cid=' . $i . '"><img src="' . $pathIcon16 . '/edit.png" alt="' . _AM_TDMMONEY_EDIT . '" title="' . _AM_TDMMONEY_EDIT . '"></a> ';
                echo '<a href="category.php?op=del&cid=' . $i . '"><img src="' . $pathIcon16 . '/delete.png" alt="' . _AM_TDMMONEY_DEL . '" title="' . _AM_TDMMONEY_DEL . '"></a>';
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
        $adminObject->addItemButton(_AM_TDMMONEY_CAT_LIST, 'category.php?op=list', 'list');
        $adminObject->displayButton('left');

        //Affichage du formulaire de création des catégories
        $obj  = $categoryHandler->create();
        /** @var \XoopsThemeForm $form */
        $form = $obj->getForm();
        $form->display();
        break;
    // Pour éditer une catégorie
    case 'edit':
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();

        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_TDMMONEY_CAT_NEW, 'category.php?op=new', 'add');
        $adminObject->addItemButton(_AM_TDMMONEY_CAT_LIST, 'category.php?op=list', 'list');
        $adminObject->displayButton('left');

        //Affichage du formulaire de création des catégories
        $cid  = Tdmmoney\Utility::cleanVars($_REQUEST, 'cid', 0, 'int');
        $obj  = $categoryHandler->get($cid);
        $form = $obj->getForm();
        $form->display();
        break;
    // Pour supprimer une catégorie
    case 'del':
        //Affichage de la partie haute de l'administration de Xoops
        xoops_cp_header();

        $adminObject->displayNavigation(basename(__FILE__));
        $adminObject->addItemButton(_AM_TDMMONEY_CAT_NEW, 'category.php?op=new', 'add');
        $adminObject->addItemButton(_AM_TDMMONEY_CAT_LIST, 'category.php?op=list', 'list');
        $adminObject->displayButton('left');

        global $xoopsModule;
        $cid = Tdmmoney\Utility::cleanVars($_REQUEST, 'cid', 0, 'int');
        $obj = $categoryHandler->get($cid);
        if (\Xmf\Request::hasVar('ok', 'REQUEST') && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('category.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            // supression des sous catégories
            $category_arr      = $categoryHandler->getAll();
            $mytree            = new \XoopsObjectTree($category_arr, 'cat_cid', 'cat_pid');
            $category_childcat = $mytree->getAllChild($cid);
            foreach (array_keys($category_childcat) as $i) {
                // supression de la sous catégorie
                $objchild = $categoryHandler->get($category_childcat[$i]->getVar('cat_cid'));
                $categoryHandler->delete($objchild) or $objchild->getHtmlErrors();
            }
            if ($categoryHandler->delete($obj)) {
                redirect_header('category.php', 1, _AM_TDMMONEY_CAT_DELOK);
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            $message           = '';
            $category_arr      = $categoryHandler->getAll();
            $mytree            = new \XoopsObjectTree($category_arr, 'cat_cid', 'cat_pid');
            $category_childcat = $mytree->getAllChild($cid);
            if (count($category_childcat) > 0) {
                $message .= _AM_TDMMONEY_CAT_DELSOUSCAT . ' <br><br>';
                foreach (array_keys($category_childcat) as $i) {
                    $message .= '<b><span style="color : #ff0000;">' . $category_childcat[$i]->getVar('cat_title') . '</span></b><br>';
                }
            } else {
                $message .= '';
            }
            xoops_confirm([
                              'ok'  => 1,
                              'cid' => $cid,
                              'op'  => 'del',
                          ], $_SERVER['REQUEST_URI'], sprintf(_AM_TDMMONEY_SUREDEL, $obj->getVar('cat_title')) . '<br><br>' . $message);
        }
        break;
    // Pour sauver une catégorie
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('category.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $cid = \Xmf\Request::getInt('cid', 0, 'POST');
        $obj = $categoryHandler->get($cid);
        /*
        $cid = Tdmmoney\Utility::cleanVars($_REQUEST, 'cid', 0, 'int');
        if (\Xmf\Request::hasVar('cid', 'REQUEST')) {
            $obj = $categoryHandler->get($cid);
        } else {
            $obj = $categoryHandler->create();
        }
        */
        $erreur       = false;
        $errorMessage = '';
        // Récupération des variables:
        $cat_weight = \Xmf\Request::getInt('cat_weight', 0, 'POST');
        $cat_pid    = \Xmf\Request::getInt('cat_pid', 0, 'POST');
        $obj->setVar('cat_pid', $cat_pid);
        $obj->setVar('cat_title', \Xmf\Request::getString('cat_title', '', 'POST'));
        $obj->setVar('cat_desc', \Xmf\Request::getString('cat_desc', '', 'POST'));
        $obj->setVar('cat_weight', $cat_weight);
        //vérification que cat_weight soit un entier
        if (0 === $cat_weight && '0' != $_POST['cat_weight']) {
            $erreur       = true;
            $errorMessage = _AM_TDMMONEY_CAT_ERREUR_WEIGHT . '<br>';
        }
        //vérification que pid ne soit pas égale à cid
        if (!$obj->isNew() && $cid == $cat_pid) {
            $erreur       = true;
            $errorMessage .= _AM_TDMMONEY_CAT_ERREUR_CAT;
        }
        /*
        if (\Xmf\Request::hasVar('cid', 'REQUEST')) {
            if ($_REQUEST['cid'] == $_REQUEST['cat_pid']) {
                $erreur         = true;
                $errorMessage .= _AM_TDMMONEY_CAT_ERREUR_CAT;
            }
        }
        */
        if (true === $erreur) {
            echo '<div class="errorMsg left">' . $errorMessage . '</div>';
        } else {
            if ($categoryHandler->insert($obj)) {
                redirect_header('category.php?op=list', 1, _AM_TDMMONEY_CAT_SAVE);
            }
            echo $obj->getHtmlErrors();
        }
        $form = $obj->getForm();
        $form->display();
        break;
}

require_once __DIR__ . '/admin_footer.php';
