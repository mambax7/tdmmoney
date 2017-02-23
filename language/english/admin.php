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

//general.php
define('_AM_TDMMONEY_ACTION', 'Action');
define('_AM_TDMMONEY_DEL', 'Remove');
define('_AM_TDMMONEY_DISPLAY', 'Display');
define('_AM_TDMMONEY_EDIT', 'Edit');
define('_AM_TDMMONEY_SUREDEL', "Are you sure to delete: <b><span style='color : Red'> %s </span></b>");

//index.php
define('_AM_TDMMONEY_MANAGER_ABOUT', 'About');
define('_AM_TDMMONEY_MANAGER_ACCOUNT', 'Account');
define('_AM_TDMMONEY_MANAGER_CATEGORY', 'Category');
define('_AM_TDMMONEY_MANAGER_INDEX', 'Index');
define('_AM_TDMMONEY_MANAGER_OPERATION', 'Operation');
define('_AM_TDMMONEY_MANAGER_PERMISSIONS', 'Permissions');
define('_AM_TDMMONEY_MANAGER_PREFERENCES', 'Preferences');
define('_AM_TDMMONEY_MANAGER_UPDATE', 'Update');
define('_AM_TDMMONEY_THEREARE_ACCOUNT', 'There is %s Accounts in our database');
define('_AM_TDMMONEY_THEREARE_CATEGORY', 'There is %s categories in our database');
define('_AM_TDMMONEY_THEREARE_OPERATION', 'There is %s operations in our database');

//category.php
define('_AM_TDMMONEY_CAT_ADD', 'Add a category');
define('_AM_TDMMONEY_CAT_DELOK', 'Category deleted successfully ');
define('_AM_TDMMONEY_CAT_DELOPERATION', 'with the following operation:');
define('_AM_TDMMONEY_CAT_DSC', 'Category Description');
define('_AM_TDMMONEY_CAT_DELSOUSCAT', 'The following sub categories are also deleted:');
define('_AM_TDMMONEY_CAT_EDIT', 'Edit category %s');
define('_AM_TDMMONEY_CAT_ERREUR_CAT', 'You cannot use this category (loop on itself)');
define('_AM_TDMMONEY_CAT_ERREUR_WEIGHT', 'The weight must be a number');
define('_AM_TDMMONEY_CAT_LIST', 'List of categories');
define('_AM_TDMMONEY_CAT_NEW', 'New Category');
define('_AM_TDMMONEY_CAT_SAVE', 'The category was saved');
define('_AM_TDMMONEY_CAT_SUBCAT', 'Sub Category');
define('_AM_TDMMONEY_CAT_TITLE', 'Category Title');
define('_AM_TDMMONEY_CAT_WEIGHT', 'Category Weight');
define('_AM_TDMMONEY_CAT_WEIGHT2', 'Weight');

//account.php
define('_AM_TDMMONEY_ACCOUNT_ADD', 'Add an Account');
define('_AM_TDMMONEY_ACCOUNT_ADRESS', 'Bank Address');
define('_AM_TDMMONEY_ACCOUNT_BALANCE', 'Initial Balance of the Account');
define('_AM_TDMMONEY_ACCOUNT_BALANCE2', 'Account Balance');
define('_AM_TDMMONEY_ACCOUNT_BANK', 'Bank Name');
define('_AM_TDMMONEY_ACCOUNT_CURRENCY', 'Account Currency');
define('_AM_TDMMONEY_ACCOUNT_DELOK', 'Account deleted successfully');
define('_AM_TDMMONEY_ACCOUNT_EDIT', 'Edit the Account %s');
define('_AM_TDMMONEY_ACCOUNT_ERREUR_BALANCE', 'The balance must be a number');
define('_AM_TDMMONEY_ACCOUNT_LIST', 'Account List');
define('_AM_TDMMONEY_ACCOUNT_NAME', 'Account Name');
define('_AM_TDMMONEY_ACCOUNT_NEW', 'New Account');
define('_AM_TDMMONEY_ACCOUNT_SAVE', 'The account was saved');

