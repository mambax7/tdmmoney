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

//use tecnickcom\tcpdf;
use XoopsModules\Tdmmoney;

require_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';

require_once XOOPS_ROOT_PATH . '/class/libraries/vendor/tecnickcom/tcpdf/tcpdf.php';
//require_once dirname(__DIR__) . '/fpdf/phpToPDF.php';
require_once dirname(__DIR__) . '/admin/admin_header.php';

$accountId  = Tdmmoney\Utility::cleanVars($_REQUEST, 'account_id', 0, 'int');
$date_start = Tdmmoney\Utility::cleanVars($_REQUEST, 'date_start', 0, 'int');
$date_end   = Tdmmoney\Utility::cleanVars($_REQUEST, 'date_end', 0, 'int');

if (0 == $accountId) {
    redirect_header('../index.php', 2, _AM_TDMMONEY_PDF_NOACCOUNTS);
}
//permissions
$perm_pdf = $grouppermHandler->checkRight('tdmmoney_ac', 16, $groups, $xoopsModule->getVar('mid')) ? true : false;
if (false === $perm_pdf) {
    redirect_header('../index.php', 2, _NOPERM);
}
// Génération du pdf
//$pdf = new phpToPDF();
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);
$pdf->AddPage();

$pdf->startPageNums();

// Définition des propriétés du tableau.
$proprietesTableau = [
    'TB_ALIGN'  => 'L',
    'L_MARGIN'  => 5,
    'BRD_COLOR' => [
        0,
        0,
        0,
    ],
    'BRD_SIZE'  => '0.3',
];

// Définition des propriétés du header du tableau.
$proprieteHeader = [
    'T_COLOR'           => [
        0,
        0,
        0,
    ],
    'T_SIZE'            => 10,
    'T_FONT'            => 'Arial',
    'T_ALIGN_COL0'      => 'L',
    'T_ALIGN'           => 'L',
    'V_ALIGN'           => 'M',
    'T_TYPE'            => 'B',
    'LN_SIZE'           => 7,
    'BG_COLOR_COL0'     => [
        192,
        192,
        192,
    ],
    'BG_COLOR'          => [
        192,
        192,
        192,
    ],
    'BRD_COLOR'         => [
        0,
        0,
        0,
    ],
    'BRD_SIZE'          => 0.2,
    'BRD_TYPE'          => '0',
    'BRD_TYPE_NEW_PAGE' => '',
];

// Contenu du header du tableau.
$contenuHeader = [
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
    '[BR]' . utf8_decode(_AM_TDMMONEY_OPERATION_BALANCE),
];

// Définition des propriétés du reste du contenu du tableau.
$proprieteContenu = [
    'T_COLOR'           => [
        0,
        0,
        0,
    ],
    'T_SIZE'            => 10,
    'T_FONT'            => 'Arial',
    'T_ALIGN_COL0'      => 'L',
    'T_ALIGN'           => 'R',
    'V_ALIGN'           => 'T',
    'T_TYPE'            => '',
    'LN_SIZE'           => 6,
    'BG_COLOR_COL0'     => [
        255,
        255,
        255,
    ],
    'BG_COLOR'          => [
        255,
        255,
        255,
    ],
    'BRD_COLOR'         => [
        0,
        0,
        0,
    ],
    'BRD_SIZE'          => 0.1,
    'BRD_TYPE'          => 'T',
    'BRD_TYPE_NEW_PAGE' => '',
];
$account          = $accountHandler->get($accountId);
$criteria         = new \CriteriaCompo();
$criteria->add(new \Criteria('operation_account', $accountId));
$criteria->add(new \Criteria('operation_date', $date_start, '>='));
$criteria->add(new \Criteria('operation_date', $date_end, '<='));
$criteria->setSort('operation_date');
$criteria->setOrder('DESC');
//pour faire une jointure de table
$operationHandler->table_link   = $operationHandler->db->prefix('tdmmoney_category'); // Nom de la table en jointure
$operationHandler->field_link   = 'cat_cid'; // champ de la table en jointure
$operationHandler->field_object = 'operation_category'; // champ de la table courante

