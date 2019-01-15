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
 */
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/tree.php';
require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

require dirname(__DIR__) . '/include/common.php';
//require  dirname(__DIR__) . '/include/config.php';

$moduleDirName = basename(dirname(__DIR__));

/** @var \XoopsModules\Tdmmoney\Helper $helper */
$helper = \XoopsModules\Tdmmoney\Helper::getInstance();

/** @var \Xmf\Module\Admin $adminObject */
$adminObject = \Xmf\Module\Admin::getInstance();

if ($xoopsUser) {
    $xoopsModule = \XoopsModule::getByDirname($moduleDirName);
    if (!$xoopsUser->isAdmin($xoopsModule->mid())) {
        redirect_header(XOOPS_URL . '/', 3, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/', 3, _NOPERM);
}

//permission
/* @var XoopsGroupPermHandler $grouppermHandler */
$grouppermHandler = xoops_getHandler('groupperm');
if (is_object($xoopsUser)) {
    $groups = &$xoopsUser->getGroups();
} else {
    $groups = XOOPS_GROUP_ANONYMOUS;
}

$pathIcon16    = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = \Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');

$myts = \MyTextSanitizer::getInstance();

if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require_once $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}
$xoopsTpl->assign('module_url', XOOPS_URL . "/modules/$moduleDirName/");
//appel des class
/* @var \XoopsModules\Tdmmoney\AccountHandler $accountHandler */
$accountHandler = $helper->getHandler('Account');
/* @var \XoopsModules\Tdmmoney\CategoryHandler $categoryHandler */
$categoryHandler = $helper->getHandler('Category');
/* @var \XoopsModules\Tdmmoney\OperationHandler $operationHandler */
$operationHandler = $helper->getHandler('Operation');
