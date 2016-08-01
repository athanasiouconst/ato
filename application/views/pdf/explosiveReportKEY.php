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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('EOD Personal');
$pdf->SetTitle('Explosive Report');
$pdf->SetSubject('Explosive Report');
$pdf->SetKeywords('Explosive Report');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' Explosive Report', PDF_HEADER_STRING, array(255, 255, 255), array(255, 255, 255));
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

if (isset($gens)):
    if (count($gen) > 0) :
        foreach ($gen as $gen):
            $source = $gen->ps_date;
            $date = new DateTime($source);
            $date->format('d-m-Y');

            $pd_vathmos = '' . $gen->pd_vathmos . '';
            $pd_onoma = '' . $gen->pd_onoma . '';
            $pd_eponimo = '' . $gen->pd_eponimo . '';
            $pd_am = '' . $gen->pd_am . '';
            $pd_oplo_soma = '' . $gen->pd_oplo_soma . '';
            $monada_id = '' . $gen->monada_id . '';
            $monada_name = '' . $gen->monada_name . '';
            $document = '' . $gen->document . '';
            $ps_topos = '' . $gen->ps_topos . '';
            $ps_date = $date->format('d-m-Y');
            $ps_ora_enarxis = '' . $gen->ps_ora_enarxis . '';
            $ps_ora_lixis = '' . $gen->ps_ora_lixis . '';
            $quantity = '' . $gen->quantity . '';
            $eidos_puromaxikou_id = '' . $gen->eidos_puromaxikou_id . '';
            $perigrafi = '' . $gen->perigrafi . '';
            $es_code = '' . $gen->es_code . '';
            $es_perigrafi = '' . $gen->es_perigrafi . '';
            $ep_value = '' . $gen->ep_value . '';
            $ep_eidos = '' . $gen->ep_eidos . '';
            $kp_code = '' . $gen->kp_code . '';
            $kp_perigrafi = '' . $gen->kp_perigrafi . '';
            $ts_value = '' . $gen->ts_value . '';
            $ts_thesi = '' . $gen->ts_thesi . '';
            $ao_nsn = '' . $gen->ao_nsn . '';
            $merida = '' . $gen->merida . '';
            $perigrafi = '' . $gen->perigrafi . '';
            $kairos = '' . $gen->kairos . '';
            $egatastasis_ktiria = '' . $gen->egatastasis_ktiria . '';
            $topikes_arxes_ekav = '' . $gen->topikes_arxes_ekav . '';
            $topikes_arxes_elas = '' . $gen->topikes_arxes_elas . '';
            $topikes_arxes_limeniko = '' . $gen->topikes_arxes_limeniko . '';
            $topikes_arxes_pyrosvestiki = '' . $gen->topikes_arxes_pyrosvestiki . '';
            $sn = '' . $gen->sn . '';
            $ao_nsn_prl = '' . $gen->ao_nsn_prl . '';
            $merida_prl = '' . $gen->merida_prl . '';
            $perigrafi_prl = '' . $gen->perigrafi_prl . '';
            $ao_nsn_rock_mis_assistant = '' . $gen->ao_nsn_rock_mis_assistant . '';
            $merida_rock_mis_assistant = '' . $gen->merida_rock_mis_assistant . '';
            $perigrafi_rock_mis_assistant = '' . $gen->perigrafi_rock_mis_assistant . '';
            $anagnorisi = '' . $gen->anagnorisi . '';
            $exoudeterosi = '' . $gen->exoudeterosi . '';
            $perisillogi = '' . $gen->perisillogi . '';
            $metafora = '' . $gen->metafora . '';
            $katastrofi = '' . $gen->katastrofi . '';
            $elegxos_estias = '' . $gen->elegxos_estias . '';
            $paratiriseis = '' . $gen->paratiriseis . '';
            $zimies = '' . $gen->zimies . '';
        endforeach;
    endif;
endif;

if (isset($gensEkriktika)):
    $count = count($genEkriktika);
    if (count($genEkriktika) > 0) :
        foreach ($genEkriktika as $genEkriktika):
            $ek_eidos = '' . $genEkriktika->ek_eidos . '';
            $lot = '' . $genEkriktika->lot . '';
            $ekr_posotika = '' . $genEkriktika->ekr_posotika . '';
        endforeach;
    endif;
endif;

$queryPD = "SELECT * FROM peristatiko_ekriktika "
        . " LEFT JOIN peristatiko ON peristatiko.peristatiko_id=peristatiko_ekriktika.peristatiko_id "
        . " LEFT JOIN ekriktika_lot ON ekriktika_lot.ekriktika_lot_id=peristatiko_ekriktika.ekriktika_lot_id "
        . " LEFT JOIN ekriktika ON ekriktika.ekriktika_id=ekriktika_lot.ekriktika_id "
        . " where peristatiko.peristatiko_id= '" . $peristatiko . "' ";
$PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
$num_PD = mysql_num_rows($PD);

$queryEXO = "SELECT * FROM peristatiko_exoplismos "
        . " LEFT JOIN peristatiko ON peristatiko.peristatiko_id=peristatiko_exoplismos.peristatiko_id "
        . " LEFT JOIN exoplismos ON exoplismos.exoplismos_id=peristatiko_exoplismos.exoplismos_id "
        . " where peristatiko.peristatiko_id= '" . $peristatiko . "' ";
$EXO = mysql_query($queryEXO) or die('Error, query failed' . mysql_error());
$num_EXO = mysql_num_rows($EXO);

$txtMonada = '<div style="font-size:14px; text-align:right">'.$monada_name.'</div>';
$txtdate = '<div style="font-size:14px; text-align:right">'.$ps_date.'<br></div>';



