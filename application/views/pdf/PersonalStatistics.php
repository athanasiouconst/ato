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

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Personal_Statistics');
$pdf->SetTitle('Personal_Statistics');
$pdf->SetSubject('Personal_Statistics');
$pdf->SetKeywords('Personal_Statistics');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . 'Personal_Statistics', PDF_HEADER_STRING, array(255, 255, 255), array(255, 255, 255));
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

$header1 = '<table style="font-size:14px; text-align:center;"><tr><td><u>ΑΤΟΜΙΚΗ ΚΑΡΤΕΛΑ</u></td></tr>'
        . '<tr><td><u>ΣΤΑΤΙΣΤΙΚΩΝ ΣΤΟΙΧΕΙΩΝ ΓΙΑ ΤΙΣ ΕΞΟΥΔΕΤΕΡΩΣΕΙΣ-ΚΑΤΑΣΤΡΟΦΕΣ ΠΥΡΟΜΑΧΙΚΩΝ ΚΑΙ ΕΚΡΗΚΤΙΚΩΝ ΜΗΧΑΝΙΣΜΩΝ</u></td></tr>'
        . '</table>';
$pdf->writeHTML($header1, true, false, true, false, '');

$queryPD0 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "'  "
        . " GROUP by personal_details.personal_details_id";

$PD0 = mysql_query($queryPD0) or die('Error, query failed' . mysql_error());
$num_PD0 = mysql_num_rows($PD0);

for ($i = 0; $i < $num_PD0; $i++) {
    $pd_vathmos = mysql_result($PD0, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD0, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD0, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD0, $i, 'pd_am');
    $monada_name = mysql_result($PD0, $i, 'monada_name');
    $es_code = mysql_result($PD0, $i, 'es_code');
    $es_perigrafi = mysql_result($PD0, $i, 'es_perigrafi');
    $counter = mysql_result($PD0, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD0, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics0 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="background-color: grey;border:1px solid black;">ΒΑΘΜΟΣ</td>'
            . '<td style="background-color: grey;border:1px solid black;">ΟΝΟΜΑΤΕΠΩΝΥΜΟ</td>'
            . '<td style="background-color: grey;border:1px solid black;">ΑΜ</td>'
            . '<td style="background-color: grey;border:1px solid black;">ΜΟΝΑΔΑ</td>'
            . '</tr>'
            . '<tr style="">'
            . '<td style="border:1px solid black;">' . $pd_vathmos . '</td>'
            . '<td style="border:1px solid black;">' . $pd_onoma . ' ' . $pd_eponimo . '</td>'
            . '<td style="border:1px solid black;">' . $pd_am . '</td>'
            . '<td style="border:1px solid black;">' . $monada_name . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics0, true, false, true, false, '');
}

$User0 = '<table style="background-color: grey; width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
        . '<tr>'
        . '<td style="border:1px solid black;"colspan="2">ΚΑΤΗΓΟΡΙΑ ΣΥΜΒΑΝΤΟΣ</td>'
        . '<td style="border:1px solid black;">ΑΡΙΘΜΟΣ ΠΕΡΙΣΤΑΤΙΚΩΝ</td>'
        . '<td style="border:1px solid black;">ΑΡΙΘΜΟΣ ΚΑΤΑΣΤΡΟΦΩΝ</td>'
        . '</tr>'
        . '</table>';
$pdf->writeHTML($User0, true, false, true, false, '');


$queryPD1 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=1 "
        . " GROUP by personal_details.personal_details_id";

$PD1 = mysql_query($queryPD1) or die('Error, query failed' . mysql_error());
$num_PD1 = mysql_num_rows($PD1);

for ($i = 0; $i < $num_PD1; $i++) {
    $pd_vathmos = mysql_result($PD1, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD1, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD1, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD1, $i, 'pd_am');
    $monada_name = mysql_result($PD1, $i, 'monada_name');
    $es_code = mysql_result($PD1, $i, 'es_code');
    $es_perigrafi = mysql_result($PD1, $i, 'es_perigrafi');
    $counter = mysql_result($PD1, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD1, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics1 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics1, true, false, true, false, '');
}


