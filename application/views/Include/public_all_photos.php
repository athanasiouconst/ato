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
        <section class="callaction">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="big-cta">
                            <div class="cta-text">
                                <h2><span>ΚΕΝΤΡΟ ΕΛΕΓΧΟΥ ΥΛΙΚΩΝ</span> ΔΙΕΥΘΥΝΣΗ ΠΥΡΟΜΑΧΙΚΩΝ</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>          


        <section class="callaction">
            <div class="container">

                <section id="photos">
                    <ul id="thumbs" class="portfolio">
                        <h4 class="heading">ΦΩΤΟΓΡΑΦΙΕΣ ΠΕΡΙΣΤΑΤΙΚΩΝ</h4>
                        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/lightbox.css">
                        <?php
                        $queryPhotosPeristatikou = "SELECT * FROM uploads"
                                . " LEFT JOIN peristatiko ON uploads.peristatiko_id=peristatiko.peristatiko_id "
                                . " LEFT JOIN katanomi_armodiotiton ON peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
                                . " LEFT JOIN katigoria_sumbantos ON peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
                                . " LEFT JOIN eidos_sumvantos ON peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
                                . " LEFT JOIN eidos_puromaxikou ON peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
                                . " LEFT JOIN katigoria_proteraiotitas ON peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
                                . " LEFT JOIN thesi_sumvantos ON peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
                                . " LEFT JOIN status ON peristatiko.status_id=status.status_id"
                                . " WHERE peristatiko.status_id=4"
                                . " order by peristatiko.peristatiko_id desc"
                                . " LIMIT 48";
                        $PhotosPeristatikou = mysql_query($queryPhotosPeristatikou) or die('Error, query failed' . mysql_error());
                        $num_PhotosPeristatikou = mysql_num_rows($PhotosPeristatikou);
                        ?>

                        <section>
                            <div style="margin-left: 5px;">
                                <?php for ($i = 0; $i < $num_PhotosPeristatikou; $i++) { ?>                
                                    <a class="example-image-link" href="http://100.250.160.99/ato/ownloads/Images/real/<?php echo mysql_result($PhotosPeristatikou, $i, 'img_name'); ?><?php echo mysql_result($PhotosPeristatikou, $i, 'ext'); ?>" data-lightbox="example-set" data-title="Πατήστε το βέλος για τη μετακίνηση της εικόνας δεξιά ή αριστερά.">
                                        <img class="example-image" src="http://100.250.160.99/ato/Downloads/Images/real/<?php echo mysql_result($PhotosPeristatikou, $i, 'thumb_name'); ?><?php echo mysql_result($PhotosPeristatikou, $i, 'ext'); ?>" alt=""/></a>
                                <?php } ?>
                            </div>    
                        </section>


                        <script src="<?php echo base_url(); ?>dist/js/lightbox-plus-jquery.min.js"></script>

                    </ul>
                </section>
            </div>
        </section>    


        <section class="callaction">
            <div class="container">

                <div id="contact"></div>

                <footer>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="widget">
                                    <h5 class="widgetheading">ΕΠΙΚΟΙΝΩΝΙΑ</h5>
                                    <address>
                                        <strong>ΚΕΝΤΡΟ ΕΛΕΓΧΟΥ ΥΛΙΚΩΝ</strong><br>
                                        ΑΓΙΟΣ ΣΤΕΦΑΝΟΣ, ΑΤΤΙΚΗΣ<br>
                                        ΛΕΩΦΟΡΟΣ ΚΡΥΟΝΕΡΙΟΥ 124, ΚΡΥΟΝΕΡΙ, 145 68</address>
                                    <p>
                                        <i class="icon-phone"></i> (+30) 210-8194710, ΔΠ/ΔΙΕΥΘΥΝΤΗΣ<br>
                                        <i class="icon-phone"></i> (+30) 210-8194798, ΔΠ/1ο Τμήμα<br>
                                        <i class="icon-phone"></i> (+30) 210-8194757, ΔΠ/2ο Τμήμα<br>
                                        <i class="icon-phone"></i> (+30) 210-8194786, ΔΠ/3ο Τμήμα<br><br>
                                    </p>
                                </div>
                            </div>

                            <?php $ammo_email = 'ammunition@linuxmail.aspys.gr'; ?>
                            <?php $daes_email = 'keyuser2@linuxmail.aspys.gr'; ?>
                            <div class="col-lg-4">
                                <div class="widget">
                                    <h5 class="widgetheading">ΗΛΕΚΤΡΟΝΙΚΟ ΤΑΧΥΔΡΟΜΕΙΟ</h5>
                                    <p> <i class="icon-envelope-alt"></i> <?php echo mailto($ammo_email); ?></p>
                                    <p> <i class="icon-envelope-alt"></i><?php echo mailto($daes_email); ?></p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="widget">
                                    <h5 class="widgetheading">ΒΟΗΘΗΜΑΤΑ</h5>
                                    <div class="flickr_badge">
                                        <div class="node_title_grant">

                                            ΣΚ 5-101 Κέντρο Ελέγχου Υλικών<br> 
                                            <a href="<?php echo base_url('Downloads/input/ΣΚ_5_101_ΚΕΥ.pdf'); ?>" target="_blank">
                                                δείτε εδώ ...
                                            </a>
                                        </div>
                                        <br>
                                        <div class="node_title_grant">
                                            για τη μετάβαση στο εκπαιδευτικό εγχειρίδιο <br> 
                                            <a href="<?php echo base_url('Downloads/input/ΣΚ_5_101_ΚΕΥ.pdf'); ?>" target="_blank">
                                                ... πατήστε εδώ...
                                            </a>
                                        </div>
                                    </div>
                                    <div class="clear">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <div id="sub-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12"style="margin-top:  20px;">
                            <div class="copyright align-left">
                                <span>Powered By </span> 
                                <br>&copy; <a href="<?php echo base_url(); ?>" target="_blank">ΔΙΕΥΘΥΝΣΗ ΠΥΡΟΜΑΧΙΚΩΝ</a>
                                <br>&copy; <a href="<?php echo base_url(); ?>" target="_blank">ΔΙΕΥΘΥΝΣΗ ΑΥΤΟΜΑΤΗΣ ΕΠΕΞΕΡΓΑΣΙΑΣ ΣΤΟΙΧΕΙΩΝ</a> 
                            </div>
                            <div class="copyright align-right" style="padding-right: 22px;">
                                <br>
                                <br>
                                <span>&copy; ΚΕΝΤΡΟ ΕΛΕΓΧΟΥ ΥΛΙΚΩΝ 2015 All right reserved.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </footer>
            </div>
        </section>    

        <a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
        <!-- javascript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.easing.1.3.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.fancybox.pack.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.fancybox-media.js"></script>
        <script src="<?php echo base_url(); ?>js/google-code-prettify/prettify.js"></script>
        <script src="<?php echo base_url(); ?>js/portfolio/jquery.quicksand.js"></script>
        <script src="<?php echo base_url(); ?>js/portfolio/setting.js"></script>
        <script src="<?php echo base_url(); ?>js/jquery.flexslider.js"></script>
        <script src="<?php echo base_url(); ?>js/animate.js"></script>
        <script src="<?php echo base_url(); ?>js/custom.js"></script>
        <script src="<?php echo base_url(); ?>js/alt_text.js"></script>
    </body>
</html>