$txtTitle = ' 
<div style="font-size:14px; text-align:center"><u>ΕΚΘΕΣΗ</u><br>
<u>ΕΞΟΥΔΕΤΕΡΩΣΗ - ΚΑΤΑΣΤΡΟΦΗΣ ΑΧΡΗΣΤΩΝ ΠΥΡΟΜΑΧΙΚΩΝ</u><br>
' . $peristatiko . '
</div>';
$txtbr = '<br>';


//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->writeHTML($txtMonada, true, false, true, false, '');
$pdf->writeHTML($txtdate, true, false, true, false, '');
$pdf->writeHTML($txtTitle, true, false, true, false, '');

$pdf->writeHTML($txtbr, true, false, true, false, '');

$html1 = ' 
<table style="font-size:12px;
    position: relative;
    margin: 10px auto;
    padding: 0;
    width: 100%;
    height: auto;
    border-collapse: collapse;
    text-align: JUSTIFY;
">
<tr><td colspan="2">    Σήμερα την '.$ps_date.' ο/η υπογεγραμμένος/η '
        . ''.$pd_vathmos.' '.$pd_oplo_soma.' '.$pd_onoma.' '.$pd_eponimo.'
            που υπηρετώ στη '.$monada_name.', μετέβηκα σε εκτέλεση του 
            υπ` αριθμ. '.$document.' εγγράφου/σήματος, στη τοποθεσία 
            '.$ps_topos.' που ως χώρος δεν είναι χαρακτηρισμένος ως ύποπτος και προέβηκα 
            στην εξουδετέρωση και καταστροφή '.$quantity.' '.$perigrafi.' .
            </td></tr>
<tr><td colspan="2"><br><br></td></tr>
<tr><td colspan="2">Για να καταστούν οι ενέργειες με ασφάλεια έγιναν τα παρακάτω :</td></tr>
<tr><td colspan="2"><br></td></tr>
<tr><td colspan="2">Ενέργειες Αναγνώρισης: </td></tr>
<tr><td colspan="2"><br></td></tr>
<tr><td colspan="2">' . $anagnorisi . '</td></tr>
<tr><td colspan="2"><br></td></tr>
<tr><td colspan="2">Ενέργειες Εξουδετέρωσης: </td></tr>
<tr><td colspan="2"><br></td></tr>
<tr><td colspan="2">' . $exoudeterosi . '</td></tr>
<tr><td colspan="2"><br></td></tr>
<tr><td colspan="2">Ενέργειες Περισυλλογής: </td></tr>
<tr><td colspan="2">' . $perisillogi . '</td></tr>
<tr><td colspan="2"><br></td></tr>    
<tr><td colspan="2">Ενέργειες Μεταφοράς: </td></tr>
<tr><td colspan="2">' . $metafora . '</td></tr>
<tr><td colspan="2"><br></td></tr>
<tr><td colspan="2">Ενέργειες Καταστροφής: </td></tr>
<tr><td colspan="2">' . $katastrofi . '</td></tr>
<tr><td colspan="2"><br></td></tr>
<tr><td colspan="2"><br></td></tr>
</table>
';

$pdf->writeHTML($html1, true, false, true, false, '');
$html2='
    <table style="font-size:12px;">
    <tr><td colspan="2">Για την εξουδετέρωση/καταστροφή χρησιμοποιήθηκαν τα παρακάτω: </td></tr>
    <tr><td colspan="2"><br></td></tr>
    <tr><td colspan="">Είδος Εκρηκτικού: </td><td colspan="">Ποσότητα </td>
    </tr> 
    </table>';
$pdf->writeHTML($html2, true, false, true, false, '');

for ($i = 0; $i < $num_PD; $i++) {
    $eidos = mysql_result($PD, $i, 'ek_eidos');
    $lot = mysql_result($PD, $i, 'lot');
    $ekr_pos = mysql_result($PD, $i, 'ekr_posotika');

    $html3 = ' 
    <table style="font-size:12px;">
    <tr><td>' . $eidos . '  ' . $lot . '</td><td>Ποσότητα: ' . $ekr_pos . '</td>
    </tr> 
    </table>
';
    $pdf->writeHTML($html3, true, false, true, false, '');
}

$html4='
    <table style="font-size:12px;">
    <tr><td colspan="2"><br></td></tr>
    <tr><td colspan="">Είδος Εξοπλισμού: </td><td colspan="">Ποσότητα </td>
    </tr> 
    </table>';
$pdf->writeHTML($html4, true, false, true, false, '');

for ($i = 0; $i < $num_EXO; $i++) {
    $ex_eidos = mysql_result($EXO, $i, 'ex_eidos');
    $ex_para = mysql_result($EXO, $i, 'ex_paratiriseis');
    $exo_pos = mysql_result($EXO, $i, 'exo_posotika');

    $html5 = ' 
    <table style="font-size:12px;">
    <tr><td>' . $ex_eidos . '  ' . $ex_para . '</td><td>Ποσότητα: ' . $exo_pos . '</td>
    </tr> 
    </table>
';
    $pdf->writeHTML($html5, true, false, true, false, '');
}


$pdf->writeHTML($txtbr, true, false, true, false, '');
$pdf->writeHTML($txtbr, true, false, true, false, '');
$pdf->writeHTML($txtbr, true, false, true, false, '');

$html6 = '
<div style="font-size:14px; text-align:right;">ΣΥΝΤΑΞΑΣ</div> 
<div style="font-size:14px; text-align:right;">'.$pd_onoma.' '.$pd_eponimo.'</div> ' ;
$pdf->writeHTML($txtbr, true, false, true, false, '');
$pdf->writeHTML($html6, true, false, true, false, '');



$pdf->lastPage();
// ---------------------------------------------------------
// // Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('ExplosiveReport( ' . $ps_date . ').pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
