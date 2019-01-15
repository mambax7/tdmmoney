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

require_once __DIR__ . '/header.php';
// template d'affichage
$GLOBALS['xoopsOption']['template_main'] = 'tdmmoney_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

// pour les permissions
$access_account = Tdmmoney\Utility::getMygetItemIds('tdmmoney_view', $moduleDirName);
$criteria       = new \CriteriaCompo();
$criteria->add(new \Criteria('account_id', '(' . implode(',', $access_account) . ')', 'IN'));
$criteria->setSort('account_name');
$criteria->setOrder('ASC');
$accountArray = $accountHandler->getAll($criteria);
//pour le calcul des soldes:
$criteria = new \CriteriaCompo();
$criteria->setSort('operation_account');
$criteria->setOrder('ASC');
$operationArray = $operationHandler->getAll($criteria);

$count = 1;
foreach (array_keys($accountArray) as $i) {
    /*$criteria_operation = new \CriteriaCompo();
    $criteria_operation->add(new \Criteria('operation_account', $i));
    $operationArray = $operationHandler->getAll($criteria_operation);*/
    //calcul des soldes
    $balanceOperation = $accountArray[$i]->getVar('account_balance');
    foreach (array_keys($operationArray) as $j) {
        /** @var \XoopsModules\Tdmmoney\Account[] $accountArray */
        /** @var \XoopsModules\Tdmmoney\Operation[] $operationArray */
        if ($operationArray[$j]->getVar('operation_account') == $accountArray[$i]->getVar('account_id')) {
            $balanceOperation = 1 == $operationArray[$j]->getVar('operation_type') ? $balanceOperation - $operationArray[$j]->getVar('operation_amount') : $balanceOperation + $operationArray[$j]->getVar('operation_amount');
        }
    }
    $displayBalanceOperation = $balanceOperation < 0 ? '<span style="color: #ff0000; font-weight: bold;">' . $balanceOperation . '</span>' : '<span style="font-weight: bold;">' . $balanceOperation . '</span>';
    $xoopsTpl->append('account', [
        'account_id'   => $accountArray[$i]->getVar('account_id'),
        'account_name' => $accountArray[$i]->getVar('account_name'),
        'balance'      => $displayBalanceOperation,
        'count'        => $count,
    ]);
    ++$count;
}

require_once XOOPS_ROOT_PATH . '/footer.php';
