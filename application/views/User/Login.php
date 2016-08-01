<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sign-Κέντρο Ελέγχου Υλικών/Διεύθυνση Πυρομαχικών</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="Hellenic Material Control Center/Ammunition Departement" />
        <!-- css -->
        <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/fancybox/jquery.fancybox.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/jcarousel.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/flexslider.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" />


        <link href="<?php echo base_url(); ?>skins/default.css" rel="stylesheet" />
        <meta charset="utf-8">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>img/favicon.ico">

<!--        <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">

        <!-- Custom styles for our template -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-theme.css" media="screen" >
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
    </head>

    <body>
        <!-- container -->
        <div class="container">

            <ol class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">ΑΡΧΙΚΗ</a></li>
                <li class="active">ΣΥΝΔΕΣΗ</li>
            </ol>

            <div class="row">

                <!-- Article main content -->
                <article class="col-xs-12 maincontent">
                    <header class="page-header">
                        <h1 class="page-title">Σύνδεση</h1>
                    </header>

                    <?php if (!$is_authenticated): ?>


                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <h3 class="thin text-center">Συνδεθείτε με το λογαριασμό σας!</h3>
                                    <p class="text-center text-muted">Σε περίπτωση που δε θυμάστε τα στοιχεία σας, <a href="<?php echo base_url(); ?>#contact">Επικοινωνήστε</a> με το ΚΕΥ/ΔΠ. </p>


                                    <!--                                    <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">                                     
                                                                            <h2><?php echo validation_errors(); ?></h2>
                                                                        </div>                    
                                    -->
                                    <?php if (isset($error)) : ?>
                                        <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                                            <strong><?= $error ?></strong>
                                            <strong><?php echo validation_errors(); ?></strong>
                                        </div>                    
                                    <?php endif; ?>


                                    <hr>
                                    <?php echo form_open('User/Verify'); ?>
                                    <div class="top-margin">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username"  placeholder="Username" class="form-control">
                                    </div>

                                    <div class="top-margin">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password"  placeholder="Password" class="form-control">
                                    </div>
                                    <input class="btn-action" type="submit" value="Login!" />

                                    <input class="btn-danger" type="reset" value="Clear Form" />

                                    <?php echo form_close(); ?>
                                    <div style="padding-top: 50px;padding-left: 90px;" >
                                        <a href="<?php echo base_url('recovery'); ?>" class="btn btn-large btn-dark">ανακτηση κωδικου προσβασης</a>
                                        <br><br>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </article>
                    <!-- /Article -->
                </div>
            </div>	<!-- /container -->
        <?php endif; ?> 
        <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
<!--        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
<!--        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/headroom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jQuery.headroom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/template.js"></script>
    </body>
</html>
