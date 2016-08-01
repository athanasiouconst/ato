<?php

//create passwords for users
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyz0123456789!@#$%";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 4; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

//echo randomPassword();
?>
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
                        <h1 class="page-title">Ανάκτηση Κωδικού Πρόσβασης!</h1>
                    </header>
                    <?php if (!$is_authenticated): ?>
                        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <p class="text-center text-muted">Σε περίπτωση που δε θυμάστε τα στοιχεία σας, <a href="<?php echo base_url(); ?>#contact">Επικοινωνήστε</a> με το ΚΕΥ/ΔΠ. </p>


                                    <h3>Εισάγετε υποχρεωτικά τα παρακάτω στοιχεία: </h3>
                                    <?php if (isset($error)) : ?>
                                        <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                                            <strong><?= $error ?></strong>
                                            <strong><?php echo validation_errors(); ?></strong>
                                        </div>                    
                                    <?php endif; ?>
                                    
                                    <hr>
                                    <?php echo form_open('recovery/Recoverpassword'); ?>
                                        <p><input type="hidden" size="80" id="new_password" name="new_password" value="<?php echo randomPassword() ?>"/>    
                                    <div class="top-margin">
                                        <label for="username">Username <span class="text-danger">*</span></label>
                                        <input type="text" name="username"  placeholder="Username" class="form-control">
                                    </div>
                                    <div class="top-margin">
                                        <label for="pd_am">Αριθμός Μητρώου <span class="text-danger">*</span></label>
                                        <input type="text" name="pd_am"  placeholder="Αριθμός Μητρώου" class="form-control">
                                    </div>
                                    <div class="top-margin">
                                        <label for="choosenWord">Λεκτικό Χρήστη <span class="text-danger">*</span></label>
                                        <input type="text" name="choosenWord"  placeholder="Λεκτικό Χρήστη" class="form-control">
                                    </div>
                                    <br>
                                    <input class="btn-action" type="submit" value="Ανάκτηση Κωδικού Πρόσβασης!" />
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- /Article -->
                </div>
            </div>	<?php endif; ?> 
        <!-- /container -->
        <!-- JavaScript libs are placed at the end of the document so the pages load faster 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>-->
        <script src="<?php echo base_url(); ?>assets/js/headroom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jQuery.headroom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/template.js"></script>
    </body>
</html>