$queryPD2 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=2 "
        . " GROUP by personal_details.personal_details_id";

$PD2 = mysql_query($queryPD2) or die('Error, query failed' . mysql_error());
$num_PD2 = mysql_num_rows($PD2);

for ($i = 0; $i < $num_PD2; $i++) {
    $pd_vathmos = mysql_result($PD2, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD2, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD2, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD2, $i, 'pd_am');
    $monada_name = mysql_result($PD2, $i, 'monada_name');
    $es_code = mysql_result($PD2, $i, 'es_code');
    $es_perigrafi = mysql_result($PD2, $i, 'es_perigrafi');
    $counter = mysql_result($PD2, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD2, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics2 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics2, true, false, true, false, '');
}


$queryPD3 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=3 "
        . " GROUP by personal_details.personal_details_id";

$PD3 = mysql_query($queryPD3) or die('Error, query failed' . mysql_error());
$num_PD3 = mysql_num_rows($PD3);

for ($i = 0; $i < $num_PD3; $i++) {
    $pd_vathmos = mysql_result($PD3, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD3, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD3, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD3, $i, 'pd_am');
    $monada_name = mysql_result($PD3, $i, 'monada_name');
    $es_code = mysql_result($PD3, $i, 'es_code');
    $es_perigrafi = mysql_result($PD3, $i, 'es_perigrafi');
    $counter = mysql_result($PD3, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD3, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics3 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics3, true, false, true, false, '');
}


$queryPD4 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=4 "
        . " GROUP by personal_details.personal_details_id";

$PD4 = mysql_query($queryPD4) or die('Error, query failed' . mysql_error());
$num_PD4 = mysql_num_rows($PD4);

for ($i = 0; $i < $num_PD4; $i++) {
    $pd_vathmos = mysql_result($PD4, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD4, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD4, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD4, $i, 'pd_am');
    $monada_name = mysql_result($PD4, $i, 'monada_name');
    $es_code = mysql_result($PD4, $i, 'es_code');
    $es_perigrafi = mysql_result($PD4, $i, 'es_perigrafi');
    $counter = mysql_result($PD4, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD4, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics4 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics4, true, false, true, false, '');
}



$queryPD5 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=5 "
        . " GROUP by personal_details.personal_details_id";

$PD5 = mysql_query($queryPD5) or die('Error, query failed' . mysql_error());
$num_PD5 = mysql_num_rows($PD5);

for ($i = 0; $i < $num_PD5; $i++) {
    $pd_vathmos = mysql_result($PD5, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD5, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD5, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD5, $i, 'pd_am');
    $monada_name = mysql_result($PD5, $i, 'monada_name');
    $es_code = mysql_result($PD5, $i, 'es_code');
    $es_perigrafi = mysql_result($PD5, $i, 'es_perigrafi');
    $counter = mysql_result($PD5, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD5, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics5 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics5, true, false, true, false, '');
}



$queryPD6 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=6 "
        . " GROUP by personal_details.personal_details_id";

$PD6 = mysql_query($queryPD6) or die('Error, query failed' . mysql_error());
$num_PD6 = mysql_num_rows($PD6);

for ($i = 0; $i < $num_PD6; $i++) {
    $pd_vathmos = mysql_result($PD6, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD6, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD6, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD6, $i, 'pd_am');
    $monada_name = mysql_result($PD6, $i, 'monada_name');
    $es_code = mysql_result($PD6, $i, 'es_code');
    $es_perigrafi = mysql_result($PD6, $i, 'es_perigrafi');
    $counter = mysql_result($PD6, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD6, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics6 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics6, true, false, true, false, '');
}



$queryPD7 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=7 "
        . " GROUP by personal_details.personal_details_id";

$PD7 = mysql_query($queryPD7) or die('Error, query failed' . mysql_error());
$num_PD7 = mysql_num_rows($PD7);

for ($i = 0; $i < $num_PD7; $i++) {
    $pd_vathmos = mysql_result($PD7, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD7, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD7, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD7, $i, 'pd_am');
    $monada_name = mysql_result($PD7, $i, 'monada_name');
    $es_code = mysql_result($PD7, $i, 'es_code');
    $es_perigrafi = mysql_result($PD7, $i, 'es_perigrafi');
    $counter = mysql_result($PD7, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD7, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics7 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics7, true, false, true, false, '');
}


