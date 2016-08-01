<?php

require_once('tcpdf.php');

// create new PDF document
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('dejavusans', '', 12);
        // Page number

        $this->Cell(0, 10, 'Σελίδα ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

//PDF_PAGE_ORIENTATION
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Total User Statistics');
$pdf->SetTitle('Total User Statistics');
$pdf->SetSubject('Total User Statistics');
$pdf->SetKeywords('Total User Statistics');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . 'Total User Statistics', PDF_HEADER_STRING, array(255, 255, 255), array(255, 255, 255));
$pdf->setFooterData(array(255, 255, 255), array(255, 255, 255));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__helvetica) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 12, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.0, 'depth_h' => 0.0, 'color' => array(0, 0, 0), 'opacity' => 0, 'blend_mode' => 'Normal'));

//$htm0 = ' <p> ' . $monada_id .  ' <p> ' . $date_before .  ' <p> ' . $date_after .  '     ';
//$pdf->writeHTML($htm0, true, false, true, false, '');

$header1 = '<table style="font-size:12px; text-align:center;"><tr><td><u>ΠΙΝΑΚΑΣ</u></td></tr>'
        . '<tr><td><u>ΣΤΑΤΙΣΤΙΚΩΝ ΣΤΟΙΧΕΙΩΝ ΓΙΑ ΤΙΣ ΕΞΟΥΔΕΤΕΡΩΣΕΙΣ-ΚΑΤΑΣΤΡΟΦΕΣ ΠΥΡΟΜΑΧΙΚΩΝ ΚΑΙ ΕΚΡΗΚΤΙΚΩΝ ΜΗΧΑΝΙΣΜΩΝ</u></td></tr>'
        . '<tr><td><u>ΠΟΥ ΠΡΑΓΜΑΤΟΠΟΙΗΘΗΚΑΝ ΑΠΟ ΤΟΥΣ ΠΥΡΟΤΕΧΝΟΥΡΓΟΥΣ</u></td></tr></table>';
$pdf->writeHTML($header1, true, false, true, false, '');

$queryPD1 = "SELECT * FROM peristatiko "
        . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
        . " LEFT JOIN eidos_sumvantos ON peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id "
        . " LEFT JOIN monada ON personal_details.monada_id=monada.monada_id "
        . " where personal_details.personal_details_id= '" . $personal_details_id . "' "
        . " AND peristatiko.status_id=4 "
        . " GROUP BY personal_details.personal_details_id";
$PD1 = mysql_query($queryPD1) or die('Error, query failed' . mysql_error());
$num_PD1 = mysql_num_rows($PD1);

$source_date_before = $date_before;
$date_b = new DateTime($source_date_before);
$datebefore = $date_b->format('d-m-Y');

$source_date_after = $date_after;
$date_a = new DateTime($source_date_after);
$dateafter = $date_a->format('d-m-Y');

$queryPD2 = "SELECT * FROM peristatiko "
        . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
        . " LEFT JOIN eidos_sumvantos ON peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id "
        . " LEFT JOIN monada ON personal_details.monada_id=monada.monada_id "
        . " where personal_details.personal_details_id= '" . $personal_details_id . "' "
        . " AND peristatiko.status_id=4 "
        . " AND peristatiko.ps_date BETWEEN '" . $date_before . "' AND '" . $date_after . "'"
        . " ";
$PD2 = mysql_query($queryPD2) or die('Error, query failed' . mysql_error());
$num_PD2 = mysql_num_rows($PD2);

