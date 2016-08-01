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
            $ek_paratiriseis = '' . $genEkriktika->ek_paratiriseis . '';
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

$txtTitle = ' 
<div style="font-size:14px; text-align:center"><u>ΦΟΡΜΑ ΣΤΑΤΙΣΤΙΚΗΣ ΠΑΡΑΚΟΛΟΥΘΗΣΗΣ</u><br>
<u>ΕΞΟΥΔΕΤΕΡΩΣΕΩΝ-ΚΑΤΑΣΤΡΟΦΩΝ ΑΧΡΗΣΤΩΝ ΚΑΙ ΕΠΙΚΙΝΔΥΝΩΝ ΠΥΡΟΜΑΧΙΚΩΝ</u><br>
' . $peristatiko . '
</div>';
$txtbr = '<br>';


//$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->writeHTML($txtTitle, true, false, true, false, '');

$pdf->writeHTML($txtbr, true, false, true, false, '');

$html1 = ' 
<table style="font-size:12px;">
<tr><td colspan="2">   1.   ΓΕΝΙΚΑ ΣΤΟΙΧΕΙΑ</td></tr>
<tr><td>ΗΜΕΡΟΜΗΝΙΑ: ' . $ps_date . '</td>
    <td>ΤΟΠΟΣ: ' . $ps_topos . '<br>ΩΡΑ ΕΝΑΡΞΗΣ: ' . $ps_ora_enarxis . ' - ΛΗΞΗΣ: ' . $ps_ora_lixis . '</td>
</tr>
<tr><td>ΑΜ:' . $pd_am . '</td><td>ΒΑΘΜΟΣ: ' . $pd_vathmos . '</td></tr>
<tr><td>ΕΠΩΝΥΜΟ: ' . $pd_onoma . '</td><td>ΟΝΟΜΑ: ' . $pd_eponimo . '</td></tr>
<tr><td>ΔΙΑΤΑΓΗ: ' . $document . '</td></tr>
<tr><td>ΒΟΗΘΗΤΙΚΟ ΠΡΟΣΩΠΙΚΟ: </td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   2.   ΚΑΤΗΓΟΡΙΑ ΣΥΜΒΑΝΤΟΣ</td></tr>
<tr><td colspan="2">' . $es_code . '  ' . $es_perigrafi . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   3.   ΕΙΔΟΣ ΠΥΡΟΜΑΧΙΚΟΥ</td></tr>
<tr><td colspan="2">' . $ep_value . '  ' . $ep_eidos . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   4.   ΚΑΤΗΓΟΡΙΕΣ ΠΡΟΤΕΡΑΙΟΤΗΤΑΣ</td></tr>
<tr><td colspan="2">' . $kp_code . '  ' . $kp_perigrafi . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   5.   ΘΕΣΗ ΣΥΜΒΑΝΤΟΣ</td></tr>
<tr><td colspan="2">' . $ts_value . '  ' . $ts_thesi . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   6.   ΣΤΟΙΧΕΙΑ ΑΝΑΓΝΩΡΙΣΗΣ ΠΥΡΟΜΑΧΙΚΩΝ (ΕΦΟΣΟΝ ΑΝΑΓΝΩΡΙΣΘΗΚΑΝ)</td></tr>
<tr><td colspan="">ΑΟ:    </td><td>' . $ao_nsn . '</td></tr>
<tr><td colspan="">Μερίδα: </td><td>' . $merida . '</td></tr>
<tr><td colspan="">Περιγραφή: </td><td>' . $perigrafi . '</td></tr>
<tr><td colspan="">SN: </td><td>' . $sn . '</td></tr>
<tr><td colspan="">ΑΟ Πυροσωλήνα: </td><td>' . $ao_nsn_prl . '</td></tr>
<tr><td colspan="">Μερίδα Πυροσωλήνα: </td><td>' . $merida_prl . '</td></tr>
<tr><td colspan="">Περιγραφή Πυροσωλήνα: </td><td>' . $perigrafi_prl . '</td></tr>
<tr><td colspan="">ΑΟ Κινητήρα Ρουκέτας: </td><td>' . $ao_nsn_rock_mis_assistant . '</td></tr>
<tr><td colspan="">Μερίδα Κινητήρα Ρουκέτας: </td><td>' . $merida_rock_mis_assistant . '</td></tr>
<tr><td colspan="">Περιγραφή Κινητήρα Ρουκέτας: </td><td>' . $perigrafi_rock_mis_assistant . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   7.   ΕΠΙΚΡΑΤΟΥΣΕΣ ΣΥΝΘΗΚΕΣ</td></tr>
<tr><td colspan="">ΚΑΙΡΟΣ: </td><td>' . $kairos . '  </td></tr>
<tr><td colspan="">ΕΓΚΑΤΑΣΤΑΣΕΙΣ - ΚΤΙΡΙΑ: </td><td>' . $egatastasis_ktiria . ' </td></tr>
<tr><td colspan="">ΥΠΑΡΞΗ ΙΑΤΡΟΥ: </td><td>' . $topikes_arxes_ekav . ' </td></tr>
<tr><td colspan="">ΥΠΑΡΞΗ ΦΟΡΕΙΟΦΟΡΟΥ ΟΧΗΜΑΤΟΣ:</td><td>' . $topikes_arxes_ekav . '</td></tr>
<tr><td colspan="">ΥΠΑΡΞΗ ΑΣΤΥΝΟΜΙΚΗΣ ΑΡΧΗΣ: </td><td>' . $topikes_arxes_elas . ' </td></tr>
<tr><td colspan="">ΥΠΑΡΞΗ ΛΙΜΕΝΙΚΟΥ ΣΩΜΑΤΟΣ: </td><td>' . $topikes_arxes_limeniko . ' </td></tr>
<tr><td colspan="">ΥΠΑΡΞΗ ΠΥΡΟΣΒΕΣΤΙΚΟΥ ΟΧΗΜΑΤΟΣ: </td><td>' . $topikes_arxes_pyrosvestiki . ' </td></tr>    
<tr><td><br></td></tr>

