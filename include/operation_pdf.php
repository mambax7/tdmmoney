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

include __DIR__ . '/../fpdf/phpToPDF.php';
include __DIR__ . '/../admin/header.php';

$account_id = TDMMoney_CleanVars($_REQUEST, 'account_id', 0, 'int');
$date_start = TDMMoney_CleanVars($_REQUEST, 'date_start', 0, 'int');
$date_end   = TDMMoney_CleanVars($_REQUEST, 'date_end', 0, 'int');

if ($account_id == 0) {
    redirect_header('../index.php', 2, _AM_TDMMONEY_PDF_NOACCOUNTS);
    exit();
}
//permissions
$perm_pdf = $gpermHandler->checkRight('tdmmoney_ac', 16, $groups, $xoopsModule->getVar('mid')) ? true : false;
if ($perm_pdf === false) {
    redirect_header('../index.php', 2, _NOPERM);
}
// Génération du pdf
$PDF = new phpToPDF();
$PDF->AddPage();

$PDF->startPageNums();

// Définition des propriétés du tableau.
$proprietesTableau = array(
    'TB_ALIGN'  => 'L',
    'L_MARGIN'  => 5,
    'BRD_COLOR' => array(
        0,
        0,
        0
    ),
    'BRD_SIZE'  => '0.3',
);

// Définition des propriétés du header du tableau.
$proprieteHeader = array(
    'T_COLOR'           => array(
        0,
        0,
        0
    ),
    'T_SIZE'            => 10,
    'T_FONT'            => 'Arial',
    'T_ALIGN_COL0'      => 'L',
    'T_ALIGN'           => 'L',
    'V_ALIGN'           => 'M',
    'T_TYPE'            => 'B',
    'LN_SIZE'           => 7,
    'BG_COLOR_COL0'     => array(
        192,
        192,
        192
    ),
    'BG_COLOR'          => array(
        192,
        192,
        192
    ),
    'BRD_COLOR'         => array(
        0,
        0,
        0
    ),
    'BRD_SIZE'          => 0.2,
    'BRD_TYPE'          => '0',
    'BRD_TYPE_NEW_PAGE' => '',
);

// Contenu du header du tableau.
$contenuHeader = array(
    25,
    35,
    25,
    50,
    20,
    20,
    20,
    '[B]' . utf8_decode(_AM_TDMMONEY_OPERATION_DATE),
    '[B]' . utf8_decode(_AM_TDMMONEY_OPERATION_SENDER),
    '[B]' . utf8_decode(_AM_TDMMONEY_OPERATION_CATEGORY),
    '[B]' . utf8_decode(_AM_TDMMONEY_OPERATION_DESCRIPTION),
    '[BC]' . utf8_decode(_AM_TDMMONEY_OPERATION_WITHDRAW),
    '[BC]' . utf8_decode(_AM_TDMMONEY_OPERATION_DEPOSIT),
    '[BR]' . utf8_decode(_AM_TDMMONEY_OPERATION_BALANCE)
);

// Définition des propriétés du reste du contenu du tableau.
$proprieteContenu = array(
    'T_COLOR'           => array(
        0,
        0,
        0
    ),
    'T_SIZE'            => 10,
    'T_FONT'            => 'Arial',
    'T_ALIGN_COL0'      => 'L',
    'T_ALIGN'           => 'R',
    'V_ALIGN'           => 'T',
    'T_TYPE'            => '',
    'LN_SIZE'           => 6,
    'BG_COLOR_COL0'     => array(
        255,
        255,
        255
    ),
    'BG_COLOR'          => array(
        255,
        255,
        255
    ),
    'BRD_COLOR'         => array(
        0,
        0,
        0
    ),
    'BRD_SIZE'          => 0.1,
    'BRD_TYPE'          => 'T',
    'BRD_TYPE_NEW_PAGE' => '',
);
$account          =& $accountHandler->get($account_id);
$criteria         = new CriteriaCompo();
$criteria->add(new Criteria('operation_account', $account_id));
$criteria->add(new Criteria('operation_date', $date_start, '>='));
$criteria->add(new Criteria('operation_date', $date_end, '<='));
$criteria->setSort('operation_date');
$criteria->setOrder('DESC');
//pour faire une jointure de table
$operationHandler->table_link   = $operationHandler->db->prefix('tdmmoney_category'); // Nom de la table en jointure
$operationHandler->field_link   = 'cat_cid'; // champ de la table en jointure
$operationHandler->field_object = 'operation_category'; // champ de la table courante

$operation_arr = $operationHandler->getByLink($criteria);

