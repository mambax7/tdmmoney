<?php

namespace XoopsModules\Tdmmoney;

/**
 * Class Utility
 */
class Utility
{
    use Common\VersionChecks; //checkVerXoops, checkVerPhp Traits

    use Common\ServerStats; // getServerStats Trait

    use Common\FilesManagement; // Files Management Trait

    //--------------- Custom module methods -----------------------------

    /**
     * @param $permtype
     * @param $dirname
     * @return mixed
     */
    public static function getMygetItemIds($permtype, $dirname)
    {
        global $xoopsUser;
        /* @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $tdmModule     = $moduleHandler->getByDirname($dirname);
        $groups        = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        /* @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        $categories       = $grouppermHandler->getItemIds($permtype, $groups, $tdmModule->getVar('mid'));

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
    public static function getPathTree($mytree, $key, $category_array, $title, $prefix = '')
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
    public static function cleanVars(&$global, $key, $default = '', $type = 'int')
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
        if (false === $ret) {
            return $default;
        }

        return $ret;
    }

    /**
     * @param  string $item
     * @return string
     */
    public static function convertCharset($item)
    {
        if (_CHARSET !== 'windows-1256') {
            return utf8_encode($item);
        }

        if ($unserialize == unserialize($item)) {
            foreach ($unserialize as $key => $value) {
                $unserialize[$key] = @iconv('windows-1256', 'UTF-8', $value);
            }
            $serialize = serialize($unserialize);

            return $serialize;
        }

        return @iconv('windows-1256', 'UTF-8', $item);
    }
}