<tr><td colspan="2">   8.   ΕΚΔΗΛΩΘΕΙΣΕΣ ΕΝΕΡΓΕΙΕΣ:</td></tr>
<tr><td colspan="">Ενέργειες Αναγνώρισης: </td><td>' . $anagnorisi . '</td></tr>
<tr><td colspan="">Ενέργειες Εξουδετέρωσης: </td><td>' . $exoudeterosi . '</td></tr>
<tr><td colspan="">Ενέργειες Περισυλλογής: </td><td>' . $perisillogi . '</td></tr>
<tr><td colspan="">Ενέργειες Μεταφοράς: </td><td>' . $metafora . '</td></tr>
<tr><td colspan="">Ενέργειες Καταστροφής: </td><td>' . $katastrofi . '</td></tr>
<tr><td colspan="">Έλεγχος Εστίας: </td><td>' . $elegxos_estias . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   9.   ΠΑΡΑΤΗΡΗΣΕΙΣ - ΔΥΣΧΕΡΕΙΕΣ</td></tr>
<tr><td colspan="">Παρατηρήσεις: </td><td>' . $paratiriseis . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   10.  ΠΡΟΚΛΗΘΕΙΣΕΣ ΖΗΜΙΕΣ</td></tr>
<tr><td colspan="">Προκληθείσες Ζημίες: </td><td>' . $zimies . '</td></tr>
<tr><td><br></td></tr>

<tr><td colspan="2">   11.  ΤΟΠΙΚΕΣ ΑΡΧΕΣ ΠΟΥ ΗΤΑΝ ΠΑΡΟΥΣΕΣ ΣΤΟ ΣΥΜΒΑΝ (ΕΚΠΡΟΣΩΠΟΙ ΑΥΤΩΝ)</td></tr>
<tr><td colspan="">Ύπαρξη Αστυνομικής Αρχής: </td><td>' . $topikes_arxes_elas . ' </td></tr>
<tr><td colspan="">Ύπαρξη Λιμενικού Σώματος: </td><td>' . $topikes_arxes_limeniko . ' </td></tr>
<tr><td colspan="">Ύπαρξη Πυροσβεστικού Οχήματος: </td><td>' . $topikes_arxes_pyrosvestiki . ' </td></tr>  
<tr><td><br></td></tr>

</table>

';

$pdf->writeHTML($html1, true, false, true, false, '');
$html2 = '
    <table style="font-size:12px;">
    <tr><td colspan="2">   12.  ΧΡΗΣΙΜΟΠΟΙΗΘΕΝΤΑ ΕΚΡΗΚΤΙΚΑ</td></tr>
    <tr><td colspan="">Είδος Εκρηκτικου: </td><td colspan="">Ποσότητα </td>
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

$html4 = '
    <table style="font-size:12px;">
    <tr><td colspan="2">   13.  ΧΡΗΣΙΜΟΠΟΙΗΘΕΝ ΕΞΟΠΛΙΣΜΟΣ</td></tr>
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
<div style="font-size:14px; text-align:right;">' . $pd_onoma . ' ' . $pd_eponimo . '</div> ';
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
