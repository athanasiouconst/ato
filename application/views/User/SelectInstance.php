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
            $queryPD = "SELECT * FROM personal_details where   personal_details_id='" . $personal_details_id . "' ";
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
                                            <h2>Για τη Συνέχιση του περιστατικού, εισάγετε τα παρακάτω στοιχεία :</h2>
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
                                            <?php echo form_open('User/SaveTempInstanceNext') ?>
                                            <div class="btn btn-group-justified" style="width: 100%; font-size: 18px; padding-left: 50%;">
                                                <input type="hidden" name="personal_details_id" id="personal_details_id" value="<?php echo set_value('personal_details_id'); ?>"  />
                                                <input type="hidden" name="katanomi_armodiotiton_id" id="katanomi_armodiotiton_id" value="<?php echo set_value('katanomi_armodiotiton_id'); ?>"  />
                                                <input type="hidden" name="katigoria_sumvantos_id" id="katigoria_sumvantos_id" value="<?php echo set_value('katigoria_sumvantos_id'); ?>"  />
                                                <input type="hidden" name="eidos_sumvantos_id" id="eidos_sumvantos_id" value="<?php echo set_value('eidos_sumvantos_id'); ?>"  />
                                                <input type="hidden" name="eidos_puromaxikou_id" id="eidos_puromaxikou_id" value="<?php echo set_value('eidos_puromaxikou_id'); ?>"  />
                                                <input type="hidden" name="katigoria_proteraiotitas_id" id="katigoria_proteraiotitas_id" value="<?php echo set_value('katigoria_proteraiotitas_id'); ?>"  />
                                                <input type="hidden" name="thesi_simvantos_id" id="thesi_simvantos_id" value="<?php echo set_value('thesi_simvantos_id'); ?>"  />
                                                <input type="hidden" name="document" id="document" value="<?php echo set_value('document'); ?>"  />


                                                <p><?php echo form_submit('submit', ' ΠΡΟΣΩΡΙΝΗ ΑΠΟΘΗΚΕΥΣΗ '); ?></p>
                                                <?php echo form_close() ?>
                                            </div>      
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td>
                                            <?php echo form_open('User/SelectInstanceNext') ?>
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
                                                <p><label for="katanomi_armodiotiton_id"></label>
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
                                                <p><label for="katigoria_sumvantos_id"></label>
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
                                                    </select> 
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="επιλέξτε το είδος του συμβάντος">
                                                <p><label for="eidos_sumvantos_id"></label>
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
                                                <p><label for="eidos_puromaxikou_id"></label>
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
                                                <p><label for="katigoria_proteraiotitas_id"></label>
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
                                        <td> <span title="Συμπληρώστε το σήμα διάθεσης πυροτεχνουργού"><p>
                                                    <input type="text" name="document" id="document" placeholder="Σήμα Διάθεσης Πυροτεχνουργού" value="<?php echo set_value('document'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td> <span title="Συμπληρώστε την ημερομηνία του περιστατικού">                                           
                                                <p>
                                                    <input type="text" name="ps_date" id="ps_date" placeholder="Ημερομηνία" value="<?php
                                                    date_default_timezone_set('UTC');
                                                    echo date('Y-m-j');
                                                    ?>"  />                          
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη περιοχή του περιστατικού"> <p>
                                                    <input type="text" name="ps_topos" id="ps_topos" placeholder="Περιοχή Δράσης" value="<?php echo set_value('ps_topos'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συμπληρώστε την ώρα έναρξης των εργασιών"><p>
                                                    <input type="text" name="ps_ora_enarxis" id="ps_ora_enarxis" placeholder="Ώρα Έναρξης" value="<?php
                                                    date_default_timezone_set('UTC');
                                                    echo date('Y-m-j, H:i:s');
                                                    ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε την ώρα λήξης των εργασιών"><p>
                                                    <input type="text" name="ps_ora_lixis" id="ps_ora_lixis" placeholder="Ώρα Λήξης" value="<?php
                                                    date_default_timezone_set('UTC');
                                                    echo date('Y-m-j, H:i:s');
                                                    ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τον Αριθμό Ονομαστικού, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΑΦΕΤΑΙ'"><p>
                                                    <input type="text" name="ao_nsn" id="ao_nsn" placeholder="Αριθμός Ονομαστικού" value="<?php echo set_value('ao_nsn'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη Μερίδα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΑΦΕΤΑΙ'"><p>
                                                    <input type="text" name="merida" id="merida" placeholder="Μερίδα Πυρομαχικού" value="<?php echo set_value('merida'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη Ποσότητα των ανευρεθέντων πυρομαχικών"><p>
                                                    <input type="text" name="quantity" id="quantity" placeholder="Ποσότητα Ανευρεθέντων Πυρομαχικών" value="<?php echo set_value('quantity'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συμπληρώστε τη περιγραφή του αντικειμένου"><p>
                                                    <textarea rows="4" name="perigrafi" class="input-block-level"  id="perigrafi" placeholder="* Περιγραφή..." value="<?php echo set_value('perigrafi'); ?>" ><?php echo set_value('perigrafi'); ?></textarea>
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τον Σειριακό Αριθμό, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΑΦΕΤΑΙ'"><p>
                                                    <input type="text" name="sn" id="sn" placeholder="Σειριακός Αριθμός" value="<?php echo set_value('sn'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τον Αριθμό Ονομαστικού του Πυροσωλήνα, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΑΦΕΤΑΙ'"><p>
                                                    <input type="text" name="ao_nsn_prl" id="ao_nsn_prl" placeholder="Αριθμός Ονομαστικού Πυροσωλήνα" value="<?php echo set_value('ao_nsn_prl'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη Μερίδα του Πυροσωλήνα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΑΦΕΤΑΙ'"><p>
                                                    <input type="text" name="merida_prl" id="merida_prl" placeholder="Μερίδα Πυροσωλήνα" value="<?php echo set_value('merida_prl'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη περιγραγή του πυροσωλήνα"><p>
                                                    <textarea rows="4" name="perigrafi_prl" class="input-block-level" id="perigrafi_prl" placeholder="* Περιγραφή Πυροσωλήνα ..." value="<?php echo set_value('perigrafi_prl'); ?>" ><?php echo set_value('perigrafi_prl'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>

                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τον Αριθμό Ονομαστικού του κινητήρα, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΑΦΕΤΑΙ'"><p>
                                                    <input type="text" name="ao_nsn_rock_mis_assistant" id="ao_nsn_rock_mis_assistant" placeholder="Αριθμός Ονομαστικού Κινητήρα" value="<?php echo set_value('ao_nsn_rock_mis_assistant'); ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη μερίδα του κινητήρα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΑΦΕΤΑΙ'"><p>
                                                    <input type="text" name="merida_rock_mis_assistant" id="merida_rock_mis_assistant" placeholder="Μερίδα Κινητήρα"   value="<?php echo set_value('merida_rock_mis_assistant'); ?>"  />                                                
                                            </span>
                                        </td>


                                    </tr>
                                    <tr class="insertform">
                                        <td><span title="Συπληρώστε τη περιγραφή του κινητήρα"><p>
                                                    <textarea rows="4" name="perigrafi_rock_mis_assistant" class="input-block-level" id="perigrafi_rock_mis_assistant" placeholder="* Περιγραφή Κινητήρα ..." value="<?php echo set_value('perigrafi_rock_mis_assistant'); ?>" ><?php echo set_value('perigrafi_rock_mis_assistant'); ?></textarea>                                                
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 50%;">
                                        <span class="sr-only">50% Complete</span><b>  5 0  %</b>
                                    </div>
                                </div>


                                <div class="btn btn-group-justified" style="padding-left: 60%;">
                                    <p><?php echo form_submit('submit', ' E Π Ο Μ Ε Ν Ο '); ?></p>
                                    <?php echo form_close() ?>


                                </div>
                            </div>
                        </div>
                    </div>
            </section>


            <?php $this->load->view('Include/include_footer'); ?>