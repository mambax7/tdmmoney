<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project (https://xoops.org)
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 * @author       Gregory Mage (Aka Mage)
 */
require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();

$moduleDirName = basename(dirname(__DIR__));

//compte le nombre de comptes
$count_account = $accountHandler->getCount();
//compte le nombre de catégories
$count_category = $categoryHandler->getCount();
//compte le nombre d'opération catégories
$count_operation = $operationHandler->getCount();

//$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->addInfoBox(_AM_TDMMONEY_MANAGER_ACCOUNT);
if (0 == $count_account) {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_ACCOUNT, '<span class="red">' . $count_account . '</span>'), '', 'Red');
} else {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_ACCOUNT, '<span class="green">' . $count_account . '</span>'), '', 'Green');
}

$adminObject->addInfoBox(_AM_TDMMONEY_MANAGER_CATEGORY);
if (0 == $count_category) {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_CATEGORY, '<span class="red">' . $count_category . '</span>'), '', 'Red');
} else {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_CATEGORY, '<span class="green">' . $count_category . '</span>'), '', 'Green');
}

$adminObject->addInfoBox(_AM_TDMMONEY_MANAGER_OPERATION);
if (0 == $count_operation) {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_OPERATION, '<span class="red">' . $count_operation . '</span>'), '', 'Red');
} else {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_OPERATION, '<span class="green">' . $count_operation . '</span>'), '', 'Green');
}

if (!is_file(XOOPS_ROOT_PATH . '/class/libraries/vendor/tecnickcom/tcpdf/tcpdf.php')) {
    $adminObject->addConfigBoxLine('<span style="color:#ff0000;"><img src="' . XOOPS_URL . '/Frameworks/moduleclasses/icons/16/0.png" alt="!">' . _AM_TDMMONEY_ERROR_NO_PDF . '</span>', 'default');
}

$adminObject->displayNavigation(basename(__FILE__));

//------------- Test Data ----------------------------

if ($helper->getConfig('displaySampleButton')) {
    xoops_loadLanguage('admin/modulesadmin', 'system');
    require dirname(__DIR__) . '/testdata/index.php';

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=load', 'add');

    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'), '__DIR__ . /../../testdata/index.php?op=save', 'add');

    //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');

    $adminObject->displayButton('left', '');
}

//------------- End Test Data ----------------------------

$adminObject->displayIndex();

echo $utility::getServerStats();

require __DIR__ . '/admin_footer.php';
