
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
        <div class="row aligncenter">
            <div class="col-lg-12">
                <h4>ΠαΔ 2-11/Δεκ 2014/ΓΕΣ/ΔΕΠΙΧ</h4>
                <span class="pullquote-left">
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <h4>Φ.253.8/1/381203/Σ.169/24 Ιουν 07/ΓΕΣ/ΔΥΠ</h4>
                <span class="pullquote-left">   
                    <p><a href="<?php echo base_url() ?>Downloads/output/Στατιστική_Φόρμα_Πυροτεχνουργών.xls">Στατιστική Φόρμα Πυροτεχνουργών</a></p>
                    <p><a href="<?php echo base_url() ?>Downloads/output/Έκθεση_Καταστροφής.doc">Έκθεση Καταστροφής</a></p>
                </span>
            </div>
            <div class="col-lg-6">
                <h4>Φ.253.8/77/833816/Σ.2990/08 Σεπ 11/ΓΕΣ/ΔΥΠ</h4>
                <span class="pullquote-left">
                </span>
            </div>
        </div>

    </div>
</section>    



<section id="content">
    <div class="container">
        <!-- Portfolio Projects -->
        <div id="news" class="row">
            <div class="col-lg-12">
                <h4 class="heading">ΠΡΟΣΦΑΤΑ ΠΕΡΙΣΤΑΤΙΚΑ</h4>
                <div class="row">

                    <section id="projects">
                        <ul id="thumbs" class="portfolio">
                            <?php
                            $queryPD = "SELECT * FROM peristatiko"
                                    . " LEFT JOIN katanomi_armodiotiton ON peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
                                    . " LEFT JOIN katigoria_sumbantos ON peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
                                    . " LEFT JOIN eidos_sumvantos ON peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
                                    . " LEFT JOIN eidos_puromaxikou ON peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
                                    . " LEFT JOIN katigoria_proteraiotitas ON peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
                                    . " LEFT JOIN thesi_sumvantos ON peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
                                    . " LEFT JOIN status ON peristatiko.status_id=status.status_id"
                                    . " WHERE peristatiko.status_id=4"
                                    . " order by peristatiko_id desc"
                                    . " LIMIT 12";
                            $PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
                            $num_PD = mysql_num_rows($PD);
                            ?>
                            <?php if ($num_PD <> 0) { ?>
                                <?php for ($i = 0; $i < $num_PD; $i++) { ?>

                                    <?php $eidos_puromaxikou_id = mysql_result($PD, $i, 'eidos_puromaxikou_id'); ?>

                                    <?php if ($eidos_puromaxikou_id == 1) { ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 2) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 3) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 4) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 5) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 6) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 7) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 8) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 9) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 10) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 11) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 12) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 13) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 14) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 15) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 16) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 17) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 18) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 19) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 20) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 21) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 22) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } elseif ($eidos_puromaxikou_id == 23) {
                                        ?>
                                        <li class="col-lg-3 design" data-id="id-0" data-type="web">
                                            <div class="item-thumbs">

                                                <a class="hover-wrap fancybox" data-fancybox-group="gallery" title="<?php echo mysql_result($PD, $i, 'ps_date'); ?>" href="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg">
                                                    <span class="overlay-img">
                                                        <?php echo mysql_result($PD, $i, 'ep_eidos'); ?> <br>
                                                        <?php echo mysql_result($PD, $i, 'ps_date'); ?>    
                                                    </span>
                                                    <span class="overlay-img-thumb font-icon-plus"><?php echo mysql_result($PD, $i, 'ts_thesi'); ?></span>
                                                </a>

                                                <img src="<?php echo base_url(); ?>Downloads/input/public_images/9_Πυρομαχικά Αρμάτων.jpg"
                                                     alt="
                                                     <p>ΠΕΡΙΟΧΗ:    <?php echo mysql_result($PD, $i, 'ps_topos'); ?> </p>
                                                     <p>ΠΕΡΙΓΡΑΦΗ:  <?php echo mysql_result($PD, $i, 'perigrafi'); ?> </p>
                                                     <p>ΑΝΑΓΝΩΡΙΣΗ:    <?php echo mysql_result($PD, $i, 'anagnorisi'); ?> </p>
                                                     ">
                                                <p>
                                            </div>
                                            <?php $vieweach = "Δείτε περισσότερα ... "; ?>
                                            <?php $numPeristatiko = mysql_result($PD, $i, 'peristatiko_id'); ?> 
                                            <?php echo anchor("home/ViewInstanceOne/$numPeristatiko", $vieweach); ?>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                                <?php
                            } else {
                                ?>
                                <div style="padding-left: 25px;"><i>Δεν έχετε εισάγει κανένα περιστατικό!</i></div>
                                <?php
                            }
                            ?>
                            <!--                            <div class="btn btn-group-justified active">
                                                            <p><b><a href="http://localhost/atoInstance/" target="_blank">Δειτε περισσοτερα  . . .  !</a></b></p>
                                                        </div>     -->
                        </ul>
                    </section>
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
                        . " LIMIT 12";
                $PhotosPeristatikou = mysql_query($queryPhotosPeristatikou) or die('Error, query failed' . mysql_error());
                $num_PhotosPeristatikou = mysql_num_rows($PhotosPeristatikou);
                ?>

                <section>
                    <div style="margin-left: 5px;">
                        <?php if ($num_PhotosPeristatikou <> 0) { ?>
                            <?php for ($i = 0; $i < $num_PhotosPeristatikou; $i++) { ?>                
                                <a class="example-image-link" href="http://100.250.160.99/ato/Downloads/Images/real/<?php echo mysql_result($PhotosPeristatikou, $i, 'img_name'); ?><?php echo mysql_result($PhotosPeristatikou, $i, 'ext'); ?>" data-lightbox="example-set" data-title="Πατήστε το βέλος για τη μετακίνηση της εικόνας δεξιά ή αριστερά.">
                                    <img class="example-image" src="http://100.250.160.99/ato/Downloads/Images/real/<?php echo mysql_result($PhotosPeristatikou, $i, 'thumb_name'); ?><?php echo mysql_result($PhotosPeristatikou, $i, 'ext'); ?>" alt=""/></a>
                            <?php } ?>
                        <?php } else {
                            ?>
                            <div style="padding-left: 5px;"><i>Δεν έχετε εισάγει καμία φωτογραφία περιστατικού!</i></div>
                            <?php
                        }
                        ?>
                    </div>    
                </section>


                <script src="<?php echo base_url(); ?>dist/js/lightbox-plus-jquery.min.js"></script>
                <div class="btn btn-group-justified active">
                    <p><b><a href="<?php echo base_url('home/Photos'); ?>" target="_blank">Δειτε περισσοτερα  . . .  !</a></b></p>        
                </div>    
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
                                    <a href="<?php echo base_url('Downloads/input/ato_Manual.pdf'); ?>" target="_blank">
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
