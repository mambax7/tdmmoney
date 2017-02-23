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


//**********************************************************************************************************************
// ModuleName_checkModuleAdmin
//**********************************************************************************************************************
// return true if moduladmin framworks exists.
//**********************************************************************************************************************
function TDMMoney_checkModuleAdmin()
{
    if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        return true;
    }else{
        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
        return false;
    }
}

function TDMMoney_MygetItemIds($permtype,$dirname)
{
    global $xoopsUser;
    $module_handler =& xoops_gethandler('module');
    $tdmModule =& $module_handler->getByDirname($dirname);
    $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler =& xoops_gethandler('groupperm');
    $categories = $gperm_handler->getItemIds($permtype, $groups, $tdmModule->getVar('mid'));
    return $categories;
}

function TDMMoney_PathTree($mytree, $key, $category_array, $title, $prefix = '' )
{
    $category_parent = $mytree->getAllParent($key);
    $category_parent = array_reverse($category_parent);
    $Path = '';
    foreach (array_keys($category_parent) as $j) {
        $Path .= $category_parent[$j]->getVar($title) . $prefix;
    }
    if (array_key_exists($key, $category_array)){
        $first_category = $category_array[$key]->getVar($title);
    }else{
        $first_category = '';
    }
    $Path .= $first_category;
    return $Path;
}

function TDMMoney_CleanVars( &$global, $key, $default = '', $type = 'int' ) {
    switch ( $type ) {
        case 'string':
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_MAGIC_QUOTES ) : $default;
            break;
        case 'int': default:
            $ret = ( isset( $global[$key] ) ) ? filter_var( $global[$key], FILTER_SANITIZE_NUMBER_INT ) : $default;
            break;
    }
    if ( $ret === false ) {
        return $default;
    }
    return $ret;
}
?>