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

require_once __DIR__ . '/header.php';
// template d'affichage
$GLOBALS['xoopsOption']['template_main'] = 'tdmmoney_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

// pour les permissions
$access_account = TdmmoneyUtility::getMygetItemIds('tdmmoney_view', 'TDMMoney');
$criteria       = new CriteriaCompo();
$criteria->add(new Criteria('account_id', '(' . implode(',', $access_account) . ')', 'IN'));
$criteria->setSort('account_name');
$criteria->setOrder('ASC');
$account_arr = $accountHandler->getAll($criteria);
//pour le calcul des soldes:
$criteria = new CriteriaCompo();
$criteria->setSort('operation_account');
$criteria->setOrder('ASC');
$operation_arr = $operationHandler->getAll($criteria);

$count = 1;
foreach (array_keys($account_arr) as $i) {
    /*$criteria_operation = new CriteriaCompo();
    $criteria_operation->add(new Criteria('operation_account', $i));
    $operation_arr = $operationHandler->getall($criteria_operation);*/
    //calcul des soldes
    $balance_operation = $account_arr[$i]->getVar('account_balance');
    foreach (array_keys($operation_arr) as $j) {
        if ($operation_arr[$j]->getVar('operation_account') == $account_arr[$i]->getVar('account_id')) {
            $balance_operation = 1 == $operation_arr[$j]->getVar('operation_type') ? $balance_operation - $operation_arr[$j]->getVar('operation_amount') : $balance_operation + $operation_arr[$j]->getVar('operation_amount');
        }
    }
    $display_balance_operation = $balance_operation < 0 ? '<span style="color: #ff0000; font-weight: bold;">' . $balance_operation . '</span>' : '<span style="font-weight: bold;">' . $balance_operation . '</span>';
    $xoopsTpl->append('account', [
        'account_id'   => $account_arr[$i]->getVar('account_id'),
        'account_name' => $account_arr[$i]->getVar('account_name'),
        'balance'      => $display_balance_operation,
        'count'        => $count
    ]);
    ++$count;
}

require_once XOOPS_ROOT_PATH . '/footer.php';