//operation.php
define('_AM_TDMMONEY_OPERATION_ACCOUNT', 'Account');
define('_AM_TDMMONEY_OPERATION_ADD', 'Add an operation');
define('_AM_TDMMONEY_OPERATION_ALL', 'All Accounts');
define('_AM_TDMMONEY_OPERATION_AMOUNT', 'Amount');
define('_AM_TDMMONEY_OPERATION_BALANCE', 'Balance');
define('_AM_TDMMONEY_OPERATION_CATEGORY', 'Category');
define('_AM_TDMMONEY_OPERATION_DATE', 'Date');
define('_AM_TDMMONEY_OPERATION_DELOK', 'Operation deleted successfully ');
define('_AM_TDMMONEY_OPERATION_DEPOSIT', 'Deposit');
define('_AM_TDMMONEY_OPERATION_DESCRIPTION', 'Description');
define('_AM_TDMMONEY_OPERATION_EDIT', 'Edit Operation %s');
define('_AM_TDMMONEY_OPERATION_END', 'End');
define('_AM_TDMMONEY_OPERATION_ERREUR_AMOUNT', 'The amount must be a number');
define('_AM_TDMMONEY_OPERATION_EXPORTPDF', 'Export the list in PDF');
define('_AM_TDMMONEY_OPERATION_FILTER', 'Filter operations');
define('_AM_TDMMONEY_OPERATION_LIST', 'Operations List');
define('_AM_TDMMONEY_OPERATION_LISTBYACCOUNT', 'Show operations of the account: ');
define('_AM_TDMMONEY_OPERATION_NEW', 'New Operation');
define('_AM_TDMMONEY_OPERATION_OUTSIDE', 'Outside -->');
define('_AM_TDMMONEY_OPERATION_REPORT', 'Balance Report to ');
define('_AM_TDMMONEY_OPERATION_TYPE', 'Operation Type');
define('_AM_TDMMONEY_OPERATION_SAVE', 'The operation was saved');
define('_AM_TDMMONEY_OPERATION_START', 'Start');
define('_AM_TDMMONEY_OPERATION_SENDER', 'Sender');
define('_AM_TDMMONEY_OPERATION_OUTSENDER', 'or outside the website');
define('_AM_TDMMONEY_OPERATION_WITHDRAW', 'Withdrawal');

//operation_pdf.php
define('_AM_TDMMONEY_PDF_ACCOUNT', 'Account');
define('_AM_TDMMONEY_PDF_CURRENCY', 'in');
define('_AM_TDMMONEY_PDF_STATEMENT', 'Extract from the account of');
define('_AM_TDMMONEY_PDF_TO', 'To');
define('_AM_TDMMONEY_PDF_NOACCOUNT', 'You have not selected an account');

//Permissions
define('_AM_TDMMONEY_PERMISSIONS_4', 'Add Operations');
define('_AM_TDMMONEY_PERMISSIONS_8', 'Edit Operations');
define('_AM_TDMMONEY_PERMISSIONS_16', 'Export in PDF');
define('_AM_TDMMONEY_PERMISSIONS_OTHER', 'Other permissions');
define('_AM_TDMMONEY_PERMISSIONS_OTHER_DSC', 'Select groups that may:');
define('_AM_TDMMONEY_PERMISSIONS_SUBMIT', 'Submit Permissions ');
define('_AM_TDMMONEY_PERMISSIONS_SUBMIT_DSC', 'Select groups that may submit operations in the accounts:');
define('_AM_TDMMONEY_PERMISSIONS_VIEW', 'View Permissions');
define('_AM_TDMMONEY_PERMISSIONS_VIEW_DSC', 'Choose groups that can view the accounts:');

//PDF
define('_AM_TDMMONEY_PDF_NOACCOUNTS', 'No account selected');
//1.2
define('_AM_TDMMONEY_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('_AM_TDMMONEY_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('_AM_TDMMONEY_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('_AM_TDMMONEY_ERROR_COLUMN', 'Could not create column in database : %s');
define('_AM_TDMMONEY_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('_AM_TDMMONEY_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('_AM_TDMMONEY_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');
