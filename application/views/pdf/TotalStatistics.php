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
$pdf->SetAuthor('Total Statistics');
$pdf->SetTitle('Total Statistics');
$pdf->SetSubject('Total Statistics');
$pdf->SetKeywords('Total Statistics');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . 'Total Statistics', PDF_HEADER_STRING, array(255, 255, 255), array(255, 255, 255));
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

$header1 = '<table style="font-size:12px; text-align:center;"><tr><td><u>ΠΙΝΑΚΑΣ</u></td></tr>'
        . '<tr><td><u>ΣΤΑΤΙΣΤΙΚΩΝ ΣΤΟΙΧΕΙΩΝ ΓΙΑ ΤΙΣ ΕΞΟΥΔΕΤΕΡΩΣΕΙΣ-ΚΑΤΑΣΤΡΟΦΕΣ ΠΥΡΟΜΑΧΙΚΩΝ ΚΑΙ ΕΚΡΗΚΤΙΚΩΝ ΜΗΧΑΝΙΣΜΩΝ</u></td></tr>'
        . '<tr><td><u>ΠΟΥ ΠΡΑΓΜΑΤΟΠΟΙΗΘΗΚΑΝ ΑΠΟ ΤΟΥΣ ΠΥΡΟΤΕΧΝΟΥΡΓΟΥΣ ΤΟΥ ΣΥΠ </u></td></tr></table>';
$pdf->writeHTML($header1, true, false, true, false, '');

$queryPD = "SELECT * FROM peristatiko "
        . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
        . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
        . " LEFT JOIN status on peristatiko.status_id=status.status_id"
        . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
        . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
        . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
        . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
        . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
        . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
        . " WHERE peristatiko.status_id=4 "
        . " GROUP by personal_details.personal_details_id";

$PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
$num_PD = mysql_num_rows($PD);


$UserStatistics0 = '<table style="width:100%;height:100%;font-size:10px; text-align:center;padding:8px;">'
        . '<tr>'
        . '<td style="background-color: grey;border:1px solid black;width:4%">Α/Α</td>'
        . '<td colspan="2" style="background-color: grey;border:1px solid black;">ΒΑΘΜΟΣ</td>'
        . '<td colspan="3" style="background-color: grey;border:1px solid black;">ΟΝΟΜΑΤΕΠΩΝΥΜΟ</td>'
        . '<td style="background-color: grey;border:1px solid black;">ΑΜ</td>'
        . '<td colspan="2" style="background-color: grey;border:1px solid black;">ΜΟΝΑΔΑ</td>'
//        . '<td style="background-color: grey;border:1px solid black;"colspan="2">ΚΑΤΗΓΟΡΙΑ ΣΥΜΒΑΝΤΟΣ</td>'
//        . '<td style="background-color: grey;border:1px solid black;">ΑΡΙΘΜΟΣ ΠΕΡΙΣΤΑΤΙΚΩΝ</td>'
//        . '<td style="background-color: grey;border:1px solid black;">ΑΡΙΘΜΟΣ ΚΑΤΑΣΤΡΟΦΩΝ</td>'
        . '</tr>'
        . '</table>';
$pdf->writeHTML($UserStatistics0, true, false, true, false, '');