for ($i = 0; $i < $num_PD1; $i++) {
    $peristatiko_id = mysql_result($PD1, $i, 'peristatiko_id');
    $pd_onoma = mysql_result($PD1, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD1, $i, 'pd_eponimo');
    $es_code = mysql_result($PD1, $i, 'es_code');
    $es_perigrafi = mysql_result($PD1, $i, 'es_perigrafi');
    $pd_vathmos = mysql_result($PD1, $i, 'pd_vathmos');
    $pd_oplo_soma = mysql_result($PD1, $i, 'pd_oplo_soma');
    $pd_am = mysql_result($PD1, $i, 'pd_am');
    $html = '<table style="font-size:16px; text-align:center;"><tr><td>ΒΡΕΘΗΚΑΝ ΣΥΝΟΛΙΚΑ <b><i>' . $num_PD2 . '</i></b> ΠΕΡΙΣΤΑΤΙΚΑ ΤΟΥ ΧΡΗΣΤΗ :  <b><i> ' . $pd_vathmos . ' (' . $pd_oplo_soma . ') ' . $pd_onoma . ' ' . $pd_eponimo . '</i></b></td></tr>'
            . '<tr><td>ΤΗΝ ΠΕΡΙΟΔΟ ΑΠΟ <b><i>' . $datebefore . ' </i></b>ΕΩΣ <b><i>' . $dateafter . '</i></b></td></tr></table>  ';
    $pdf->writeHTML($html, true, false, true, false, '');
}


$htm2 = '<table style="width:100%;height:100%;font-size:11px; text-align:center;padding:4px;">'
        . '<tr>'
        . '<td style="background-color: grey;border:1px solid black;width:8%">Α/Α</td>'
        . '<td style="background-color: grey;border:1px solid black;width:10%">ΜΟΝΑΔΑ</td>'
        . '<td style="background-color: grey;border:1px solid black;width:11%">ΗΜΕΡΟΜΗΝΙΑ ΠΕΡΙΣΤΑΤΙΚΟΥ</td>'
        . '<td style="background-color: grey;border:1px solid black;width:28%">ΚΑΤΗΓΟΡΙΑ ΠΕΡΙΣΤΑΤΙΚΟΥ</td>'
        . '<td style="background-color: grey;border:1px solid black;">ΠΕΡΙΓΡΑΦΗ</td>'
        . '<td style="background-color: grey;border:1px solid black;width:9%">ΠΟΣΟΤΗΤΑ</td>'
        . '<td style="background-color: grey;border:1px solid black;width:18%">ΚΩΔΙΚΟΣ</td>'
        . '</tr>'
        . '</table>';
$pdf->writeHTML($htm2, true, false, true, false, '');


for ($i = 0; $i < $num_PD2; $i++) {
    $q = $i + 1;
    $date_before = mysql_result($PD2, $i, 'ps_date');
    $monada_name = mysql_result($PD2, $i, 'monada_name');
    $source_date_before = $date_before;
    $date_b = new DateTime($source_date_before);
    $datebefore = $date_b->format('d-m-Y');

    $date_after = mysql_result($PD2, $i, 'ps_date');

    $perigrafi = mysql_result($PD2, $i, 'perigrafi');
    $quantity = mysql_result($PD2, $i, 'quantity');

    $pd_onoma = mysql_result($PD2, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD2, $i, 'pd_eponimo');
    $es_code = mysql_result($PD2, $i, 'es_code');
    $es_perigrafi = mysql_result($PD2, $i, 'es_perigrafi');
    $pd_vathmos = mysql_result($PD2, $i, 'pd_vathmos');
    $pd_oplo_soma = mysql_result($PD2, $i, 'pd_oplo_soma');
    $pd_am = mysql_result($PD2, $i, 'pd_am');

    $htm3 = '<table style="width:100%;height:100%;font-size:11px; text-align:center;padding:4px;">'
            . '<tr>'
            . '<td style="background-color: white;border:1px solid black;width:8%">' . $q . '</td>'
            . '<td style="background-color: white;border:1px solid black;width:10%">' . $monada_name . '</td>'
            . '<td style="background-color: white;border:1px solid black;width:11%">' . $datebefore . '</td>'
            . '<td style="background-color: white;border:1px solid black;width:28%">' . $es_code . ' ' . $es_perigrafi . '</td>'
            . '<td style="background-color: white;border:1px solid black;">' . $perigrafi . ' </td>'
            . '<td style="background-color: white;border:1px solid black;width:9%">' . $quantity . ' </td>'
            . '<td style="background-color: white;border:1px solid black;width:18%">' . $peristatiko_id . ' </td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($htm3, true, false, true, false, '');
}

$pdf->lastPage();
// ---------------------------------------------------------
// // Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Total Statistics.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
