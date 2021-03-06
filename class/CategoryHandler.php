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

use XoopsModules\Tdmmoney;

defined('XOOPS_ROOT_PATH') || die('Restricted access');

/**
 * Class CategoryHandler
 */
class CategoryHandler extends \XoopsPersistableObjectHandler
{
    /**
     * CategoryHandler constructor.
     * @param null|object|\XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'tdmmoney_category', Category::class, 'cat_cid', 'cat_title');
    }
}
