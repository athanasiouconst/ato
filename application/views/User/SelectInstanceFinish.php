<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Κέντρο Ελέγχου Υλικών/Διεύθυνση Πυρομαχικών</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="Hellenic Material Control Center/Ammunition Departement" />
        <!-- css -->
        <link href="<?php echo base_url(); ?>/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/jcarousel.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/flexslider.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" />

        <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico">

        <!-- Theme skin -->
        <link href="<?php echo base_url(); ?>skins/default.css" rel="stylesheet" />

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
              <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
        <script>
            $(document).ready(function () {
                $('ul.nav li.dropdown').hover(function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(200);
                }, function () {
                    $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(200);
                });
            });
        </script>
    </head>

    <body>

        <div id="wrapper">
            <!-- start header -->
            <header>
                <div class="navbar navbar-default navbar-static-top">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <?php if ($this->session->userdata('userIsLoggedIn')) { ?>
                                <a class="navbar-brand" href="<?php echo base_url('User'); ?>"><span>ΚΕΝΤΡΟ ΕΛΕΓΧΟΥ ΥΛΙΚΩΝ</span><br>ΔΙΕΥΘΥΝΣΗ ΠΥΡΟΜΑΧΙΚΩΝ</a>
                            <?php } else { ?>
                                <a class="navbar-brand" href="<?php echo base_url(); ?>"><span>ΚΕΝΤΡΟ ΕΛΕΓΧΟΥ ΥΛΙΚΩΝ</span><br>ΔΙΕΥΘΥΝΣΗ ΠΥΡΟΜΑΧΙΚΩΝ</a>
                            <?php } ?>
                        </div>
                        <div class="navbar-collapse collapse ">
                            <ul class="nav navbar-nav">
                                <?php if ($this->session->userdata('userIsLoggedIn')) { ?>
                                    <li class="active"><a href="<?php echo base_url(); ?>">PORTAL</a></li>                                
                                    <li class="active"><a href="<?php echo base_url('User'); ?>">ΑΡΧΙΚΗ</a></li>
                                    <li><a href="<?php echo base_url('User'); ?>#news">ΝΕΑ ΠΕΡΙΣΤΑΤΙΚΑ</a></li>
                                    <li><a href="<?php echo base_url('User'); ?>#contact">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>


                                    <?php
                                    $queryPD = "SELECT roles_id FROM personal_details where   pd_username='" . $username . "' ";
                                    $PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
                                    $num_PD = mysql_num_rows($PD);
                                    ?>

                                    <?php
                                    for ($i = 0; $i < $num_PD; $i++) {
                                        $role = mysql_result($PD, $i, 'roles_id');
                                    }
                                    ?>


                                    <!-- Menu  Χρήστης Εφαρμογής-->
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">ΛΟΓΑΡΙΑΣΜΟΣ <b class=" icon-angle"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo base_url('User/ViewPersonalDetails'); ?>">ΠΡΟΣΩΠΙΚΕΣ ΠΛΗΡΟΦΟΡΙΕΣ</a></li>
                                        </ul>
                                    </li>

                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">ΜΕΝΟΥ <b class=" icon-angle"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo base_url('User/ViewInstance'); ?>">ΠΕΡΙΣΤΑΤΙΚΑ</a></li>
                                        </ul>
                                    </li>

                                    <li><a href="<?php echo base_url('User/Logout'); ?>" >ΑΠΟΣΥΝΔΕΣΗ</a></li>



                                <?php } else { ?>
                                    <li class="active"><a href="<?php echo base_url(); ?>">ΑΡΧΙΚΗ</a></li>
                                    <li><a href="<?php echo base_url('User'); ?>" target="_blank" >ΣΥΝΔΕΣΗ</a></li>
                                    <li><a href="<?php echo base_url(); ?>#news">ΝΕΑ ΠΕΡΙΣΤΑΤΙΚΑ</a></li>
                                    <li><a href="<?php echo base_url(); ?>#contact">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>



                </div>
            </header>
            <!-- end header -->

            <?php
            $queryPD = "SELECT * FROM personal_details where   pd_username='" . $username . "' ";
            $PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
            $num_PD = mysql_num_rows($PD);
            ?>
            <?php
            $queryKA = "SELECT * FROM katanomi_armodiotiton where   katanomi_armodiotiton_id='" . $katanomi_armodiotiton_id . "' ";
            $KA = mysql_query($queryKA) or die('Error, query failed' . mysql_error());
            $num_KA = mysql_num_rows($KA);
            ?>
            <?php
            $queryKS = "SELECT * FROM katigoria_sumbantos where   katigoria_sumvantos_id='" . $katigoria_sumvantos_id . "' ";
            $KS = mysql_query($queryKS) or die('Error, query failed' . mysql_error());
            $num_KS = mysql_num_rows($KS);
            ?>
            <?php
            $queryES = "SELECT * FROM eidos_sumvantos where   eidos_sumvantos_id='" . $eidos_sumvantos_id . "' ";
            $ES = mysql_query($queryES) or die('Error, query failed' . mysql_error());
            $num_ES = mysql_num_rows($ES);
            ?> 
            <?php
            $queryEP = "SELECT * FROM eidos_puromaxikou where   eidos_puromaxikou_id='" . $eidos_puromaxikou_id . "' ";
            $EP = mysql_query($queryEP) or die('Error, query failed' . mysql_error());
            $num_EP = mysql_num_rows($EP);
            ?> 
            <?php
            $queryKP = "SELECT * FROM katigoria_proteraiotitas where   katigoria_proteraiotitas_id='" . $katigoria_proteraiotitas_id . "' ";
            $KP = mysql_query($queryKP) or die('Error, query failed' . mysql_error());
            $num_KP = mysql_num_rows($KP);
            ?>                                 
            <?php
            $queryTS = "SELECT * FROM thesi_sumvantos where   thesi_simvantos_id='" . $thesi_simvantos_id . "' ";
            $TS = mysql_query($queryTS) or die('Error, query failed' . mysql_error());
            $num_TS = mysql_num_rows($TS);
            ?>   
            <section id="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div><br><br><br><br></div>
                                <div style="float: left; padding-top: 40px;">
                                    <a href="javascript:history.go(-1)" class="btn btn-large btn-info">ΕΠΙΣΤΡΟΦΗ</a>
                                    <br><br>
                                </div>
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td>
                                            <h2>Για την ολοκλήρωση του περιστατικού, εισάγετε τα παρακάτω στοιχεία :</h2>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td>
                                            <!--  FORM -->
                                            <?php if (isset($error)) : ?>
                                                <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                                                    <strong><?= $error ?></strong>
                                                    <strong><?php echo validation_errors(); ?></strong>
                                                </div>                    
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <?php echo form_open('User/SaveInstanceNext') ?>
                                            <div class="btn btn-group-justified" style="width: 100%; font-size: 18px; padding-left: 50%;">
                                                <input type="hidden" name="personal_details_id" id="personal_details_id" value="<?php echo set_value('personal_details_id'); ?>"  />
                                                <input type="hidden" name="katanomi_armodiotiton_id" id="katanomi_armodiotiton_id" value="<?php echo set_value('katanomi_armodiotiton_id'); ?>"  />
                                                <input type="hidden" name="katigoria_sumvantos_id" id="katigoria_sumvantos_id" value="<?php echo set_value('katigoria_sumvantos_id'); ?>"  />
                                                <input type="hidden" name="eidos_sumvantos_id" id="eidos_sumvantos_id" value="<?php echo set_value('eidos_sumvantos_id'); ?>"  />
                                                <input type="hidden" name="eidos_puromaxikou_id" id="eidos_puromaxikou_id" value="<?php echo set_value('eidos_puromaxikou_id'); ?>"  />
                                                <input type="hidden" name="katigoria_proteraiotitas_id" id="katigoria_proteraiotitas_id" value="<?php echo set_value('katigoria_proteraiotitas_id'); ?>"  />
                                                <input type="hidden" name="thesi_simvantos_id" id="thesi_simvantos_id" value="<?php echo set_value('thesi_simvantos_id'); ?>"  />
                                                <input type="hidden" name="document" id="document" value="<?php echo set_value('document'); ?>"  />

                                                <input type="hidden" name="ps_date" id="ps_date" value="<?php echo set_value('ps_date'); ?>"  />
                                                <input type="hidden" name="ps_topos" id="ps_topos" value="<?php echo set_value('ps_topos'); ?>"  />
                                                <input type="hidden" name="ps_ora_enarxis" id="ps_ora_enarxis" value="<?php echo set_value('ps_ora_enarxis'); ?>"  />
                                                <input type="hidden" name="ps_ora_lixis" id="ps_ora_lixis" value="<?php echo set_value('ps_ora_lixis'); ?>"  />
                                                <input type="hidden" name="ao_nsn" id="ao_nsn" value="<?php echo set_value('ao_nsn'); ?>"  />
                                                <input type="hidden" name="merida" id="merida" value="<?php echo set_value('merida'); ?>"  />
                                                <input type="hidden" name="quantity" id="quantity" value="<?php echo set_value('quantity'); ?>"  />
                                                <input type="hidden" name="perigrafi" id="perigrafi" value="<?php echo set_value('perigrafi'); ?>"  />
                                                <input type="hidden" name="sn" id="sn" value="<?php echo set_value('sn'); ?>"  />
                                                <input type="hidden" name="ao_nsn_prl" id="ao_nsn_prl" value="<?php echo set_value('ao_nsn_prl'); ?>"  />
                                                <input type="hidden" name="merida_prl" id="merida_prl" value="<?php echo set_value('merida_prl'); ?>"  />
                                                <input type="hidden" name="perigrafi_prl" id="perigrafi_prl" value="<?php echo set_value('perigrafi_prl'); ?>"  />

                                                <input type="hidden" name="ao_nsn_rock_mis_assistant" id="ao_nsn_rock_mis_assistant" value="<?php echo set_value('ao_nsn_rock_mis_assistant'); ?>"  />
                                                <input type="hidden" name="merida_rock_mis_assistant" id="merida_rock_mis_assistant" value="<?php echo set_value('merida_rock_mis_assistant'); ?>"  />
                                                <input type="hidden" name="perigrafi_rock_mis_assistant" id="perigrafi_rock_mis_assistant" value="<?php echo set_value('perigrafi_rock_mis_assistant'); ?>"  />

                                                <p><?php echo form_submit('submit', ' ΠΡΟΣΩΡΙΝΗ ΑΠΟΘΗΚΕΥΣΗ '); ?></p>
                                                <?php echo form_close() ?>
                                            </div>      
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <?php echo form_open('User/SelectInstanceFinish') ?>    
                                            <span title="το όνομά σας">
                                                <p><label for="personal_details_id"></label>
                                                    <select name='personal_details_id' id='personal_details_id' class="select_option">
                                                        <?php
                                                        for ($i = 0; $i < $num_PD; $i++) {
                                                            ?>
                                                            <option
                                                                value="<?php echo mysql_result($PD, $i, 'personal_details_id'); ?>">
                                                                <?php echo mysql_result($PD, $i, 'pd_eponimo'); ?>,  <?php echo mysql_result($PD, $i, 'pd_onoma'); ?>,  <?php echo mysql_result($PD, $i, 'pd_am'); ?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                            </span>
                                        </td>
                                    </tr>  
                                    <tr class="insertform">
                                        <td><span title="επιλέξτε την αρμοδιότητα του περιστατικού"> 
                                                <select name='katanomi_armodiotiton_id' id='katanomi_armodiotiton_id' class="select_option">

                                                    <?php
                                                    for ($i = 0; $i < $num_KA; $i++) {
                                                        ?>
                                                        <option
                                                            value="<?php echo mysql_result($KA, $i, 'katanomi_armodiotiton_id'); ?>">
                                                                <?php echo mysql_result($KA, $i, 'ka_armodiotites'); ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td> <span title="επιλέξτε τη κατηγορία συμβάντος">          
                                                <select name='katigoria_sumvantos_id' id='katigoria_sumvantos_id' class="select_option">

                                                    <?php
                                                    for ($i = 0; $i < $num_KS; $i++) {
                                                        ?>
                                                        <option
                                                            value="<?php echo mysql_result($KS, $i, 'katigoria_sumvantos_id'); ?>">
                                                                <?php echo mysql_result($KS, $i, 'ks_epipedo'); ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select></span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="επιλέξτε το είδος του συμβάντος">
                                                <select name='eidos_sumvantos_id' id='eidos_sumvantos_id' class="select_option">

                                                    <?php
                                                    for ($i = 0; $i < $num_ES; $i++) {
                                                        ?>
                                                        <option
                                                            value="<?php echo mysql_result($ES, $i, 'eidos_sumvantos_id'); ?>">
                                                            <?php echo mysql_result($ES, $i, 'es_code'); ?> - <?php echo mysql_result($ES, $i, 'es_perigrafi'); ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>  
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="επιλέξτε το είδος του πυρομαχικού">
                                                <select name='eidos_puromaxikou_id' id='eidos_puromaxikou_id' class="select_option">
                                                    <?php
                                                    for ($i = 0; $i < $num_EP; $i++) {
                                                        ?>
                                                        <option
                                                            value="<?php echo mysql_result($EP, $i, 'eidos_puromaxikou_id'); ?>">
                                                                <?php echo mysql_result($EP, $i, 'ep_eidos'); ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </span>                            
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="επιλέξτε τη προτεραιότητα του περιστατικού">
                                                <select name='katigoria_proteraiotitas_id' id='katigoria_proteraiotitas_id' class="select_option">
                                                    <?php
                                                    for ($i = 0; $i < $num_KP; $i++) {
                                                        ?>
                                                        <option
                                                            value="<?php echo mysql_result($KP, $i, 'katigoria_proteraiotitas_id'); ?>">
                                                                <?php echo mysql_result($KP, $i, 'kp_code'); ?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>    
                                            </span>                       
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="επιλέξτε τη θέση του συμβάντος">
                                                <p><label for="thesi_simvantos_id"></label>
                                                    <select name='thesi_simvantos_id' id='thesi_simvantos_id' class="select_option">
                                                        <?php
                                                        for ($i = 0; $i < $num_TS; $i++) {
                                                            ?>
                                                            <option
                                                                value="<?php echo mysql_result($TS, $i, 'thesi_simvantos_id'); ?>">
                                                                    <?php echo mysql_result($TS, $i, 'ts_thesi'); ?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select> 
                                            </span> 
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td> 
                                            <span title="Συμπληρώστε το σήμα διάθεσης πυροτεχνουργού"><p>
                                                    <input type="text" name="document" id="document" placeholder="Σήμα Διάθεσης Πυροτεχνουργού" value="<?= $document; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td> 
                                            <span title="Συμπληρώστε την ημερομηνία του περιστατικού">                                           
                                                <p>
                                                    <input type="text" name="ps_date" id="ps_date" placeholder="Ημερομηνία" value="<?= $ps_date; ?>"  />                          
                                            </span>
                                        </td>


                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τη περιοχή του περιστατικού"> <p>

                                                    <input type="text" name="ps_topos" id="ps_topos" placeholder="Περιοχή Δράσης" value="<?= $ps_topos; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συμπληρώστε την ώρα έναρξης των εργασιών"><p>

                                                    <input type="text" name="ps_ora_enarxis" id="ps_ora_enarxis" placeholder="Ώρα Έναρξης" value="<?= $ps_ora_enarxis; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε την ώρα λήξης των εργασιών"><p>
                                                    <input type="text" name="ps_ora_lixis" id="ps_ora_lixis" placeholder="Ώρα Λήξης" value="<?= $ps_ora_lixis; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τον Αριθμό Ονομαστικού, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>

                                                    <input type="text" name="ao_nsn" id="ao_nsn" placeholder="Αριθμός Ονομαστικού" value="<?= $ao_nsn; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τη Μερίδα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                    <input type="text" name="merida" id="merida" placeholder="Μερίδα Πυρομαχικού" value="<?= $merida; ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη Ποσότητα των ανευρεθέντων πυρομαχικών"><p>
                                                    <input type="text" name="quantity" id="quantity" placeholder="Ποσότητα Ανευρεθέντων Πυρομαχικών" value="<?= $quantity; ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td>
                                            <span title="Συμπληρώστε τη περιγραφή του αντικειμένου"><p>
                                                    <textarea rows="4" name="perigrafi" class="input-block-level"  id="perigrafi" placeholder="* Περιγραφή..." value="<?= $perigrafi; ?>" ><?= $perigrafi; ?></textarea>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τον Σειριακό Αριθμό, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                    <input type="text" name="sn" id="sn" placeholder="Σειριακός Αριθμός" value="<?= $sn; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τον Αριθμό Ονομαστικού του Πυροσωλήνα, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                    <input type="text" name="ao_nsn_prl" id="ao_nsn_prl" placeholder="Αριθμός Ονομαστικού Πυροσωλήνα" value="<?= $ao_nsn_prl; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τη Μερίδα του Πυροσωλήνα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                    <input type="text" name="merida_prl" id="merida_prl" placeholder="Μερίδα Πυροσωλήνα" value="<?= $merida_prl; ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τη περιγραγή του πυροσωλήνα"><p>
                                                    <input type="text" name="perigrafi_prl" id="perigrafi_prl" placeholder="Περιγραφή Πυροσωλήνα" value="<?= $perigrafi_prl; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τον Αριθμό Ονομαστικού του κινητήρα, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                    <input type="text" name="ao_nsn_rock_mis_assistant" id="ao_nsn_rock_mis_assistant" placeholder="Αριθμός Ονομαστικού Κινητήρα" value="<?= $ao_nsn_rock_mis_assistant; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τη μερίδα του κινητήρα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                    <input type="text" name="merida_rock_mis_assistant" id="merida_rock_mis_assistant" placeholder="Μερίδα Κινητήρα" value="<?= $merida_rock_mis_assistant; ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τη περιγραφή του κινητήρα"><p>
                                                    <textarea rows="4" name="perigrafi_rock_mis_assistant" class="input-block-level" id="perigrafi_rock_mis_assistant" placeholder="* Περιγραφή Κινητήρα ..." value="<?= $perigrafi_rock_mis_assistant; ?>" ><?= $perigrafi_rock_mis_assistant; ?></textarea>
                                            </span>
                                        </td>
                                    </tr>



                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε την ύπαρξη και το είδος των εγκαταστάσεων στη γύρω περιοχή"><p>

                                                    <textarea rows="4" name="egatastasis_ktiria" class="input-block-level"  id="egatastasis_ktiria" placeholder="* Ύπαρξη Εγκαταστάσεων ..." value="<?php echo set_value('egatastasis_ktiria'); ?>" ><?php echo set_value('egatastasis_ktiria'); ?></textarea>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <span title="Συπληρώστε τις καιρικές συνθήκες κατά την διάρκεια του περιστατικού"><p>
                                                    <input type="text" name="kairos" id="kairos" placeholder="Καιρός" value="<?php echo set_value('kairos'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Επιλέξτε τη διαθεσιμότητα του ΕΚΑΒ">                                                        <p><select name="topikes_arxes_ekav" id="topikes_arxes_ekav" class="select_option">
                                                        <option value="-1">Ύπαρξη ΕΚΑΒ</option>
                                                        <option value="ΝΑΙ">Ναι</option>
                                                        <option value="ΟΧΙ">Όχι</option>
                                                    </select>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Επιλέξτε τη διαθεσιμότητα της ΕΛΛΑΣ">                                                        <p><select name="topikes_arxes_elas" id="topikes_arxes_elas" class="select_option">
                                                        <option value="-1">Ύπαρξη Ελληνικής Αστυνομίας</option>
                                                        <option value="ΝΑΙ">Ναι</option>
                                                        <option value="ΟΧΙ">Όχι</option>
                                                    </select>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Επιλέξτε τη διαθεσιμότητα του Λιμενικού">                                                        <p><select name="topikes_arxes_limeniko" id="topikes_arxes_limeniko" class="select_option">
                                                        <option value="-1">Ύπαρξη Λιμενικού</option>
                                                        <option value="ΝΑΙ">Ναι</option>
                                                        <option value="ΟΧΙ">Όχι</option>
                                                    </select>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Επιλέξτε τη διαθεσιμότητα της Πυροσβεστικής Υπηρεσίας">                                                        <p><select name="topikes_arxes_pyrosvestiki" id="topikes_arxes_pyrosvestiki" class="select_option">
                                                        <option value="-1">Ύπαρξη Πυροσβεστικής</option>
                                                        <option value="ΝΑΙ">Ναι</option>
                                                        <option value="ΟΧΙ">Όχι</option>
                                                    </select>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τις ενέργειες αναγνώρισης">                                                        <p>
                                                    <textarea rows="4" name="anagnorisi" class="input-block-level"  id="anagnorisi" placeholder="* Ενέργειες Αναγνώρισης ..." value="<?php echo set_value('anagnorisi'); ?>" ><?php echo set_value('anagnorisi'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τις ενέργειες της εξουδετέρωσης">                                                        <p>
                                                    <textarea rows="4" name="exoudeterosi" class="input-block-level"  id="exoudeterosi" placeholder="* Ενέργειες Εξουδετέρωσης ..." value="<?php echo set_value('exoudeterosi'); ?>" ><?php echo set_value('exoudeterosi'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τις ενέργειες της περισυλλογής">                                                        <p>
                                                    <textarea rows="4" name="perisillogi" class="input-block-level"  id="perisillogi" placeholder="* Ενέργειες Περισυλλογής ..." value="<?php echo set_value('perisillogi'); ?>" ><?php echo set_value('perisillogi'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τις ενέργειες της μεταφοράς">                                                        <p>
                                                    <textarea rows="4" name="metafora" class="input-block-level"  id="metafora" placeholder="* Ενέργειες Μεταφοράς ..." value="<?php echo set_value('metafora'); ?>" ><?php echo set_value('metafora'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τις ενέργειες της καταστροφής">                                                        <p>
                                                    <textarea rows="4" name="katastrofi" class="input-block-level"  id="katastrofi" placeholder="* Ενέργειες Καταστροφής ..." value="<?php echo set_value('katastrofi'); ?>" ><?php echo set_value('katastrofi'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τα αποτελέσματα του ελέγχου της εστίας, μετά την έκρηξη ή εξουδετέρωση">                                                        <p>
                                                    <textarea rows="4" name="elegxos_estias" class="input-block-level"  id="elegxos_estias" placeholder="* Ενέργειες Ελέγχου Εστίας ..." value="<?php echo set_value('elegxos_estias'); ?>" ><?php echo set_value('elegxos_estias'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τις όποιες ζημίες προκλήθηκαν στη περιοχή. Διαφορετικά συμπληρώστε 'KAMIA'">                                                        <p>
                                                    <textarea rows="4" name="zimies" class="input-block-level"  id="zimies" placeholder="* Προκληθήσες Ζημίες ..." value="<?php echo set_value('zimies'); ?>" ><?php echo set_value('zimies'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε παρατηρήσεις για το περιστατικό. Διαφορετικά συμπληρώστε 'KAMIA'">                                                        <p>
                                                    <textarea rows="4" name="paratiriseis" class="input-block-level"  id="paratiriseis" placeholder="* Παρατηρήσεις ..." value="<?php echo set_value('paratiriseis'); ?>" ><?php echo set_value('paratiriseis'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε αν είστε επικεφαλής ή όχι">                                                        <p><select name="epikefalis" id="epikefalis" class="select_option">
                                                        <option value="-1">Είστε Επικεφαλής;</option>
                                                        <option value="ΝΑΙ">Ναι</option>
                                                        <option value="ΟΧΙ">Όχι</option>
                                                    </select>
                                            </span>
                                        </td>
                                    </tr>  
                                </table>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 80%;">
                                        <span class="sr-only">80% Complete</span><b>  8 0  %</b>
                                    </div>
                                </div>


                                <div class="btn btn-group-justified" style="padding-left: 60%;">
                                    <p><?php echo form_submit('submit', ' ΕΠΙΒΕΒΑΙΩΣΗ ΣΤΟΙΧΕΙΩΝ ΠΕΡΙΣΤΑΤΙΚΟΥ'); ?></p>
                                    <?php echo form_close() ?>
                                </div>      

                            </div>
                        </div>
                    </div>
                </div>
            </section>    


            <?php $this->load->view('Include/include_footer'); ?>