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
$moduleDirName = basename(__DIR__);

$modversion['version']          = '1.2';
$modversion['module_status']    = 'Beta 1';
$modversion['release_date']     = '2017/02/21';
$modversion['name']             = _MI_TDMMONEY_NAME;
$modversion['description']      = _MI_TDMMONEY_DESC;
$modversion['credits']          = 'G. Mage';
$modversion['author']           = 'G. Mage';
$modversion['pseudo']           = 'Mage';
$modversion['website']          = 'www.freexoopservices.com';
$modversion['name_website']     = 'FreeXoopServices';
$modversion['license']          = 'GPL see LICENSE';
$modversion['official']         = 0;
$modversion['modicons16']       = 'assets/images/icons/16';
$modversion['modicons32']       = 'assets/images/icons/32';
$modversion['image']            = 'assets/images/logoModule.png';
$modversion['dirname']          = $moduleDirName;
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['onUpdate']         = 'include/update.php';
$modversion['help']             = 'page=help';
//about
$modversion['module_website_url']  = 'www.xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.8';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.1'];
$modversion['system_menu']         = 1;

$modversion['tables'] = [
    $moduleDirName . '_' . 'account',
    $moduleDirName . '_' . 'category',
    $moduleDirName . '_' . 'operation',
];

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    [
        'name' => _MI_TDMMONEY_OVERVIEW,
        'link' => 'page=help'
    ],
    [
        'name' => _MI_TDMMONEY_DISCLAIMER,
        'link' => 'page=disclaimer'
    ],
    [
        'name' => _MI_TDMMONEY_LICENSE,
        'link' => 'page=license'
    ],
    [
        'name' => _MI_TDMMONEY_SUPPORT,
        'link' => 'page=support'
    ],
];

// Pour avoir une administration
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu']  = 'admin/menu.php';

// Menu
$modversion['hasMain']        = 1;
$modversion['sub'][1]['name'] = _MI_TDMMONEY_SUBMIT;
$modversion['sub'][1]['url']  = 'submit.php';

// Recherche
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'TDMMoney_search';

// Templates
$modversion['templates'][1]['file']        = 'tdmmoney_index.tpl';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file']        = 'tdmmoney_viewaccount.tpl';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file']        = 'tdmmoney_submit.tpl';
$modversion['templates'][3]['description'] = '';

// ------------------- Config Options ------------------- //
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';

$modversion['config'][] = [
    'name'        => 'TDMMoney_editor',
    'title'       => '_MI_TDMMONEY_EDITOR',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor'),
    'category'    => 'global',
];

$modversion['config'][] = [
    'name'        => 'TDMMoney_filter',
    'title'       => '_MI_TDMMONEY_FILTER',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3,
    'options'     => array(
        '_MI_TDMMONEY_FILTER1' => 1,
        '_MI_TDMMONEY_FILTER2' => 2,
        '_MI_TDMMONEY_FILTER3' => 3
    ),
];