$queryPD8 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=8 "
        . " GROUP by personal_details.personal_details_id";

$PD8 = mysql_query($queryPD8) or die('Error, query failed' . mysql_error());
$num_PD8 = mysql_num_rows($PD8);

for ($i = 0; $i < $num_PD8; $i++) {
    $pd_vathmos = mysql_result($PD8, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD8, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD8, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD8, $i, 'pd_am');
    $monada_name = mysql_result($PD8, $i, 'monada_name');
    $es_code = mysql_result($PD8, $i, 'es_code');
    $es_perigrafi = mysql_result($PD8, $i, 'es_perigrafi');
    $counter = mysql_result($PD8, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD8, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics8 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics8, true, false, true, false, '');
}



$queryPD9 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=9 "
        . " GROUP by personal_details.personal_details_id";

$PD9 = mysql_query($queryPD9) or die('Error, query failed' . mysql_error());
$num_PD9 = mysql_num_rows($PD9);

for ($i = 0; $i < $num_PD9; $i++) {
    $pd_vathmos = mysql_result($PD9, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD9, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD9, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD9, $i, 'pd_am');
    $monada_name = mysql_result($PD9, $i, 'monada_name');
    $es_code = mysql_result($PD9, $i, 'es_code');
    $es_perigrafi = mysql_result($PD9, $i, 'es_perigrafi');
    $counter = mysql_result($PD9, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD9, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics9 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics9, true, false, true, false, '');
}


$queryPD10 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND  peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=10 "
        . " GROUP by personal_details.personal_details_id";

$PD10 = mysql_query($queryPD10) or die('Error, query failed' . mysql_error());
$num_PD10 = mysql_num_rows($PD10);

for ($i = 0; $i < $num_PD10; $i++) {
    $pd_vathmos = mysql_result($PD10, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD10, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD10, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD10, $i, 'pd_am');
    $monada_name = mysql_result($PD10, $i, 'monada_name');
    $es_code = mysql_result($PD10, $i, 'es_code');
    $es_perigrafi = mysql_result($PD10, $i, 'es_perigrafi');
    $counter = mysql_result($PD10, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD10, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics10 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics10, true, false, true, false, '');
}



$queryPD11 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=11 "
        . " GROUP by personal_details.personal_details_id";

$PD11 = mysql_query($queryPD11) or die('Error, query failed' . mysql_error());
$num_PD11 = mysql_num_rows($PD11);

for ($i = 0; $i < $num_PD11; $i++) {
    $pd_vathmos = mysql_result($PD11, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD11, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD11, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD11, $i, 'pd_am');
    $monada_name = mysql_result($PD11, $i, 'monada_name');
    $es_code = mysql_result($PD11, $i, 'es_code');
    $es_perigrafi = mysql_result($PD11, $i, 'es_perigrafi');
    $counter = mysql_result($PD11, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD11, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics11 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics11, true, false, true, false, '');
}



$queryPD12 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=12 "
        . " GROUP by personal_details.personal_details_id";

$PD12 = mysql_query($queryPD12) or die('Error, query failed' . mysql_error());
$num_PD12 = mysql_num_rows($PD12);

for ($i = 0; $i < $num_PD12; $i++) {
    $pd_vathmos = mysql_result($PD12, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD12, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD12, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD12, $i, 'pd_am');
    $monada_name = mysql_result($PD12, $i, 'monada_name');
    $es_code = mysql_result($PD12, $i, 'es_code');
    $es_perigrafi = mysql_result($PD12, $i, 'es_perigrafi');
    $counter = mysql_result($PD12, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD12, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics12 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics12, true, false, true, false, '');
}




$queryPD13 = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND peristatiko.eidos_sumvantos_id=13 "
        . " GROUP by personal_details.personal_details_id";

$PD13 = mysql_query($queryPD13) or die('Error, query failed' . mysql_error());
$num_PD13 = mysql_num_rows($PD13);

