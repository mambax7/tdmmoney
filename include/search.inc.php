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
 * @param $queryarray
 * @param $andor
 * @param $limit
 * @param $offset
 * @param $userid
 * @return array
 */

function tdmmoney_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $sql = 'SELECT operation_id, operation_account, operation_category, operation_type, operation_sender, operation_outsender, operation_date, operation_amount, operation_description, operation_submitter, operation_date_created FROM '
           . $xoopsDB->prefix('tdmmoney_operation')
           . ' WHERE operation_date != 0';

    if (0 != $userid) {
        $sql .= ' AND operation_submitter=' . (int)$userid . ' ';
    }
    require_once XOOPS_ROOT_PATH . '/modules/tdmmoney/class/Utility.php';
    $access_view = Tdmmoney\Utility::getMygetItemIds('tdmmoney_view', 'TDMMoney');
    if (is_array($access_view) && count($access_view) > 0) {
        $sql .= ' AND operation_account IN (' . implode(',', $access_view) . ') ';
    } else {
        return null;
    }

    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((operation_description LIKE '%$queryarray[0]%' OR operation_outsender LIKE '%$queryarray[0]%')";

        for ($i = 1; $i < $count; ++$i) {
            $sql .= " $andor ";
            $sql .= "(operation_description LIKE '%$queryarray[$i]%' OR operation_outsender LIKE '%$queryarray[$i]%')";
        }
        $sql .= ')';
    }

    $sql    .= ' ORDER BY operation_date DESC';
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret    = [];
    $i      = 0;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'assets/images/deco/contact.png';
        $ret[$i]['link']  = 'viewaccount.php?account_id=' . $myrow['operation_account'] . '';
        $ret[$i]['title'] = $myrow['operation_amount'] . '-' . $myrow['operation_description'];
        $ret[$i]['time']  = $myrow['operation_date_created'];
        $ret[$i]['uid']   = $myrow['operation_submitter'];
        ++$i;
    }

    return $ret;
}
