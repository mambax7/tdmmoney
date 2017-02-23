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

function xoops_module_update_tdmmoney()
{
    $db  = XoopsDatabaseFactory::getDatabaseConnection();
    $sql = 'ALTER TABLE `' . $db->prefix('tdmmoney_account') . "` CHANGE `account_balance` `account_balance` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00' ;";
    $db->query($sql);
    $sql = 'ALTER TABLE `' . $db->prefix('tdmmoney_operation') . "` CHANGE `operation_amount` `operation_amount` DECIMAL( 10, 2 ) NOT NULL DEFAULT '0.00' ;";
    $db->query($sql);
    $sql = 'ALTER TABLE `' . $db->prefix('tdmmoney_category') . '` DROP `cat_budget` ;';
    $db->query($sql);
    $sql = 'ALTER TABLE `' . $db->prefix('tdmmoney_category') . '` DROP `cat_type` ;';
    $db->query($sql);
    $sql = 'ALTER TABLE `' . $db->prefix('tdmmoney_category') . '` DROP `cat_interval` ;';
    $db->query($sql);

    return true;
}
