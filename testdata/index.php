<?php
/**
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package
 * @since           2.5.9
 * @author          Michael Beck (aka Mamba)
 */
require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';

$moduleDirName = basename(dirname(__DIR__));

$op = \Xmf\Request::getCmd('op', '');

switch ($op) {
    case 'load':
        loadSampleData();
        break;
}

// XMF TableLoad for SAMPLE data

function loadSampleData()
{
    $moduleDirName = basename(dirname(__DIR__));

    xoops_loadLanguage('admin', $moduleDirName);

    global $xoopsDB;

    $countAccount   = \Xmf\Database\TableLoad::loadTableFromYamlFile('tdmmoney_account', __DIR__ . '/account.yml');
    $countCategory  = \Xmf\Database\TableLoad::loadTableFromYamlFile('tdmmoney_category', __DIR__ . '/category.yml');
    $countOperation = \Xmf\Database\TableLoad::loadTableFromYamlFile('tdmmoney_operation', __DIR__ . '/operation.yml');

    $message = _AM_TDMMONEY_SAMPLEDATA_FAILED;
    //    if ($result) {
    //        $message = _AD_GWIKI_ADD_HELP_OK;
    //    }

    if ($countAccount > 0 && $countCategory > 0 && $countOperation > 0) {
        $message = _AM_TDMMONEY_SAMPLEDATA_SUCCESS;
    }

    //    return $message;
    redirect_header('../admin/account.php', 1, $message);
}
