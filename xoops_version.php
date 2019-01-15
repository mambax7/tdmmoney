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

require_once __DIR__ . '/preloads/autoloader.php';

/** @var \XoopsModules\Tdmmoney\Helper $helper */
$helper             = \XoopsModules\Tdmmoney\Helper::getInstance();

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
xoops_loadLanguage('common', $moduleDirName);

$modversion['version']             = '1.2';
$modversion['module_status']       = 'Beta 2';
$modversion['release_date']        = '2018/09/19';
$modversion['name']                = _MI_TDMMONEY_NAME;
$modversion['description']         = _MI_TDMMONEY_DESC;
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL 2.0 or later';
$modversion['license_url']         = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['author']              = 'G. Mage';
$modversion['pseudo']              = 'Mage';
$modversion['credits']             = 'XOOPS Development Team';
$modversion['official']            = 0;
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['image']               = 'assets/images/logoModule.png';
$modversion['dirname']             = $moduleDirName;
$modversion['module_website_url']  = 'www.xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.6';
$modversion['min_xoops']           = '2.5.10-Alpha';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.1'];
$modversion['system_menu']         = 1;
$modversion['adminindex']          = 'admin/index.php';
$modversion['adminmenu']           = 'admin/menu.php';

// ------------------- Mysql ------------------- //
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables created by sql file (without prefix!)
$modversion['tables'] = [
    $moduleDirName . '_' . 'account',
    $moduleDirName . '_' . 'category',
    $moduleDirName . '_' . 'operation',
];

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    [
        'name' => _MI_TDMMONEY_OVERVIEW,
        'link' => 'page=help',
    ],
    [
        'name' => _MI_TDMMONEY_DISCLAIMER,
        'link' => 'page=disclaimer',
    ],
    [
        'name' => _MI_TDMMONEY_LICENSE,
        'link' => 'page=license',
    ],
    [
        'name' => _MI_TDMMONEY_SUPPORT,
        'link' => 'page=support',
    ],
];

//Install/Uninstall Functions
//$modversion['onInstall']   = 'include/oninstall.php';
//$modversion['onUpdate']    = 'include/onupdate.php';
//$modversion['onUninstall'] = 'include/onuninstall.php';

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
$modversion['search']['func'] = 'tdmmoney_search';

// ------------------- Templates ------------------- //
$modversion['templates'] = [
    ['file' => 'tdmmoney_index.tpl', 'description' => ''],
    ['file' => 'tdmmoney_viewaccount.tpl', 'description' => ''],
    ['file' => 'tdmmoney_submit.tpl', 'description' => ''],
];

// ------------------- Config Options ------------------- //
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';

$modversion['config'][] = [
    'name'        => 'TdmMoneyEditor',
    'title'       => '_MI_TDMMONEY_EDITOR',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => \XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/class/xoopseditor'),
    'category'    => 'global',
];

$modversion['config'][] = [
    'name'        => 'TdmMoneyFilter',
    'title'       => '_MI_TDMMONEY_FILTER',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3,
    'options'     => [
        '_MI_TDMMONEY_FILTER1' => 1,
        '_MI_TDMMONEY_FILTER2' => 2,
        '_MI_TDMMONEY_FILTER3' => 3,
    ],
];

$modversion['config'][] = [
    'name'        => 'ShowSampleDataButton',
    'title'       => '_MI_TDMMONEY_SHOW_SAMPLE_DATA',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'displayPdf',
    'title'       => '_MI_TDMMONEY_DISPLAY_PDF',
    'description' => '_MI_TDMMONEY_DISPLAY_PDF_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name' => 'displayDeveloperTools',
    'title' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 0,
];
