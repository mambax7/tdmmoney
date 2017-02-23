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

include 'header.php';
//Affichage de la partie haute de l'administration de Xoops
xoops_cp_header();
//compte le nombre de comptes
$count_account = $accountHandler->getCount();
//compte le nombre de catégories
$count_category = $categoryHandler->getCount();
//compte le nombre d'opération catégories
$count_operation = $operationHandler->getCount();

if (TDMMoney_checkModuleAdmin()){
    $index_admin = new ModuleAdmin();
    $index_admin->addInfoBox(_AM_TDMMONEY_MANAGER_ACCOUNT);
    $index_admin->addInfoBox(_AM_TDMMONEY_MANAGER_CATEGORY);
    $index_admin->addInfoBox(_AM_TDMMONEY_MANAGER_OPERATION);
    if ($count_account == 0){
        $index_admin->addInfoBoxLine(_AM_TDMMONEY_MANAGER_ACCOUNT, _AM_TDMMONEY_THEREARE_ACCOUNT, $count_account, 'Red');
    }else{
        $index_admin->addInfoBoxLine(_AM_TDMMONEY_MANAGER_ACCOUNT, _AM_TDMMONEY_THEREARE_ACCOUNT, $count_account, 'Green');
    }
    if ($count_category == 0){
        $index_admin->addInfoBoxLine(_AM_TDMMONEY_MANAGER_CATEGORY, _AM_TDMMONEY_THEREARE_CATEGORY, $count_category, 'Red');
    }else{
        $index_admin->addInfoBoxLine(_AM_TDMMONEY_MANAGER_CATEGORY, _AM_TDMMONEY_THEREARE_CATEGORY, $count_category, 'Green');
    }
    if ($count_operation == 0){
        $index_admin->addInfoBoxLine(_AM_TDMMONEY_MANAGER_OPERATION, _AM_TDMMONEY_THEREARE_OPERATION, $count_operation, 'Red');
    }else{
        $index_admin->addInfoBoxLine(_AM_TDMMONEY_MANAGER_OPERATION, _AM_TDMMONEY_THEREARE_OPERATION, $count_operation, 'Green');
    }
    echo $index_admin->addNavigation('index.php');
    echo $index_admin->renderIndex();
}
xoops_cp_footer();
?>