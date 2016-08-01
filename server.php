<?php

// Pull in the NuSOAP code
require_once('nusoap.php');


//$this->load->library('nusoap');
// Create the server instance
$server = new soap_server;

// Register the method to expose
$server->register('Roles');
$server->register('TempInstance');
$server->register('InstanceExplosive');
$server->register('InstanceEquipment');
$server->register('EditPersonaleDetails');
$server->register('RecoverPassword');
$server->register('UpdateStatusKEY');
$server->register('UpdateStatus');
$server->register('EditInstance');
$server->register('DeleteInstance');
$server->register('DeleteExplosiveInstance');
$server->register('DeleteEquipmentInstance');

// Define the method as a PHP function

function getDBConnection() {
    return new mysqli('localhost', 'root', '', 'atodb');
}

function Roles($r_name, $r_description) {

    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");
    $con->query("  INSERT INTO roles VALUES(    NULL, '" . $r_name . "', '" . $r_description . "'    ) ");
    $con->close();

    return '    ' . $r_name . ' ' . $r_description . ' ';
}

function TempInstance(
$peristatiko_id, $personal_details_id, $katanomi_armodiotiton_id, $katigoria_sumvantos_id, $eidos_sumvantos_id, $eidos_puromaxikou_id, $katigoria_proteraiotitas_id, $thesi_simvantos_id, $document, $ps_date, $ps_topos, $ps_ora_enarxis, $ps_ora_lixis, $ao_nsn, $merida, $quantity, $perigrafi, $sn, $ao_nsn_prl, $merida_prl, $perigrafi_prl, $ao_nsn_rock_mis_assistant, $merida_rock_mis_assistant, $perigrafi_rock_mis_assistant, $egatastasis_ktiria, $kairos, $topikes_arxes_ekav, $topikes_arxes_elas, $topikes_arxes_limeniko, $topikes_arxes_pyrosvestiki, $anagnorisi, $exoudeterosi, $perisillogi, $metafora, $katastrofi, $elegxos_estias, $paratiriseis, $zimies, $epikefalis, $status_id,$peristatiko_key_notes) {

    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");
    $con->query("  INSERT INTO peristatiko VALUES(    "
            . "    '" . $peristatiko_id. "'    ,   "
            . "    '" . $personal_details_id. "'    ,  "
            . "    '" . $katanomi_armodiotiton_id. "'    ,  "
            . "    '" . $katigoria_sumvantos_id. "'    ,  "
            . "    '" . $eidos_sumvantos_id. "'    ,  "
            . "    '" . $eidos_puromaxikou_id. "'    ,  "
            . "    '" . $katigoria_proteraiotitas_id. "'    ,  "
            . "    '" . $thesi_simvantos_id. "'    ,  "
            . "    '" . $document. "'    ,  "
            . "    '" . $ps_date. "'    ,  "
            . "    '" . $ps_topos. "'    ,  "
            . "    '" . $ps_ora_enarxis. "'    ,  "
            . "    '" . $ps_ora_lixis. "'    ,  "
            . "    '" . $ao_nsn. "'    ,  "
            . "    '" . $merida. "'    ,  "
            . "    '" . $quantity. "'    ,  "
            . "    '" . $perigrafi. "'    ,  "
            . "    '" . $sn. "'    ,  "
            . "    '" . $ao_nsn_prl. "'    ,  "
            . "    '" . $merida_prl. "'    ,  "
            . "    '" . $perigrafi_prl. "'    ,  "
            . "    '" . $ao_nsn_rock_mis_assistant. "'    ,  "
            . "    '" . $merida_rock_mis_assistant. "'    ,  "
            . "    '" . $perigrafi_rock_mis_assistant. "'    ,  "
            . "    '" . $egatastasis_ktiria. "'    ,  "
            . "    '" . $kairos. "'    ,  "
            . "    '" . $topikes_arxes_ekav. "'    ,  "
            . "    '" . $topikes_arxes_elas. "'    ,  "
            . "    '" . $topikes_arxes_limeniko. "'    ,  "
            . "    '" . $topikes_arxes_pyrosvestiki. "'    ,  "
            . "    '" . $anagnorisi. "'    ,  "
            . "    '" . $exoudeterosi. "'    ,  "
            . "    '" . $perisillogi. "'    ,  "
            . "    '" . $metafora. "'    ,  "
            . "    '" . $katastrofi. "'    ,  "
            . "    '" . $elegxos_estias. "'    ,  "
            . "    '" . $paratiriseis. "'    ,  "
            . "    '" . $zimies. "'    ,  "
            . "    '" . $epikefalis. "'    ,  "
            . "    '" . $status_id. "'     , "
			. "    '" . $peristatiko_key_notes. "'      "
            . " ) ");


    $con->close();

    return '    ' . $peristatiko_id . ' ' . $personal_details_id . ' ';
}