for ($k = 0; $k < $num_PD; $k++) {
    $pd_vathmos = mysql_result($PD, $k, 'pd_vathmos');
    $pd_onoma = mysql_result($PD, $k, 'pd_onoma');
    $pd_eponimo = mysql_result($PD, $k, 'pd_eponimo');
    $pd_am = mysql_result($PD, $k, 'pd_am');
    $monada_name = mysql_result($PD, $k, 'monada_name');
    $q = $k + 1;

    $UserStatistics = '<table style="width:100%;height:100%;font-size:12px; text-align:center;padding:2px;">'
            . '<tr style="">'
            . '<td style="border:1px solid black;width:4%">' . $q . '</td>'
            . '<td  colspan="2" style="border:1px solid black;">' . $pd_vathmos . '</td>'
            . '<td  colspan="3" style="border:1px solid black;">' . $pd_onoma . ' ' . $pd_eponimo . '</td>'
            . '<td style="border:1px solid black;">' . $pd_am . '</td>'
            . '<td  colspan="2" style="border:1px solid black;">' . $monada_name . '</td>'
            . '</tr>'
            . '</table>';
    $pdf->writeHTML($UserStatistics, true, false, true, false, '');




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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=1 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD1 = mysql_query($queryPD1) or die('Error, query failed' . mysql_error());
    $num_PD1 = mysql_num_rows($PD1);

    for ($i = 0; $i < $num_PD1; $i++) {
        $es_code = mysql_result($PD1, $i, 'es_code');
        $es_perigrafi = mysql_result($PD1, $i, 'es_perigrafi');
        $counter = mysql_result($PD1, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD1, $i, 'SUM(quantity)');

        $UserStatistics1 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=2 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD2 = mysql_query($queryPD2) or die('Error, query failed' . mysql_error());
    $num_PD2 = mysql_num_rows($PD2);

    for ($i = 0; $i < $num_PD2; $i++) {
        $es_code = mysql_result($PD2, $i, 'es_code');
        $es_perigrafi = mysql_result($PD2, $i, 'es_perigrafi');
        $counter = mysql_result($PD2, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD2, $i, 'SUM(quantity)');

        $UserStatistics2 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=3 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD3 = mysql_query($queryPD3) or die('Error, query failed' . mysql_error());
    $num_PD3 = mysql_num_rows($PD3);

    for ($i = 0; $i < $num_PD3; $i++) {
        $es_code = mysql_result($PD3, $i, 'es_code');
        $es_perigrafi = mysql_result($PD3, $i, 'es_perigrafi');
        $counter = mysql_result($PD3, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD3, $i, 'SUM(quantity)');

        $UserStatistics3 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=4 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD4 = mysql_query($queryPD4) or die('Error, query failed' . mysql_error());
    $num_PD4 = mysql_num_rows($PD4);

    for ($i = 0; $i < $num_PD4; $i++) {
        $es_code = mysql_result($PD4, $i, 'es_code');
        $es_perigrafi = mysql_result($PD4, $i, 'es_perigrafi');
        $counter = mysql_result($PD4, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD4, $i, 'SUM(quantity)');

        $UserStatistics4 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=5 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD5 = mysql_query($queryPD5) or die('Error, query failed' . mysql_error());
    $num_PD5 = mysql_num_rows($PD5);

    for ($i = 0; $i < $num_PD5; $i++) {
        $es_code = mysql_result($PD5, $i, 'es_code');
        $es_perigrafi = mysql_result($PD5, $i, 'es_perigrafi');
        $counter = mysql_result($PD5, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD5, $i, 'SUM(quantity)');

        $UserStatistics5 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=6 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD6 = mysql_query($queryPD6) or die('Error, query failed' . mysql_error());
    $num_PD6 = mysql_num_rows($PD6);

    for ($i = 0; $i < $num_PD6; $i++) {
        $es_code = mysql_result($PD6, $i, 'es_code');
        $es_perigrafi = mysql_result($PD6, $i, 'es_perigrafi');
        $counter = mysql_result($PD6, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD6, $i, 'SUM(quantity)');

        $UserStatistics6 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=7 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD7 = mysql_query($queryPD7) or die('Error, query failed' . mysql_error());
    $num_PD7 = mysql_num_rows($PD7);

    for ($i = 0; $i < $num_PD7; $i++) {
        $es_code = mysql_result($PD7, $i, 'es_code');
        $es_perigrafi = mysql_result($PD7, $i, 'es_perigrafi');
        $counter = mysql_result($PD7, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD7, $i, 'SUM(quantity)');

        $UserStatistics7 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=8 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD8 = mysql_query($queryPD8) or die('Error, query failed' . mysql_error());
    $num_PD8 = mysql_num_rows($PD8);

    for ($i = 0; $i < $num_PD8; $i++) {
        $es_code = mysql_result($PD8, $i, 'es_code');
        $es_perigrafi = mysql_result($PD8, $i, 'es_perigrafi');
        $counter = mysql_result($PD8, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD8, $i, 'SUM(quantity)');


        $UserStatistics8 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b> ' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=9 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD9 = mysql_query($queryPD9) or die('Error, query failed' . mysql_error());
    $num_PD9 = mysql_num_rows($PD9);

    for ($i = 0; $i < $num_PD9; $i++) {
        $es_code = mysql_result($PD9, $i, 'es_code');
        $es_perigrafi = mysql_result($PD9, $i, 'es_perigrafi');
        $counter = mysql_result($PD9, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD9, $i, 'SUM(quantity)');

        $UserStatistics9 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=10 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD10 = mysql_query($queryPD10) or die('Error, query failed' . mysql_error());
    $num_PD10 = mysql_num_rows($PD10);

    for ($i = 0; $i < $num_PD10; $i++) {
        $es_code = mysql_result($PD10, $i, 'es_code');
        $es_perigrafi = mysql_result($PD10, $i, 'es_perigrafi');
        $counter = mysql_result($PD10, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD10, $i, 'SUM(quantity)');

        $UserStatistics10 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=11 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD11 = mysql_query($queryPD11) or die('Error, query failed' . mysql_error());
    $num_PD11 = mysql_num_rows($PD11);

    for ($i = 0; $i < $num_PD11; $i++) {
        $es_code = mysql_result($PD11, $i, 'es_code');
        $es_perigrafi = mysql_result($PD11, $i, 'es_perigrafi');
        $counter = mysql_result($PD11, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD11, $i, 'SUM(quantity)');

        $UserStatistics11 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=12 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD12 = mysql_query($queryPD12) or die('Error, query failed' . mysql_error());
    $num_PD12 = mysql_num_rows($PD12);

    for ($i = 0; $i < $num_PD12; $i++) {
        $es_code = mysql_result($PD12, $i, 'es_code');
        $es_perigrafi = mysql_result($PD12, $i, 'es_perigrafi');
        $counter = mysql_result($PD12, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD12, $i, 'SUM(quantity)');

        $UserStatistics12 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
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
            . " WHERE peristatiko.status_id=4 AND peristatiko.eidos_sumvantos_id=13 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PD13 = mysql_query($queryPD13) or die('Error, query failed' . mysql_error());
    $num_PD13 = mysql_num_rows($PD13);

    for ($i = 0; $i < $num_PD13; $i++) {
        $es_code = mysql_result($PD13, $i, 'es_code');
        $es_perigrafi = mysql_result($PD13, $i, 'es_perigrafi');
        $counter = mysql_result($PD13, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PD13, $i, 'SUM(quantity)');

        $UserStatistics13 = '<table style="background-color:#e0e0d1;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Κατηγορία Συμβάντος: </b><br>' . $es_code . '" ' . $es_perigrafi . '</td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
        $pdf->writeHTML($UserStatistics13, true, false, true, false, '');
    }

    $queryPDTH = "SELECT *,COUNT(peristatiko_id),SUM(quantity) FROM peristatiko "
            . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
            . " LEFT JOIN monada on monada.monada_id=personal_details.monada_id"
            . " LEFT JOIN status on peristatiko.status_id=status.status_id"
            . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
            . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
            . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
            . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
            . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
            . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
            . " WHERE peristatiko.status_id=4 AND (peristatiko.eidos_sumvantos_id=6 OR peristatiko.eidos_sumvantos_id=7 OR peristatiko.eidos_sumvantos_id=8) "
            . " AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PDTH = mysql_query($queryPDTH) or die('Error, query failed' . mysql_error());
    $num_PDTH = mysql_num_rows($PDTH);

    for ($i= 0; $i < $num_PDTH; $i++) {
        $es_code = mysql_result($PDTH, $i, 'es_code');
        $es_perigrafi = mysql_result($PDTH, $i, 'es_perigrafi');
        $counter = mysql_result($PDTH, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PDTH, $i, 'SUM(quantity)');

        $UserStatisticsTH = '<table style="background-color:#ffcccc;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Συνολικά Στοιχεία Εξουδετερώσεων<br> Κατηγορίας "Ζ", "Η", "Θ": </b></td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
        $pdf->writeHTML($UserStatisticsTH, true, false, true, false, '');
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
            . " WHERE peristatiko.status_id=4 AND personal_details.pd_am='" . $pd_am . "'"
            . " GROUP by personal_details.personal_details_id";
    $PDTotal = mysql_query($queryPDTotal) or die('Error, query failed' . mysql_error());
    $num_PDTotal = mysql_num_rows($PDTotal);

    for ($i = 0; $i < $num_PDTotal; $i++) {
        $es_code = mysql_result($PDTotal, $i, 'es_code');
        $es_perigrafi = mysql_result($PDTotal, $i, 'es_perigrafi');
        $counter = mysql_result($PDTotal, $i, 'COUNT(peristatiko_id)');
        $quantity = mysql_result($PDTotal, $i, 'SUM(quantity)');

        $UserStatisticsTotal = '<table style="background-color:#6666ff;width:93%;height:100%;font-size:10px;text-align:left;">'
                . '<tr>'
                . '<td colspan="2"><b>Συνολικά Στοιχεία: </b></td>'
                . '<td>Αριθμός Περιστατικών: </td><td><b>' . $counter . '</b> </td>'
                . '<td>Αριθμός Εξουδετερώσεων<br>Καταστροφών: </td><td><b>' . $quantity . '</b></td>'
                . '</tr>'
                . '</table>'
                . '';
        $pdf->writeHTML($UserStatisticsTotal, true, false, true, false, '');
    }

}


$pdf->lastPage();
// ---------------------------------------------------------
// // Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('Total Statistics.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
