<?php
/**
 * File : makepdf.php for publisher
 * For tcpdf_for_xoops 2.01 and higher
 * Created by montuy337513 / philodenelle - http://www.chg-web.org
 */

use \Xmf\Request;

error_reporting(E_ALL);

require_once __DIR__ . '/header.php';

$account_id = Request::getInt('account_id', 0, 'GET');
$date_start = Request::getInt('date_start', -1, 'GET');
$date_end   = Request::getInt('date_end', -1, 'GET');

if ($account_id == 0) {
    redirect_header('../index.php', 2, _AM_TDMMONEY_PDF_NOACCOUNTS);
}
//permissions
$perm_pdf = $gpermHandler->checkRight('tdmmoney_ac', 16, $groups, $xoopsModule->getVar('mid')) ? true : false;
if ($perm_pdf === false) {
    redirect_header('../index.php', 2, _NOPERM);
}
//2.5.8
require_once XOOPS_ROOT_PATH . '/class/libraries/vendor/tecnickcom/tcpdf/tcpdf.php';

xoops_loadLanguage('main', PUBLISHER_DIRNAME);

// Génération du pdf
//$pdf = new phpToPDF();
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);
$pdf->AddPage();

//$pdf->startPageNums();

// Définition des propriétés du tableau.
$proprietesTableau = [
    'TB_ALIGN'  => 'L',
    'L_MARGIN'  => 5,
    'BRD_COLOR' => [
        0,
        0,
        0
    ],
    'BRD_SIZE'  => '0.3',
];

// Définition des propriétés du header du tableau.
$proprieteHeader = [
    'T_COLOR'           => [
        0,
        0,
        0
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
        192
    ],
    'BG_COLOR'          => [
        192,
        192,
        192
    ],
    'BRD_COLOR'         => [
        0,
        0,
        0
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
    '[BR]' . utf8_decode(_AM_TDMMONEY_OPERATION_BALANCE)
];

// Définition des propriétés du reste du contenu du tableau.
$proprieteContenu = [
    'T_COLOR'           => [
        0,
        0,
        0
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
        255
    ],
    'BG_COLOR'          => [
        255,
        255,
        255
    ],
    'BRD_COLOR'         => [
        0,
        0,
        0
    ],
    'BRD_SIZE'          => 0.1,
    'BRD_TYPE'          => 'T',
    'BRD_TYPE_NEW_PAGE' => '',
];
$account          = $accountHandler->get($account_id);
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
    $balance_ammount = $operation_ammount[$i]->getVar('operation_type') == 1 ? $balance_ammount - $operation_ammount[$i]->getVar('operation_amount') : $balance_ammount + $operation_ammount[$i]->getVar('operation_amount');
}
$balance      += $balance_ammount;
$balance_save = $balance;
foreach (array_keys($operation_balance_arr) as $i) {
    $balance               = $operation_balance_arr[$i]->getVar('operation_type') == 1 ? $balance - $operation_balance_arr[$i]->getVar('operation_amount') : $balance + $operation_balance_arr[$i]->getVar('operation_amount');
    $operation_balance[$i] = $balance;
}

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, _CHARSET, false);

//$doc_title  = TdmmoneyUtility::convertCharset($myts->undoHtmlSpecialChars($itemObj->getTitle()));
//$docSubject = $myts->undoHtmlSpecialChars($categoryObj->name());

//$docKeywords = $myts->undoHtmlSpecialChars($itemObj->meta_keywords());
if (array_key_exists('rtl', $pdf_data)) {
    $pdf->setRTL($pdf_data['rtl']);
}
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor(PDF_AUTHOR);
$pdf->SetTitle($doc_title);
$pdf->SetSubject($docSubject);
//$pdf->SetKeywords(XOOPS_URL . ', '.' by TCPDF_for_XOOPS (chg-web.org), '.$doc_title);
$pdf->SetKeywords($docKeywords);

$firstLine  = TdmmoneyUtility::convertCharset($GLOBALS['xoopsConfig']['sitename']) . ' (' . XOOPS_URL . ')';
$secondLine = TdmmoneyUtility::convertCharset($GLOBALS['xoopsConfig']['slogan']);

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $firstLine, $secondLine);
$pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $firstLine, $secondLine, [0, 64, 255], [0, 64, 128]);

//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); //set image scale factor

//2.5.8
$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);

$pdf->setFooterData($tc = [0, 64, 0], $lc = [0, 64, 128]);

//initialize document
$pdf->Open();
$pdf->AddPage();
$pdf->writeHTML($content, true, 0, true, 0);
$pdf->Output();