function InstanceExplosive($peristatiko_id, $ekriktika_lot_id, $ekr_posotika) {

    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");
    $con->query("  INSERT INTO peristatiko_ekriktika VALUES(    NULL, '" . $peristatiko_id . "', '" . $ekriktika_lot_id . "' , '" . $ekr_posotika . "'   ) ");
    $con->close();

    return '    ' . $peristatiko_id . ' ' . $ekriktika_lot_id . ' ' . $ekr_posotika . '';
}

function InstanceEquipment($peristatiko_id, $exoplismos_id, $exo_posotika) {

    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");
    $con->query("  INSERT INTO peristatiko_exoplismos VALUES(    NULL, '" . $peristatiko_id . "', '" . $exoplismos_id . "' , '" . $exo_posotika . "'   ) ");
    $con->close();

    return '    ' . $peristatiko_id . ' ' . $exoplismos_id . ' ' . $exo_posotika . '';
}

function EditPersonaleDetails(
$personal_details_id, $pd_vathmos, $pd_oplo_soma, $pd_onoma, $pd_eponimo, $pd_am, $monada_id, $eod,$roles_id, $pd_username, $pd_password, $choosenWord) {


    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");

    $con->query("  UPDATE personal_details SET "
            . "pd_vathmos='" . $pd_vathmos . "' ,"
            . "pd_oplo_soma='" . $pd_oplo_soma . "' ,"
            . "pd_onoma='" . $pd_onoma . "' ,"
            . "pd_eponimo='" . $pd_eponimo . "' ,"
            . "pd_am='" . $pd_am . "' ,"
            . "monada_id='" . $monada_id . "' ,"
            . "eod='" . $eod . "' ,"
            . "roles_id='" . $roles_id . "' ,"
            . "pd_username='" . $pd_username . "' ,"
            . "pd_password='" . $pd_password . "' ,"
            . "choosenWord='" . $choosenWord . "' "
            . "WHERE  personal_details_id='" . $personal_details_id . "'    ");
    $con->close();

    return '    ' . $personal_details_id . ' ' . $pd_vathmos . ' ';
}

function RecoverPassword($username, $pd_am, $new_password, $choosenWord) {


    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");

    $con->query("  UPDATE personal_details SET "
            . "pd_password='" . $new_password . "' "
            . "WHERE  pd_username='" . $username . "'   AND "
            . "choosenWord='" . $choosenWord . "' AND "
            . "pd_am='" . $pd_am . "'"
            . "");
    $con->close();

    return '    ' . $username . ' ' . $new_password . ' ';
}

function UpdateStatusKEY($peristatiko_id, $status_id,$peristatiko_key_notes) {

    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");
    $con->query("  UPDATE peristatiko SET peristatiko_key_notes='" . $peristatiko_key_notes . "', status_id='" . $status_id . "'  WHERE  peristatiko_id='" . $peristatiko_id . "'");
    $con->close();

    return '    ' . $peristatiko_id . ' ' . $status_id . ' ';
}

function UpdateStatus($peristatiko_id, $status_id,$peristatiko_key_notes) {

    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");
    $con->query("  UPDATE peristatiko SET  peristatiko_key_notes='" . $peristatiko_key_notes . "',status_id='" . $status_id . "'  WHERE  peristatiko_id='" . $peristatiko_id . "'");
    $con->close();

    return '    ' . $peristatiko_id . ' ' . $status_id . ' ';
}

