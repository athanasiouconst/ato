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

                            <a class="navbar-brand" href="<?php echo base_url(); ?>"><span>ΚΕΝΤΡΟ ΕΛΕΓΧΟΥ ΥΛΙΚΩΝ</span><br>ΔΙΕΥΘΥΝΣΗ ΠΥΡΟΜΑΧΙΚΩΝ</a>
                        </div>
                        <div class="navbar-collapse collapse ">
                            <ul class="nav navbar-nav">
                                    <li class="active"><a href="<?php echo base_url(); ?>">ΑΡΧΙΚΗ</a></li>
                                    <li><a href="<?php echo base_url('User'); ?>" target="_blank" >ΣΥΝΔΕΣΗ</a></li>
                                    <li><a href="<?php echo base_url(); ?>#news">ΝΕΑ ΠΕΡΙΣΤΑΤΙΚΑ</a></li>
                                    <li><a href="<?php echo base_url(); ?>#contact">ΕΠΙΚΟΙΝΩΝΙΑ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
            <!-- end header -->