// Calcul des soldes
$operation_balance_arr = array_reverse($operation_arr, true);
$balance               = $account->getVar('account_balance');
$criteria_amount       = new CriteriaCompo();
$criteria_amount->add(new Criteria('operation_account', $account_id));
$criteria_amount->add(new Criteria('operation_date', $date_start, '<'));
$operation_ammount = $operationHandler->getall($criteria_amount);
$balance_ammount   = 0;
foreach (array_keys($operation_ammount) as $i) {
    $balance_ammount = $operation_ammount[$i]->getVar('operation_type') == 1 ? $balance_ammount - $operation_ammount[$i]->getVar('operation_amount') : $balance_ammount
                                                                                                                                                       + $operation_ammount[$i]->getVar('operation_amount');
}
$balance      += $balance_ammount;
$balance_save = $balance;
foreach (array_keys($operation_balance_arr) as $i) {
    $balance               = $operation_balance_arr[$i]->getVar('operation_type') == 1 ? $balance - $operation_balance_arr[$i]->getVar('operation_amount') : $balance
                                                                                                                                                             + $operation_balance_arr[$i]->getVar('operation_amount');
    $operation_balance[$i] = $balance;
}

$PDF->SetFont('Arial', '', 12);
$PDF->Cell(5);
$PDF->Cell(100, 8, $account->getVar('account_bank'), 0, 1, 'L');
$PDF->Cell(5);
$PDF->MultiCell(100, 5, str_replace('<br>', "\n", $account->getVar('account_adress')), 0, 'L', 0);
$PDF->Cell(5);
$PDF->Cell(10, 8, '', 0, 1, 'L');
$PDF->Cell(5);
$PDF->SetFont('Arial', 'B', 14);
$PDF->Cell(100, 8, _AM_TDMMONEY_PDF_STATEMENT . ' ' . formatTimestamp($date_start, 's') . ' ' . _AM_TDMMONEY_PDF_TO . ' ' . formatTimestamp($date_end, 's'), 0, 1, 'L');
$PDF->Cell(5);
$PDF->Cell(10, 5, '', 0, 1, 'L');
$PDF->Cell(5);
$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(100, 8, _AM_TDMMONEY_OPERATION_BALANCE . ' ' . $balance . ' ' . $account->getVar('account_currency'), 0, 1, 'L');
$PDF->Cell(5);
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(190, 8, _AM_TDMMONEY_PDF_ACCOUNT . ': ' . $account->getVar('account_name') . ' ' . _AM_TDMMONEY_PDF_CURRENCY . ' ' . $account->getVar('account_currency'), 0, 1, 'R');

$j = 0;
foreach (array_keys($operation_arr) as $i) {
    $contenuTableau[$j] = formatTimestamp($operation_arr[$i]->getVar('operation_date'), 's');
    ++$j;
    if ($operation_arr[$i]->getVar('operation_sender') == 0) {
        if ($operation_arr[$i]->getVar('operation_outsender') == '') {
            $contenuTableau[$j] = utf8_decode(XoopsUser::getUnameFromId($operation_arr[$i]->getVar('operation_sender'), 1));
        } else {
            $contenuTableau[$j] = utf8_decode($operation_arr[$i]->getVar('operation_outsender'));
        }
    } else {
        $contenuTableau[$j] = utf8_decode(XoopsUser::getUnameFromId($operation_arr[$i]->getVar('operation_sender'), 1));
    }
    ++$j;
    $contenuTableau[$j] = utf8_decode($operation_arr[$i]->getVar('cat_title'));
    ++$j;
    $contenuTableau[$j] = utf8_decode($operation_arr[$i]->getVar('operation_description'));
    ++$j;
    $contenuTableau[$j] = $operation_arr[$i]->getVar('operation_type') == 1 ? '[C]' . $operation_arr[$i]->getVar('operation_amount') : '';
    ++$j;
    $contenuTableau[$j] = $operation_arr[$i]->getVar('operation_type') == 2 ? '[C]' . $operation_arr[$i]->getVar('operation_amount') : '';
    ++$j;
    $contenuTableau[$j] = '[R]' . $operation_balance[$i];
    ++$j;
}

$contenuTableau[$j] = _AM_TDMMONEY_OPERATION_REPORT . formatTimestamp($date_start - 86400, 's');
++$j;
$contenuTableau[$j] = 'COLSPAN2';
++$j;
$contenuTableau[$j] = '';
++$j;
$contenuTableau[$j] = '';
++$j;
$contenuTableau[$j] = '';
++$j;
$contenuTableau[$j] = '';
++$j;
$contenuTableau[$j] = '[R]' . $balance_save;

// D'abord le PDF, puis les propriétés globales du tableau.
// Ensuite, le header du tableau (propriétés et données) puis le contenu (propriétés et données)
$PDF->drawTableau($PDF, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau);

$PDF->Output();