for ($i = 0; $i < $num_PD13; $i++) {
    $pd_vathmos = mysql_result($PD13, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PD13, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PD13, $i, 'pd_eponimo');
    $pd_am = mysql_result($PD13, $i, 'pd_am');
    $monada_name = mysql_result($PD13, $i, 'monada_name');
    $es_code = mysql_result($PD13, $i, 'es_code');
    $es_perigrafi = mysql_result($PD13, $i, 'es_perigrafi');
    $counter = mysql_result($PD13, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PD13, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatistics13 = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td style="border:1px solid black;"colspan="2">"' . $es_code . '" ' . $es_perigrafi . '</td>'
            . '<td style="border:1px solid black;">' . $counter . '</td>'
            . '<td style="border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics13, true, false, true, false, '');
}

$queryPDTh = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "' AND (peristatiko.eidos_sumvantos_id=6 OR peristatiko.eidos_sumvantos_id=7 OR peristatiko.eidos_sumvantos_id=8)"
        . " GROUP by personal_details.personal_details_id";

$PDTh = mysql_query($queryPDTh) or die('Error, query failed' . mysql_error());
$num_PDTh = mysql_num_rows($PDTh);

for ($i = 0; $i < $num_PDTh; $i++) {
    $pd_vathmos = mysql_result($PDTh, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PDTh, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PDTh, $i, 'pd_eponimo');
    $pd_am = mysql_result($PDTh, $i, 'pd_am');
    $monada_name = mysql_result($PDTh, $i, 'monada_name');
    $es_code = mysql_result($PDTh, $i, 'es_code');
    $es_perigrafi = mysql_result($PDTh, $i, 'es_perigrafi');
    $counter = mysql_result($PDTh, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PDTh, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatisticsTh = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td colspan="2" style="text-align:right;">ΣΥΝΟΛΙΚΑ ΣΤΑΤΙΣΤΙΚΑ ΣΤΟΙΧΕΙΑ <br>ΚΑΤΗΓΟΡΙΩΝ ΣΥΜΒΑΝΤΟΣ "Ζ", "Η", "Θ"</td>'
            . '<td style="background-color:#ffcccc;border:1px solid black;">' . $counter . '</td>'
            . '<td style="background-color:#ffcccc;border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatisticsTh, true, false, true, false, '');
}

$queryPDTotal = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 AND peristatiko.personal_details_id='" . $personal_details . "'  "
        . " GROUP by personal_details.personal_details_id";

$PDTotal = mysql_query($queryPDTotal) or die('Error, query failed' . mysql_error());
$num_PDTotal = mysql_num_rows($PDTotal);

for ($i = 0; $i < $num_PDTotal; $i++) {
    $pd_vathmos = mysql_result($PDTotal, $i, 'pd_vathmos');
    $pd_onoma = mysql_result($PDTotal, $i, 'pd_onoma');
    $pd_eponimo = mysql_result($PDTotal, $i, 'pd_eponimo');
    $pd_am = mysql_result($PDTotal, $i, 'pd_am');
    $monada_name = mysql_result($PDTotal, $i, 'monada_name');
    $es_code = mysql_result($PDTotal, $i, 'es_code');
    $es_perigrafi = mysql_result($PDTotal, $i, 'es_perigrafi');
    $counter = mysql_result($PDTotal, $i, 'COUNT(peristatiko_id)');
    $quantity = mysql_result($PDTotal, $i, 'SUM(quantity)');
    $q = $i + 1;
    $UserStatisticsTotal = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:8px;">'
            . '<tr>'
            . '<td colspan="2" style="text-align:right;">ΣΥΝΟΛΙΚΑ ΣΤΑΤΙΣΤΙΚΑ ΣΤΟΙΧΕΙΑ</td>'
            . '<td style="background-color:#6666ff;border:1px solid black;">' . $counter . '</td>'
            . '<td style="background-color:#6666ff;border:1px solid black;">' . $quantity . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatisticsTotal, true, false, true, false, '');
}

$pdf->lastPage();
// ---------------------------------------------------------
// // Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Personal_Statistics (' . $personal_details . ').pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
