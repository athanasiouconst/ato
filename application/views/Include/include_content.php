<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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


        <link href="<?php echo base_url(); ?>/datepicker/sample/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo base_url(); ?>/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">

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
        <?php mysql_set_charset('utf8'); ?>
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

                                    <!-- Διαχειριστής Εφαρμογής -->
                                    <?php if ($role == 1) { ?>
                                        <!-- Menu  Διαχειριστής Εφαρμογής-->
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">ΛΟΓΑΡΙΑΣΜΟΣ <b class=" icon-angle"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo base_url('User/ViewPersonalDetails'); ?>">ΠΡΟΣΩΠΙΚΕΣ ΠΛΗΡΟΦΟΡΙΕΣ</a></li>
                                            </ul>
                                        </li>


                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">ΜΕΝΟΥ<b class=" icon-angle"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo base_url('User/ViewRoles'); ?>">Ρόλος</a></li>
                                                <li><a href="<?php echo base_url('User/ViewStatus'); ?>">ΚΑΤΑΣΤΑΣΗ ΑΙΤΗΣΗΣ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewMonada'); ?>">ΣΧΗΜΑΤΙΣΜΟΣ/ΜΟΝΑΔΑ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewOverMonada'); ?>">ΥΠΑΓΩΓΗ ΜΟΝΑΔΩΝ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewAmmo'); ?>">ΕΙΔΗ ΠΥΡΟΜΑΧΙΚΟΥ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewEvent'); ?>">ΕΙΔΗ ΣΥΜΒΑΝΤΟΣ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewCompetence'); ?>">ΚΑΤΑΝΟΜΗ ΑΡΜΟΔΙΟΤΗΤΩΝ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewPriority'); ?>">ΚΑΤΗΓΟΡΙΑ ΠΡΟΤΕΡΑΙΟΤΗΤΑΣ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewIncident'); ?>">ΚΑΤΗΓΟΡΙΑ ΣΥΜΒΑΝΤΟΣ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewIncidentPosition'); ?>">ΘΕΣΗ ΣΥΜΒΑΝΤΟΣ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewExplosive'); ?>">ΕΚΡΗΚΤΙΚΑ</a></li>
<!--                                                <li><a href="<?php echo base_url('User/ViewExplosiveLot'); ?>">ΜΕΡΙΔΕΣ ΕΚΡΗΚΤΙΚΩΝ</a></li>-->
                                                <li><a href="<?php echo base_url('User/ViewEquipment'); ?>">ΕΞΟΠΛΙΣΜΟΣ</a></li>
                                            </ul>
                                        </li>
                                        <!--                                        <li class="dropdown">
                                                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">SOAP Call<b class=" icon-angle"></b></a>
                                                                                    <ul class="dropdown-menu">
                                                                                        <li><a href="<?php echo base_url('User/ViewApp'); ?>">SOAP</a></li>
                                                                                    </ul>
                                                                                </li>-->

                                        <!-- Χρήστης Ρόλου ΚΕΥ -->
                                    <?php } else if ($role == 2) {
                                        ?>
                                        <!-- Menu Χρήστης Ρόλου ΚΕΥ -->
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">ΛΟΓΑΡΙΑΣΜΟΣ <b class=" icon-angle"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo base_url('User/ViewPersonalDetails'); ?>">ΠΡΟΣΩΠΙΚΕΣ ΠΛΗΡΟΦΟΡΙΕΣ</a></li>
                                            </ul>
                                        </li>

                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">ΜΕΝΟΥ <b class=" icon-angle"></b></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="<?php echo base_url('User/ViewInstanceKEYKEY'); ?>">ΠΡΟΩΘΗΣΗ ΣΤΟ ΚΕΥ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewInstanceSubmitKEY'); ?>">ΚΑΤΑΧΩΡΗΘΗΚΕ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewInstanceKEYStatistics'); ?>">ΣΤΑΤΙΣΤΙΚΑ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewAllUsers'); ?>">ΠΡΟΒΟΛΗ ΧΡΗΣΤΩΝ</a></li>

                                                <li><a href="<?php echo base_url('User/Statistics'); ?>">ΑΝΑΖΗΤΗΣΗ ΣΤΑΤΙΣΤΙΚΩΝ</a></li>
                                                <li><a href="<?php echo base_url('User/UserStatistics'); ?>">ΑΝΑΖΗΤΗΣΗ ΣΤΑΤΙΣΤΙΚΩΝ ΧΡΗΣΤΩΝ</a></li>
                                                <li><a href="<?php echo base_url('User/OverUnitStatistics'); ?>">ΑΝΑΖΗΤΗΣΗ ΠΕΡΙΣΤΑΤΙΚΩΝ ΣΧΗΜΑΤΙΣΜΩΝ</a></li>
                                                <li><a href="<?php echo base_url('User/UnitStatistics'); ?>">ΑΝΑΖΗΤΗΣΗ ΠΕΡΙΣΤΑΤΙΚΩΝ ΜΟΝΑΔΩΝ</a></li>
                                                <li><a href="<?php echo base_url('User/Uploadphotos'); ?>">ΠΡΟΣΘΗΚΗ ΦΩΤΟΓΡΑΦΙΩΝ</a></li>
                                            </ul>
                                        </li>
                                        <!-- Χρήστης Εφαρμογής -->
                                    <?php } else if ($role == 3) {
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
                                                <li><a href="<?php echo base_url('User/ViewInstanceExplosiveCreationForm'); ?>">ΠΡΟΣΘΗΚΗ ΕΚΡΗΚΤΙΚΩΝ</a></li>
                                                <li><a href="<?php echo base_url('User/ViewInstanceEquipmentCreationForm'); ?>">ΠΡΟΣΘΗΚΗ ΕΞΟΠΛΙΣΜΟΥ</a></li>

                                            </ul>
                                        </li>
                                        <?php
                                    }
                                    ?>
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
                <?php if (!$is_authenticated): ?>
                    <?php $this->load->view('User/Login'); ?>
                <?php endif; ?>


            </header>
        </div>

        <!-- end header -->







