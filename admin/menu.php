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

require_once __DIR__ . '/../class/Helper.php';
//require_once __DIR__ . '/../include/common.php';
$helper = Tdmmoney\Helper::getInstance();

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');


$adminmenu[] = [
    'title' => _MI_TDMMONEY_MANAGER_INDEX,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
];

$adminmenu[] = [
    'title' => _MI_TDMMONEY_MANAGER_ACCOUNT,
    'link'  => 'admin/account.php',
    'icon'  => $pathIcon32 . '/manage.png'
];
$adminmenu[] = [
    'title' => _MI_TDMMONEY_MANAGER_CATEGORY,
    'link'  => 'admin/category.php',
    'icon'  => $pathIcon32 . '/category.png'
];
$adminmenu[] = [
    'title' => _MI_TDMMONEY_MANAGER_OPERATION,
    'link'  => 'admin/operation.php',
    'icon'  => $pathIcon32 . '/exec.png'
];
$adminmenu[] = [
    'title' => _MI_TDMMONEY_MANAGER_PERMISSIONS,
    'link'  => 'admin/permissions.php',
    'icon'  => $pathIcon32 . '/permissions.png'
];

$adminmenu[] = [
    'title' => _MI_TDMMONEY_MANAGER_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
];