$operationArray = $operationHandler->getByLink($criteria);

// Calcul des soldes
$operation_balance_arr = array_reverse($operationArray, true);
$balance               = $account->getVar('account_balance');
$criteria_amount       = new \CriteriaCompo();
$criteria_amount->add(new \Criteria('operation_account', $accountId));
$criteria_amount->add(new \Criteria('operation_date', $date_start, '<'));
$operationAmmount = $operationHandler->getAll($criteria_amount);
$balance_ammount  = 0;
foreach (array_keys($operationAmmount) as $i) {
    $balance_ammount = 1 == $operationAmmount[$i]->getVar('operation_type') ? $balance_ammount - $operationAmmount[$i]->getVar('operation_amount') : $balance_ammount + $operationAmmount[$i]->getVar('operation_amount');
}
$balance      += $balance_ammount;
$balance_save = $balance;
foreach (array_keys($operation_balance_arr) as $i) {
    $balance               = 1 == $operation_balance_arr[$i]->getVar('operation_type') ? $balance - $operation_balance_arr[$i]->getVar('operation_amount') : $balance + $operation_balance_arr[$i]->getVar('operation_amount');
    $operation_balance[$i] = $balance;
}

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(5);
$pdf->Cell(100, 8, $account->getVar('account_bank'), 0, 1, 'L');
$pdf->Cell(5);
$pdf->MultiCell(100, 5, str_replace('<br>', "\n", $account->getVar('account_adress')), 0, 'L', 0);
$pdf->Cell(5);
$pdf->Cell(10, 8, '', 0, 1, 'L');
$pdf->Cell(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(100, 8, _AM_TDMMONEY_PDF_STATEMENT . ' ' . formatTimestamp($date_start, 's') . ' ' . _AM_TDMMONEY_PDF_TO . ' ' . formatTimestamp($date_end, 's'), 0, 1, 'L');
$pdf->Cell(5);
$pdf->Cell(10, 5, '', 0, 1, 'L');
$pdf->Cell(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, _AM_TDMMONEY_OPERATION_BALANCE . ' ' . $balance . ' ' . $account->getVar('account_currency'), 0, 1, 'L');
$pdf->Cell(5);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 8, _AM_TDMMONEY_PDF_ACCOUNT . ': ' . $account->getVar('account_name') . ' ' . _AM_TDMMONEY_PDF_CURRENCY . ' ' . $account->getVar('account_currency'), 0, 1, 'R');

$j = 0;
foreach (array_keys($operationArray) as $i) {
    $contenuTableau[$j] = formatTimestamp($operationArray[$i]->getVar('operation_date'), 's');
    ++$j;
    if (0 == $operationArray[$i]->getVar('operation_sender')) {
        if ('' == $operationArray[$i]->getVar('operation_outsender')) {
            $contenuTableau[$j] = utf8_decode(\XoopsUser::getUnameFromId($operationArray[$i]->getVar('operation_sender'), 1));
        } else {
            $contenuTableau[$j] = utf8_decode($operationArray[$i]->getVar('operation_outsender'));
        }
    } else {
        $contenuTableau[$j] = utf8_decode(\XoopsUser::getUnameFromId($operationArray[$i]->getVar('operation_sender'), 1));
    }
    ++$j;
    $contenuTableau[$j] = utf8_decode($operationArray[$i]->getVar('cat_title'));
    ++$j;
    $contenuTableau[$j] = utf8_decode($operationArray[$i]->getVar('operation_description'));
    ++$j;
    $contenuTableau[$j] = 1 == $operationArray[$i]->getVar('operation_type') ? '[C]' . $operationArray[$i]->getVar('operation_amount') : '';
    ++$j;
    $contenuTableau[$j] = 2 == $operationArray[$i]->getVar('operation_type') ? '[C]' . $operationArray[$i]->getVar('operation_amount') : '';
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
$pdf->drawTableau($pdf, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau);

$pdf->Output();
