<?php $this->load->view('Include/public_content'); ?>

<section id="featured">
    <!-- start slider -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Slider -->
                <div id="main-slider" class="flexslider">
                    <ul class="slides">
                        <li>
                            <img src="<?php echo base_url(); ?>img/slides/1.jpg" alt="" />
                            <div class="flex-caption">
                                <h3>Σκοπος</h3> 
                                <p>Η καταχώρηση και παρακολούθηση των περιστατικών εξουδετερώσεων και καταστροφών πυρομαχικών</p> 
                                <a href="#info" class="btn btn-theme">για περισσοτερα...</a>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo base_url(); ?>img/slides/2.jpg" alt="" />
                            <div class="flex-caption">
                                <h3>οφελος</h3> 
                                <p>Δημιουργία ιστορικού επεμβάσεων στελεχών και περιοχών</p> 
                                <a href="#info" class="btn btn-theme">για περισσοτερα...</a>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo base_url(); ?>img/slides/3.jpg" alt="" />
                            <div class="flex-caption">
                                <h3>Ενημερωση</h3> 
                                <p>Άμεση ενημέρωση των περιστατικών από τα ίδια τα στελέχη</p> 
                                <a href="#info" class="btn btn-theme">για περισσοτερα...</a>
                            </div>
                        </li>
                        <li>
                            <img src="<?php echo base_url(); ?>img/slides/4.jpg" alt="" />
                            <div class="flex-caption">
                                <h3>Πληροφοριες</h3> 
                                <p>Προσωπικές πληροφορίες επεμβάσεων σε περιστατικά καταστροφής πυρομαχικών</p> 
                                <a href="#info" class="btn btn-theme">για περισσοτερα...</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- end slider -->
            </div>
        </div>
    </div>	
</section>
<section ><div id="info" style="padding-top: 50px;"></div></section>
<section id="content">
    <div class="container" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="box">
                            <div class="box-gray aligncenter">
                                <h4>Σκοπός</h4>
                                <div class="icon">
                                    <i class="fa fa-archive fa-4x"></i>
                                </div>
                                <p>
                                    Η καταχώρηση και παρακολούθηση των περιστατικών εξουδετερώσεων και καταστροφών πυρομαχικών
                                    που εκτελούνται από πυροτεχνουργούς του Σώματος Υλικού Πολέμου.
                                </p>

                            </div>
                            <!--                            <div class="box-bottom">
                                                            <a href="#">Learn more</a>
                                                        </div>-->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box">
                            <div class="box-gray aligncenter">
                                <h4>Όφελος</h4>
                                <div class="icon">
                                    <i class="fa fa-trophy fa-4x"></i>
                                </div>
                                <p>Δημιουργία ιστορικού επεμβάσεων στελεχών και περιοχών</p>
                                <p>Αποφυγή καθυστέρησης ενημέρωσης των πυροτεχνουργών.</p>

                            </div>
                            <!--                            <div class="box-bottom">
                                                            <a href="#">Learn more</a>
                                                        </div>-->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box">
                            <div class="box-gray aligncenter">
                                <h4>Ενημέρωση</h4>
                                <div class="icon">
                                    <i class="fa fa-tablet fa-4x"></i>
                                </div>
                                <p>Άμεση ενημέρωση των περιστατικών από τα ίδια τα στελέχη</p>
                                <p>Ενημέρωση όλων των πυροτεχνουργών για τις διαδικασίες και τον εξοπλισμό, ανάλογα το 
                                περιστατικό</p>
                                
                            </div>
                            <!--                            <div class="box-bottom">
                                                            <a href="#">Learn more</a>
                                                        </div>-->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box">
                            <div class="box-gray aligncenter">
                                <h4>Πληροφορίες</h4>
                                <div class="icon">
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <p>Προσωπικές πληροφορίες επεμβάσεων σε περιστατικά καταστροφής πυρομαχικών.</p>
                                <p>Προβολή πλήρων περιστατικών</p>
                                <p>Προβολή του αριθμού των επεμβάσεων των στελεχών.</p>

                            </div>
                            <!--                            <div class="box-bottom">
                                                            <a href="#">Learn more</a>
                                                        </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- divider -->
        <div class="row">
            <div class="col-lg-12">
                <div class="solidline">
                </div>
            </div>
        </div>
        <!-- end divider -->
        <?php $this->load->view('Include/public_footer'); ?>
