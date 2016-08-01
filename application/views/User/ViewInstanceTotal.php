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



            <section id="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div><br><br><br><br></div>
                                <div class="alert alert-info" style="font-size: 18px;">
                                    <i><?= $username ?></i>, <strong>δείτε ολοκληρωμένο το περιστατικό,</strong> 
                                </div>

                                <?php echo validation_errors(); ?>
                                <?php if (isset($error)) : ?>
                                    <?= $error ?>
                                <?php endif; ?>
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
                                <div style="float: left; padding-top: 40px;">
                                    <a href="javascript:history.go(-1)" class="btn btn-large btn-info">ΕΠΙΣΤΡΟΦΗ</a>
                                    <br><br>
                                </div>
                                <?php
                    if (isset($gens)):
                        ?>
                        <?php if (count($gen) > 0) : ?>
                            <?php foreach ($gen as $gen): ?>
                                <table class="table table-hover table-striped">
                                    <tr><td colspan="2">ΑΥΞΩΝ ΑΡΙΘΜΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td><td><span title="Ο κωδικός του Περιστατικού"><?php echo $gen->peristatiko_id; ?></span></td></tr>
                                    <tr><td colspan="2">ΠΥΡΟΤΕΧΝΟΥΡΓΟΣ :</td><td><span title="το όνομά σας"><?php echo $gen->pd_username; ?></span></td></tr>
                                    <tr><td colspan="2">ΚΑΤΑΝΟΜΗ ΑΡΜΟΔΙΟΤΗΤΩΝ :</td><td><span title="η αρμοδιότητα του περιστατικού"><?php echo $gen->ka_armodiotites; ?></span></td></tr>
                                    <tr><td colspan="2">ΚΑΤΗΓΟΡΙΑ ΣΥΜΒΑΝΤΟΣ :</td><td><span title="η κατηγορία συμβάντος"><?php echo $gen->ks_epipedo; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΙΔΟΣ ΣΥΜΒΑΝΤΟΣ :</td><td><span title="το είδος του συμβάντος"><?php echo $gen->es_code; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΙΔΟΣ ΠΥΡΟΜΑΧΙΚΟΥ :</td><td><span title="το είδος του πυρομαχικού"><?php echo $gen->ep_eidos; ?></span></td></tr>
                                    <tr><td colspan="2">ΚΑΤΗΓΟΡΙΑ ΠΡΟΤΕΡΑΙΟΤΗΤΑΣ :</td><td><span title="η προτεραιότητα του περιστατικού"><?php echo $gen->kp_code; ?></span></td></tr>
                                    <tr><td colspan="2">ΘΕΣΗ ΣΥΜΒΑΝΤΟΣ :</td><td><span title="η θέση του συμβάντος"><?php echo $gen->ts_thesi; ?></span></td></tr>
                                    <tr><td colspan="2">ΣΗΜΑ ΔΙΑΘΕΣΗΣ ΠΥΡΟΤΕΧΝΟΥΡΓΟΥ :</td><td><span title="το σήμα διάθεσης πυροτεχνουργού"><?php echo $gen->document; ?></span></td></tr>
                                    <tr><td colspan="2">ΗΜΕΡΟΜΗΝΙΑ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td><td><span title="η ημερομηνία του περιστατικού"> <?php echo $gen->ps_date; ?></span></td></tr>
                                    <tr><td colspan="2">ΤΟΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td><td><span title="η περιοχή του περιστατικού"><?php echo $gen->ps_topos; ?></span></td></tr>
                                    <tr><td colspan="2">ΩΡΑ ΕΝΑΡΞΗΣ :</td><td><span title="η ώρα έναρξης των εργασιών"><?php echo $gen->ps_ora_enarxis; ?></span></td></tr>
                                    <tr><td colspan="2">ΩΡΑ ΛΗΞΗΣ :</td><td><span title="η ώρα λήξης των εργασιών"><?php echo $gen->ps_ora_lixis; ?></span></td></tr>
                                    <tr><td colspan="2">ΑΡΙΘΜΟΣ ΟΝΟΜΑΣΤΙΚΟΥ :</td><td><span title="ο Αριθμός Ονομαστικού"><?php echo $gen->ao_nsn; ?></span></td></tr>
                                    <tr><td colspan="2">ΜΕΡΙΔΑ :</td><td><span title="η Μερίδα"><?php echo $gen->merida; ?></span></td></tr>
                                    <tr><td colspan="2">ΠΟΣΟΤΗΤΑ :</td><td><span title="η Ποσότητα των ανευρεθέντων πυρομαχικών"><?php echo $gen->quantity; ?></span></td></tr>
                                    <tr><td colspan="2">ΠΕΡΙΓΡΑΦΗ ΠΥΡΟΜΑΧΙΚΟΥ :</td><td><span title="η Περιγραφή του αντικειμένου"><?php echo $gen->perigrafi; ?></span></td></tr>
                                    <tr><td colspan="2">ΣΕΙΡΙΑΚΟΣ ΑΡΙΘΜΟΣ :</td><td><span title="ο Σειριακός Αριθμός"><?php echo $gen->sn; ?></span></td></tr>
                                    <tr><td colspan="2">ΑΡΙΘΜΟΣ ΟΝΟΜΑΣΤΙΚΟΥ ΠΥΡΟΣΩΛΗΝΑ :</td><td><span title="ο Αριθμός Ονομαστικού του Πυροσωλήνα"><?php echo $gen->ao_nsn_prl; ?></span></td></tr>
                                    <tr><td colspan="2">ΜΕΡΙΔΑ ΠΥΡΟΣΩΛΗΝΑ :</td><td><span title="η Μερίδα του Πυροσωλήνα"><?php echo $gen->merida_prl; ?></span></td></tr>
                                    <tr><td colspan="2">ΠΕΡΙΓΡΑΦΗ ΠΥΡΟΣΩΛΗΝΑ :</td><td><span title="η Περιγραφή του Πυροσωλήνα"><?php echo $gen->perigrafi_prl; ?> </span></td></tr>
                                    <tr><td colspan="2">ΑΡΙΘΜΟΣ ΟΝΟΜΑΣΤΙΚΟΥ ΚΙΝΗΤΗΡΑ :</td><td><span title="ο Αριθμός Ονομαστικού του κινητήρα"><?php echo $gen->ao_nsn_rock_mis_assistant; ?></span></td></tr>
                                    <tr><td colspan="2">ΜΕΡΙΔΑ ΚΙΝΗΤΗΡΑ :</td><td><span title="η Μερίδα του κινητήρα"><?php echo $gen->merida_rock_mis_assistant; ?></span></td></tr>
                                    <tr><td colspan="2">ΠΕΡΙΓΡΑΦΗ ΚΙΝΗΤΗΡΑ :</td><td><span title="η περιγραφή του κινητήρα"><?php echo $gen->perigrafi_rock_mis_assistant; ?></span></td></tr>
                                    <tr><td colspan="2">ΥΠΑΡΧΟΥΣΕΣ ΕΓΚΑΤΑΣΤΑΣΕΙΣ :</td><td><span title="οι εγκατάστασεις της περιοχής"><?php echo $gen->egatastasis_ktiria; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΠΙΚΡΑΤΟΥΣΕΣ ΚΑΙΡΙΚΕΣ ΣΥΝΘΗΚΕΣ :</td><td><span title="επικρατούσες καιρικές συνθήκες"><?php echo $gen->kairos; ?></span></td></tr>
                                    <tr><td colspan="2">ΥΠΑΡΞΗ ΕΚΑΒ :</td><td><span title="Διαθεσιμότητα ΕΚΑΒ"><?php echo $gen->topikes_arxes_ekav; ?></span></td></tr>
                                    <tr><td colspan="2">ΥΠΑΡΞΗ ΕΛΛΑΣ :</td><td><span title="Διαθεσιμότητα ΕΛΛΑΣ"><?php echo $gen->topikes_arxes_elas; ?></span></td></tr>
                                    <tr><td colspan="2">ΥΠΑΡΞΗ ΛΙΜΕΝΙΚΟΥ :</td><td><span title="Διαθεσιμότητα Λιμενικού"><?php echo $gen->topikes_arxes_limeniko; ?></span></td></tr>
                                    <tr><td colspan="2">ΥΠΑΡΞΗ ΠΥΡΟΣΒΕΣΤΙΚΗΣ :</td><td><span title="Διαθεσιμότητα Πυροσβεστικής"><?php echo $gen->topikes_arxes_pyrosvestiki; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΝΕΡΓΕΙΕΣ ΑΝΑΓΝΩΡΙΣΗΣ :</td><td><span title="Ενέργειες Αναγνώρισης"><?php echo $gen->anagnorisi; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΝΕΡΓΕΙΕΣ ΕΞΟΥΔΕΤΕΡΩΣΗΣ :</td><td><span title="Ενέργειες Εξουδετέρωσης"><?php echo $gen->exoudeterosi; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΝΕΡΓΕΙΕΣ ΠΕΡΙΣΥΛΛΟΓΗΣ :</td><td><span title="Ενέργειες Περισυλλογής"><?php echo $gen->perisillogi; ?> </span></td></tr>
                                    <tr><td colspan="2">ΕΝΕΡΓΕΙΕΣ ΜΕΤΑΦΟΡΑΣ :</td><td><span title="Ενέργειες Μεταφοράς"><?php echo $gen->metafora; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΝΕΡΓΕΙΕΣ ΚΑΤΑΣΤΡΟΦΗΣ :</td><td><span title="Ενέργειες Καταστροφής"><?php echo $gen->katastrofi; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΝΕΡΓΕΙΕΣ ΕΛΕΓΧΟΥ ΕΣΤΙΑΣ :</td><td><span title="Έλεγχος Εστίας"><?php echo $gen->elegxos_estias; ?></span></td></tr>
                                    <tr><td colspan="2">ΠΑΡΑΤΗΡΗΣΕΙΣ :</td><td><span title="Παρατηρήσεις"><?php echo $gen->paratiriseis; ?></span></td></tr>
                                    <tr><td colspan="2">ΠΡΟΚΛΗΘΗΣΕΣ ΖΗΜΙΕΣ :</td><td><span title="Προκληθείσες ζημίες"><?php echo $gen->zimies; ?></span></td></tr>
                                    <tr><td colspan="2">ΕΙΣΤΕ ΕΠΙΚΕΦΑΛΗΣ :</td><td><span title="Επικεφαλής"><?php echo $gen->epikefalis; ?> </span></td></tr>                         
                                    <tr>
                                        <td>                                                                                              
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                                    <?php
                        if (isset($gensEkriktika)):
                            ?>
                            <?php if (count($genEkriktika) > 0) : ?>
                                <?php foreach ($genEkriktika as $genEkriktika): ?>
                                    <tr>
                                        <td colspan="2">ΕΙΔΟΣ ΕΚΡΗΚΤΙΚΟΥ :</td> 
                                        <td colspan="2">
                                            <span title="Εκρηκτικά που χρησιμοποιήθηκαν">
                                                <?php echo $genEkriktika->ek_eidos; ?>&nbsp;&nbsp;
                                                <?php echo $genEkriktika->ek_paratiriseis; ?>&nbsp;&nbsp
                                                ΠΟΣΟΤΗΤΑ : <?php echo $genEkriktika->ekr_posotika; ?></td>
                                            </span>
                                        <?php endforeach; ?>
                                    <?php endif; ?> 
                                <?php endif; ?> 
                        </tr>
                                    <?php
                        if (isset($gensExoplismos)):
                            ?>
                            <?php if (count($genExoplismos) > 0) : ?>
                                <?php foreach ($genExoplismos as $genExoplismos): ?>
                                    <tr>
                                        <td colspan="2">ΕΙΔΟΣ ΕΞΟΠΛΙΣΜΟΥ :</td> 
                                        <td colspan="2">
                                            <span title="Εξοπλισμός που χρησιμοποιήθηκε">
                                                <?php echo $genExoplismos->ex_eidos; ?>&nbsp;&nbsp;
                                                <?php echo $genExoplismos->ex_paratiriseis; ?>&nbsp;&nbsp;
                                                 ΠΟΣΟΤΗΤΑ : <?php echo $genExoplismos->exo_posotika; ?>
                                            </span>
                                        </td>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            <?php endif; ?> 
                        </tr>
                        <?php
                        if (isset($gensPhotos)):
                            ?>
                            <?php if (count($genPhotos) > 0) : ?>
                                <?php foreach ($genPhotos as $genPhotos): ?>

                                    <tr>
                                        <td colspan="2">ΔΙΑΘΕΣΙΜΕΣ ΦΩΤΟΓΡΑΦΙΕΣ :</td> 
                                        <td colspan="2">
                                            <span title="Διαθέσιμες Φωτογραφίες">
                                                <?php for ($i = 0; $i < count($genPhotos); $i++) { ?>
                                                    <a class="example-image-link" href="http://100.250.160.99/ato/Downloads/Images/real/<?php echo $genPhotos->img_name; ?><?php echo $genPhotos->ext; ?>" data-lightbox="example-set" data-title="Πατήστε το βέλος για τη μετακίνηση της εικόνας δεξιά ή αριστερά.">
                                                        <img class="example-image" src="http://100.250.160.99/ato/Downloads/Images/real/<?php echo $genPhotos->thumb_name; ?><?php echo $genPhotos->ext; ?>" alt=""/></a>
                                                <?php } ?>
                                            </span>
                                        </td>
                                    <?php endforeach; ?>
                                <?php endif ?>
                            <?php endif; ?> 
                        </tr>
                                    <?php
                                    $queryUser = "SELECT
                                                        *
                                                        FROM status
                                                       order by status_id asc
                                                       ";
                                    $user = mysql_query($queryUser) or die('Error, query failed' . mysql_error());
                                    $num_user = mysql_num_rows($user);
                                    ?>

                                </table>
                                <br><br><br>

                                <table class="table table-hover table-striped">

                                    <tr class="insertform">
                                        <td>
                                            <?php
                                            $status_id = $gen->status_id;
                                            if ($status_id == 1 || $status_id == 2) {
                                                ?>    
                                                <?php echo form_open('User/UpdateStatusKEY') ?>    
                                                <p>
                                                    <input type="hidden" name="peristatiko_id" id="peristatiko_id" placeholder="peristatiko_id" value="<?php echo $gen->peristatiko_id; ?>"  />
                                                    <?php echo validation_errors(); ?>
                                                    <?php if (isset($error)) : ?>
                                                    <div class="message error"> <?= $error ?>  </div>
                                                <?php endif; ?>
                                                <p><label for="status_id"></label>
                                                    <select name='status_id' id='status_id'  style="font-size:22px; ">
                                                        <option value="<?php echo $gen->status_id; ?>"><?php echo $gen->status_var; ?></option>
                                                        <option> </option>
                                                        <?php
                                                        for ($i = 0; $i < 3; $i++) {
                                                            ?>
                                                            <option
                                                                value="<?php echo mysql_result($user, $i, 'status_id'); ?>">
                                                                    <?php echo mysql_result($user, $i, 'status_var'); ?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                            </td>
                                        </tr>
                                        <tr class="insertform">
                                            <td>
                                                <p><?php echo form_submit('submit', 'ΕΠΙΒΕΒΑΙΩΣΗ'); ?></p>
                                            </td>
                                        </tr>
                                        <p><?php echo form_close() ?>
                                        <?php } else {
                                            ?>
                                        <tr>
                                            <td>
                                                <div style="font-size:32px; color: background;">
                                                    <span><b><?php echo $gen->status_var; ?></b></span>
                                                </div><?php }; ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- end divider -->
                    </div>
            </section>
            <?php $this->load->view('Include/include_footer'); ?>