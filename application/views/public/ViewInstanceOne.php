
<?php $this->load->view('Include/public_content'); ?>
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
                    <?php
                    if (isset($gens)):
                        ?>
                        <?php if (count($gen) > 0) : ?>
                            <?php foreach ($gen as $gen): ?>
                                <table class="table table-hover table-striped">
<!--                                    <tr><td colspan="2">ΑΥΞΩΝ ΑΡΙΘΜΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td><td><span title="Ο κωδικός του Περιστατικού"><?php echo $peristatiko; ?></span></td></tr>-->
<!--                                    <tr><td colspan="2">ΠΥΡΟΤΕΧΝΟΥΡΓΟΣ :</td><td><span title="το όνομά σας"><?php echo $gen->pd_username; ?></span></td></tr>-->
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
                                                <?php echo $genEkriktika->ek_eidos; ?>&nbsp;&nbsp;  &nbsp;&nbsp;
                                                
                                                <?php echo $genEkriktika->lot; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                
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
                    </table>
                    <br><br><br>
                </div>
            </div>
            <!-- end divider -->
        </div>
    </div>
</section>                
<link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/lightbox.css">
<script src="<?php echo base_url(); ?>dist/js/lightbox-plus-jquery.min.js"></script>


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
                                <span>Powered By </span> &copy;  <a href="<?php echo base_url(); ?>" target="_blank">ΔΙΕΥΘΥΝΣΗ ΠΥΡΟΜΑΧΙΚΩΝ</a> &copy; Created By ΑΘΑΝΑΣΙΟΥ ΚΩΝΣΤΑΝΤΙΝΟΣ 
                            </div>
                            <div class="copyright align-right" style="padding-right: 22px;">
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
</body>
</html>
