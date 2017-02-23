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

/**
 * @param $permtype
 * @param $dirname
 * @return mixed
 */
function TDMMoney_MygetItemIds($permtype, $dirname)
{
    global $xoopsUser;
    $moduleHandler = xoops_getHandler('module');
    $tdmModule     = $moduleHandler->getByDirname($dirname);
    $groups        = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gpermHandler  = xoops_getHandler('groupperm');
    $categories    = $gpermHandler->getItemIds($permtype, $groups, $tdmModule->getVar('mid'));

    return $categories;
}

/**
 * @param        $mytree
 * @param        $key
 * @param        $category_array
 * @param        $title
 * @param string $prefix
 * @return string
 */
function TDMMoney_PathTree($mytree, $key, $category_array, $title, $prefix = '')
{
    $category_parent = $mytree->getAllParent($key);
    $category_parent = array_reverse($category_parent);
    $Path            = '';
    foreach (array_keys($category_parent) as $j) {
        $Path .= $category_parent[$j]->getVar($title) . $prefix;
    }
    if (array_key_exists($key, $category_array)) {
        $first_category = $category_array[$key]->getVar($title);
    } else {
        $first_category = '';
    }
    $Path .= $first_category;

    return $Path;
}

/**
 * @param        $global
 * @param        $key
 * @param string $default
 * @param string $type
 * @return mixed|string
 */
function TDMMoney_CleanVars(&$global, $key, $default = '', $type = 'int')
{
    switch ($type) {
        case 'string':
            $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
            break;
        case 'int':
        default:
            $ret = isset($global[$key]) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
            break;
    }
    if ($ret === false) {
        return $default;
    }

    return $ret;
}
