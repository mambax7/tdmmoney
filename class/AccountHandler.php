<?php

namespace XoopsModules\Tdmmoney;

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

//defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class TDMMoneytdmmoney_accountHandler
 */
class AccountHandler extends \XoopsPersistableObjectHandler
{
    /**
     * AccountHandler constructor.
     * @param null|\XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'tdmmoney_account', Account::class, 'account_id', 'account_name');
    }
}
