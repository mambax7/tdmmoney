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
 * @copyright    The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 * @author       Gregory Mage (Aka Mage)
 */

include_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();

if (!isset($moduleDirName)) {
    $moduleDirName = basename(dirname(__DIR__));
}

//compte le nombre de comptes
$count_account = $accountHandler->getCount();
//compte le nombre de catégories
$count_category = $categoryHandler->getCount();
//compte le nombre d'opération catégories
$count_operation = $operationHandler->getCount();

//$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->addInfoBox(_AM_TDMMONEY_MANAGER_ACCOUNT);
if ($count_account == 0) {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_ACCOUNT, '<span class="red">' . $count_account . '</span>'), '', 'Red');
} else {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_ACCOUNT, '<span class="green">' . $count_account . '</span>'), '', 'Green');
}

$adminObject->addInfoBox(_AM_TDMMONEY_MANAGER_CATEGORY);
if ($count_category == 0) {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_CATEGORY, '<span class="red">' . $count_category . '</span>'), '', 'Red');
} else {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_CATEGORY, '<span class="green">' . $count_category . '</span>'), '', 'Green');
}

$adminObject->addInfoBox(_AM_TDMMONEY_MANAGER_OPERATION);
if ($count_operation == 0) {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_OPERATION, '<span class="red">' . $count_operation . '</span>'), '', 'Red');
} else {
    $adminObject->addInfoBoxLine(sprintf(_AM_TDMMONEY_THEREARE_OPERATION, '<span class="green">' . $count_operation . '</span>'), '', 'Green');
}

if (!is_file(XOOPS_ROOT_PATH . '/class/libraries/vendor/tecnickcom/tcpdf/tcpdf.php')) {
    $adminObject->addConfigBoxLine('<span style="color:red;"><img src="' . XOOPS_URL . '/Frameworks/moduleclasses/icons/16/0.png" alt="!" />' . _AM_TDMMONEY_ERROR_NO_PDF . '</span>', 'default');
}

//$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayIndex();

include_once __DIR__ . '/admin_footer.php';