function EditInstance(
$peristatiko_id, $ps_date, $ps_topos, $ps_ora_enarxis, $ps_ora_lixis, $ao_nsn, $merida, $quantity, $perigrafi, $sn, $ao_nsn_prl, $merida_prl, $perigrafi_prl, $ao_nsn_rock_mis_assistant, $merida_rock_mis_assistant, $perigrafi_rock_mis_assistant, $egatastasis_ktiria, $kairos, $topikes_arxes_ekav, $topikes_arxes_elas, $topikes_arxes_limeniko, $topikes_arxes_pyrosvestiki, $anagnorisi, $exoudeterosi, $perisillogi, $metafora, $katastrofi, $elegxos_estias, $paratiriseis, $zimies, $epikefalis, $status_id
) {

    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");
    $con->query("  UPDATE peristatiko SET  "
            . "ps_date='" . $ps_date . "' , "
            . "ps_topos='" . $ps_topos . "'  ,"
            . "ps_ora_enarxis='" . $ps_ora_enarxis . "'  ,"
            . "ps_ora_lixis='" . $ps_ora_lixis . "'  ,"
            . "ao_nsn='" . $ao_nsn . "'  ,"
            . "merida='" . $merida . "'  ,"
            . "quantity='" . $quantity . "'  ,"
            . "perigrafi='" . $perigrafi . "'  ,"
            . "sn='" . $sn . "'  ,"
            . "ao_nsn_prl='" . $ao_nsn_prl . "'  ,"
            . "merida_prl='" . $merida_prl . "'  ,"
            . "perigrafi_prl='" . $perigrafi_prl . "'  ,"
            . "ao_nsn_rock_mis_assistant='" . $ao_nsn_rock_mis_assistant . "'  ,"
            . "merida_rock_mis_assistant='" . $merida_rock_mis_assistant . "'  ,"
            . "perigrafi_rock_mis_assistant='" . $perigrafi_rock_mis_assistant . "'  ,"
            . "egatastasis_ktiria='" . $egatastasis_ktiria . "'  ,"
            . "kairos='" . $kairos . "'  ,"
            . "topikes_arxes_ekav='" . $topikes_arxes_ekav . "'  ,"
            . "topikes_arxes_elas='" . $topikes_arxes_elas . "'  ,"
            . "topikes_arxes_limeniko='" . $topikes_arxes_limeniko . "'  ,"
            . "topikes_arxes_pyrosvestiki='" . $topikes_arxes_pyrosvestiki . "' ,"
            . "topikes_arxes_pyrosvestiki='" . $topikes_arxes_pyrosvestiki . "' , "
            . "anagnorisi='" . $anagnorisi . "'  ,"
            . "exoudeterosi='" . $exoudeterosi . "'  ,"
            . "perisillogi='" . $perisillogi . "'  ,"
            . "metafora='" . $metafora . "'  ,"
            . "katastrofi='" . $katastrofi . "'  ,"
            . "elegxos_estias='" . $elegxos_estias . "' , "
            . "paratiriseis='" . $paratiriseis . "'  ,"
            . "zimies='" . $zimies . "'  ,"
            . "perisillogi='" . $perisillogi . "'  ,"
            . "epikefalis='" . $epikefalis . "'  ,"
            . "status_id='" . $status_id . "'  "
            . "WHERE  peristatiko_id='" . $peristatiko_id . "'");

    $con->close();

    return '    ' . $peristatiko_id . ' ';
}
function DeleteInstance($peristatiko_id) {


    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");

    $con->query("  DELETE FROM  peristatiko "
            . " WHERE  peristatiko_id='" . $peristatiko_id . "'   "
            . "");
    $con->close();

    return '  ';
}

function DeleteExplosiveInstance($peristatikoExplosive) {


    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");

    $con->query("  DELETE FROM  peristatiko_ekriktika "
            . " WHERE  peristatiko_ekriktika_lot_id='" . $peristatikoExplosive . "'   "
            . "");
    $con->close();

    return '  ';
}

function DeleteEquipmentInstance($peristatikoEquipment) {


    $con = getDBConnection();
    mysqli_set_charset($con, "utf8");

    $con->query("  DELETE FROM  peristatiko_exoplismos "
            . " WHERE  peristatiko_exoplismos_id='" . $peristatikoEquipment . "'   "
            . "");
    $con->close();

    return '  ';
}
// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
