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
//                                        $queryPD = " SELECT * FROM peristatiko "
//                                                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
//                                                . "where (status_id = 1 OR status_id = 2) and pd_username='" . $username . "'  "
//                                                . "ORDER BY peristatiko.peristatiko_id DESC";
//                                        $PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
//                                        $num_PD = mysql_num_rows($PD);
//                                        
            ?>
            <?php
            $queryPD = " SELECT *  FROM peristatiko "
                    . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                    . "where (status_id = 3 OR status_id = 4) "
                    //. "OR peristatiko.peristatiko_id='".$num_qq."'  
                    //."limit 2,1 ";
                    . "ORDER BY peristatiko.ps_date DESC";
            $PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
            $num_PD = mysql_num_rows($PD);
            ?>

            <?php
            $queryEKR = "SELECT * FROM exoplismos ";
            $EKR = mysql_query($queryEKR) or die('Error, query failed' . mysql_error());
            $num_EKR = mysql_num_rows($EKR);
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
                                        <td colspan="5">
                                            <h2>Επιλέξτε τη φωτογραφία για το περιστατικό της επιλογής σας :</h2>
                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td colspan="5">
                                            <!--  FORM -->
                                            <?php if (isset($error)) : ?>
                                                <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                                                    <strong><?= $error ?></strong>
                                                    <strong><?php echo validation_errors(); ?></strong>
                                                </div>                    
                                            <?php endif; ?>
                                            <?php echo $this->session->flashdata('success_msg'); ?>
                                            <?php echo $this->session->flashdata('delete_msg'); ?>

                                        </td>
                                    </tr>
                                    <tr class="insertform">
                                        <td colspan="5">

                                            <?php echo form_open_multipart('User/do_upload') ?>
                                            <span title="Επιλέξτε το περιστατικό στο οποίο θα εισάγετε φωτογραφίες">
                                                <p><label for="peristatiko_id"></label>
                                                    <select style="width:100%;" name='peristatiko_id' id='peristatiko_id' class="select_option">
                                                        <option value="-1">* ...Επιλέξτε το περιστατικό... *</option>
                                                        <?php
                                                        for ($i = 0; $i < $num_PD; $i++) {
                                                            ?>
                                                            <option
                                                                value="<?php echo mysql_result($PD, $i, 'peristatiko_id'); ?>">
                                                                    <?php echo mysql_result($PD, $i, 'peristatiko_id'); ?>
                                                                /
                                                                <?php echo mysql_result($PD, $i, 'ps_date'); ?>
                                                                /
                                                                <?php echo mysql_result($PD, $i, 'ps_ora_enarxis'); ?>
                                                                /
                                                                <?php echo mysql_result($PD, $i, 'ps_topos'); ?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="file" name="userfile" size="20" />
                                        </td>
                                    </tr>

                                </table>

                                <div class="progress progress-striped active">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                        <span class="sr-only">100% Complete</span><b> 1 0 0  %</b>
                                    </div>
                                </div>


                                <div class="btn btn-group-justified" style="padding-left: 60%;">
                                    <p><input type="submit" value="Upload" class="btn btn-default btn-lg margbot5 " name="upload" /></p>
                                        <?php echo form_close() ?>
                                </div>      

                            </div>
                        </div>
                    </div>
                </div>
            </section>    


            <?php $this->load->view('Include/include_footer'); ?>



