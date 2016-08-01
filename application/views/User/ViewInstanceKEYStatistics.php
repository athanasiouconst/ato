
<?php $this->load->view('Include/include_content'); ?>


<section id="content"> 
    <div class="container">
        <br><br><br><br>
        <div class="row">
            <a href="javascript:history.go(-1)" class="btn btn-large btn-info">ΕΠΙΣΤΡΟΦΗ</a>
        </div>
        <div class="alert alert-info" style="font-size: 18px; padding-left:115px;">
            <h3>Συνολικά στατιστικά στοιχεία :</h3>
        </div>

        <!-- Menu  -->
        <section id="content"> 

            <?php $querySt = "SELECT * FROM status "; ?>   
            <?php
            $St = mysql_query($querySt) or die('Error, query failed' . mysql_error());
            $num_St = mysql_num_rows($St);
            $num_St;
            ?>

            <div class="container">
                <!-- status-peristatika-->
                <div class="col-lg-3">
                    <div class="pricing-box-alt">
                        <?php $queryPD_KEY1 = "SELECT * FROM peristatiko where status_id = 1  "; ?>   
                        <?php
                        $PD_KEY1 = mysql_query($queryPD_KEY1) or die('Error, query failed' . mysql_error());
                        $num_PD_KEY1 = mysql_num_rows($PD_KEY1);
                        ?>

                        <div class="pricing-heading">
                            <h3>Αρχική <strong>Κατάσταση</strong></h3>
                        </div>
                        <div class="pricing-terms">
                            <div>
                                <h6>
                                    <a href="<?php echo base_url('User/ViewInstanceStartKEY'); ?>" class="btn btn-large btn-info">ΠΡΟΒΟΛΗ</a>
                                    <br><?php echo $num_PD_KEY1; ?> 
                                    <i>περιστατικά!</i>
                                    <br><br>
                                    <i>Αριθμός Καταστροφών:</i>
                                    <br>
                                    <?php $queryQuantityKEY1Status = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 1 "; ?>   
                                    <?php
                                    $QuantityKEY1Status = mysql_query($queryQuantityKEY1Status) or die('Error, query failed' . mysql_error());
                                    $num_QuantityKEY1Status = mysql_num_rows($QuantityKEY1Status);
                                    ?>


                                    <?php
                                    for ($i = 0; $i < $num_QuantityKEY1Status; $i++) {
                                        echo $QuanaKEY1 = mysql_result($QuantityKEY1Status, $i, 'SUM(quantity)');
                                    }
                                    ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end -->


                <div class="col-lg-3">
                    <div class="pricing-box-alt">
                        <?php $queryPD_KEY2 = "SELECT * FROM peristatiko where status_id = 2 "; ?>   
                        <?php
                        $PD_KEY2 = mysql_query($queryPD_KEY2) or die('Error, query failed' . mysql_error());
                        $num_PD_KEY2 = mysql_num_rows($PD_KEY2);
                        ?>

                        <div class="pricing-heading">
                            <h3>Προσωρινή <strong>Αποθήκευση</strong></h3>
                        </div>
                        <div class="pricing-terms">
                            <div>
                                <h6>
                                    <a href="<?php echo base_url('User/ViewInstanceSaveKEY'); ?>" class="btn btn-large btn-info">ΠΡΟΒΟΛΗ</a>
                                    <br><?php echo $num_PD_KEY2; ?> 
                                    <i>περιστατικά!</i>
                                    <br><br>
                                    <i>Αριθμός Καταστροφών:</i>
                                    <br>
                                    <?php $queryQuantityKEY2Status = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 2 "; ?>   
                                    <?php
                                    $QuantityKEY2Status = mysql_query($queryQuantityKEY2Status) or die('Error, query failed' . mysql_error());
                                    $num_QuantityKEY2Status = mysql_num_rows($QuantityKEY2Status);
                                    ?>


                                    <?php
                                    for ($i = 0; $i < $num_QuantityKEY2Status; $i++) {
                                        echo $QuanaKEY2 = mysql_result($QuantityKEY2Status, $i, 'SUM(quantity)');
                                    }
                                    ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3" style="background-color: skyblue;">
                    <div class="pricing-box-alt" >
                        <?php $queryPD_KEY3 = "SELECT * FROM peristatiko where status_id = 3 "; ?>   
                        <?php
                        $PD_KEY3 = mysql_query($queryPD_KEY3) or die('Error, query failed' . mysql_error());
                        $num_PD_KEY3 = mysql_num_rows($PD_KEY3);
                        ?>

                        <div class="pricing-heading">
                            <h3><br>Προώθηση <strong>ΚΕΥ</strong></h3>
                        </div>
                        <div class="pricing-terms">
                            <div>
                                <h6>
                                    <a href="<?php echo base_url('User/ViewInstanceKEYKEY'); ?>" class="btn btn-large btn-info">ΠΡΟΒΟΛΗ</a>
                                    <br><?php echo $num_PD_KEY3; ?>
                                    <i>περιστατικά!</i>
                                    <br><br>
                                    <i>Αριθμός Καταστροφών:</i>
                                    <br>
                                    <?php $queryQuantityKEY3Status = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 3 "; ?>   
                                    <?php
                                    $QuantityKEY3Status = mysql_query($queryQuantityKEY3Status) or die('Error, query failed' . mysql_error());
                                    $num_QuantityKEY3Status = mysql_num_rows($QuantityKEY3Status);
                                    ?>


                                    <?php
                                    for ($i = 0; $i < $num_QuantityKEY3Status; $i++) {
                                        echo $QuanaKEY3 = mysql_result($QuantityKEY3Status, $i, 'SUM(quantity)');
                                    }
                                    ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="pricing-box-alt special">
                        <?php $queryPD_KEY4 = "SELECT * FROM peristatiko where status_id = 4"; ?>   
                        <?php
                        $PD_KEY4 = mysql_query($queryPD_KEY4) or die('Error, query failed' . mysql_error());
                        $num_PD_KEY4 = mysql_num_rows($PD_KEY4);
                        ?>

                        <div class="pricing-heading">
                            <h3><br><strong>Καταχωρήθηκε</strong></h3>
                        </div>
                        <div class="pricing-terms">
                            <div>
                                <h6>
                                    <a href="<?php echo base_url('User/ViewInstanceSubmitKEY'); ?>" class="btn btn-large btn-info">ΠΡΟΒΟΛΗ</a>
                                    <br><?php echo $num_PD_KEY4; ?>
                                    <i>περιστατικά!</i>
                                    <br><br>
                                    <i>Αριθμός Καταστροφών:</i>
                                    <br>
                                    <?php $queryQuantityKEY4Status = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 "; ?>   
                                    <?php
                                    $QuantityKEY4Status = mysql_query($queryQuantityKEY4Status) or die('Error, query failed' . mysql_error());
                                    $num_QuantityKEY4Status = mysql_num_rows($QuantityKEY4Status);
                                    ?>


                                    <?php
                                    for ($i = 0; $i < $num_QuantityKEY4Status; $i++) {
                                        echo $QuanaKEY4 = mysql_result($QuantityKEY4Status, $i, 'SUM(quantity)');
                                    }
                                    ?>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="alert alert-info" style="font-size: 18px;">
            <strong><?= $username ?>, δείτε τον αριθμό των καταχωρημένων περιστατικών ανά είδος συμβάντος</strong> 
        </div>

        <div class="row">
            <section id="content"> 
                <div class="container">
                    <div class="col-lg-2" >
                        <div class="pricing-box-alt" >
                            <?php $queryPDa = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=1  "; ?>   
                            <?php
                            $PDa = mysql_query($queryPDa) or die('Error, query failed' . mysql_error());
                            $num_PDa = mysql_num_rows($PDa);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΚΑΤΑΣΤΡΟΦΗ ΑΧΡΗΣΤΩΝ ΤΥΠΟΠΟΙΗΜΕΝΩΝ ΠΥΡΚΩΝ ">Α</span></strong></h3>
                            </div>

                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYACode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PDa; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantitya = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=1  "; ?>   
                                        <?php
                                        $Quantitya = mysql_query($queryQuantitya) or die('Error, query failed' . mysql_error());
                                        $num_Quantitya = mysql_num_rows($Quantitya);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantitya; $i++) {
                                            echo $Quana = mysql_result($Quantitya, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPDb = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=2 "; ?>   
                            <?php
                            $PDb = mysql_query($queryPDb) or die('Error, query failed' . mysql_error());
                            $num_PDb = mysql_num_rows($PDb);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΚΑΤΑΣΤΡΟΦΗ ΑΧΡΗΣΤΩΝ ΝΑΡΚΩΝ (ΑΡΣΗ ΝΑΡΚΟΠΕΔΙΟΥ)  ">Β</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYBCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PDb; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantityb = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=2 "; ?>   
                                        <?php
                                        $Quantityb = mysql_query($queryQuantityb) or die('Error, query failed' . mysql_error());
                                        $num_Quantityb = mysql_num_rows($Quantityb);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantityb; $i++) {
                                            echo $Quanb = mysql_result($Quantityb, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPDc = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=3 "; ?>   
                            <?php
                            $PDc = mysql_query($queryPDc) or die('Error, query failed' . mysql_error());
                            $num_PDc = mysql_num_rows($PDc);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΚΑΤΑΣΤΡΟΦΗ ΠΥΡΟΜΑΧΙΚΟΥ ΠΟΥ ΠΑΡΟΥΣΙΑΣΕ ΔΥΣΛΕΙΤΟΥΡΓΙΑ ΠΡΙΝ Η'  ΚΑΤΑ ΤΗ ΒΟΛΗ ΜΕΣΑ ΣΤΟ ΟΠΛΙΚΟ ΣΥΣΤΗΜΑ ">Γ</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYCCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PDc; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantityc = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=3  "; ?>   
                                        <?php
                                        $Quantityc = mysql_query($queryQuantityc) or die('Error, query failed' . mysql_error());
                                        $num_Quantityc = mysql_num_rows($Quantityc);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantityc; $i++) {
                                            echo $Quanc = mysql_result($Quantityc, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPDd = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=4  "; ?>   
                            <?php
                            $PDd = mysql_query($queryPDd) or die('Error, query failed' . mysql_error());
                            $num_PDd = mysql_num_rows($PDd);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΚΑΤΑΣΤΡΟΦΗ ΜΗ ΕΚΡΑΓΕΝΤΩΝ ΠΥΡΚΩΝ ">Δ</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYDCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PDd; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantityd = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=4  "; ?>   
                                        <?php
                                        $Quantityd = mysql_query($queryQuantityd) or die('Error, query failed' . mysql_error());
                                        $num_Quantityd = mysql_num_rows($Quantityd);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantityd; $i++) {
                                            echo $Quand = mysql_result($Quantityd, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD5 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=5  "; ?>   
                            <?php
                            $PD5 = mysql_query($queryPD5) or die('Error, query failed' . mysql_error());
                            $num_PD5 = mysql_num_rows($PD5);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΚΑΤΑΣΤΡΟΦΗ ΑΥΤΟΣΧΕΔΙΟΥ ΕΚΡΗΚΤΙΚΟΥ ΜΗΧΑΝΙΣΜΟΥ ">Ε</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYECode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD5; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity5 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=5 "; ?>   
                                        <?php
                                        $Quantity5 = mysql_query($queryQuantity5) or die('Error, query failed' . mysql_error());
                                        $num_Quantity5 = mysql_num_rows($Quantity5);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity5; $i++) {
                                            echo $Quan5 = mysql_result($Quantity5, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD6 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=6 "; ?>   
                            <?php
                            $PD6 = mysql_query($queryPD6) or die('Error, query failed' . mysql_error());
                            $num_PD6 = mysql_num_rows($PD6);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΕΞΟΥΔΕΤΕΡΩΣΗ - ΚΑΤΑΣΤΡΟΦΗ ΠΥΡΟΜΑΧΙΚΩΝ ΑΠΌ ΑΤΥΧΗΜΑ ">Ζ</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYFCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD6; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity6 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=6  "; ?>   
                                        <?php
                                        $Quantity6 = mysql_query($queryQuantity6) or die('Error, query failed' . mysql_error());
                                        $num_Quantity6 = mysql_num_rows($Quantity6);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity6; $i++) {
                                            echo $Quan6 = mysql_result($Quantity6, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD7 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=7 "; ?>   
                            <?php
                            $PD7 = mysql_query($queryPD7) or die('Error, query failed' . mysql_error());
                            $num_PD7 = mysql_num_rows($PD7);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΕΞΟΥΔΕΤΕΡΩΣΗ - ΚΑΤΑΣΤΡΟΦΗ ΠΑΓΙΔΕΥΜΕΝΩΝ ΠΥΡΟΜΑΧΙΚΩΝ ">Η</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYHCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD7; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity7 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=7 "; ?>   
                                        <?php
                                        $Quantity7 = mysql_query($queryQuantity7) or die('Error, query failed' . mysql_error());
                                        $num_Quantity7 = mysql_num_rows($Quantity7);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity7; $i++) {
                                            echo $Quan7 = mysql_result($Quantity7, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD8 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=8  "; ?>   
                            <?php
                            $PD8 = mysql_query($queryPD8) or die('Error, query failed' . mysql_error());
                            $num_PD8 = mysql_num_rows($PD8);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΕΞΟΥΔΕΤΕΡΩΣΗ - ΠΕΡΙΣΥΛΛΟΓΗ - ΚΑΤΑΣΤΡΟΦΗ ΕΓΚΑΤΕΣΠΑΡΜΕΝΩΝ ΠΥΡΚΩΝ ">Θ</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYGCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD8; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity8 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=8  "; ?>   
                                        <?php
                                        $Quantity8 = mysql_query($queryQuantity8) or die('Error, query failed' . mysql_error());
                                        $num_Quantity8 = mysql_num_rows($Quantity8);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity8; $i++) {
                                            echo $Quan8 = mysql_result($Quantity8, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD9 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=9  "; ?>   
                            <?php
                            $PD9 = mysql_query($queryPD9) or die('Error, query failed' . mysql_error());
                            $num_PD9 = mysql_num_rows($PD9);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΠΕΡΙΣΥΛΛΟΓΗ - ΕΝΑΠΟΘΗΚΕΥΣΗ ΠΕΙΣΤΗΡΙΩΝ - ΛΑΦΥΡΩΝ ">Ι</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYICode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD9; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity9 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=9  "; ?>   
                                        <?php
                                        $Quantity9 = mysql_query($queryQuantity9) or die('Error, query failed' . mysql_error());
                                        $num_Quantity9 = mysql_num_rows($Quantity9);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity9; $i++) {
                                            echo $Quan9 = mysql_result($Quantity9, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD10 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=10  "; ?>   
                            <?php
                            $PD10 = mysql_query($queryPD10) or die('Error, query failed' . mysql_error());
                            $num_PD10 = mysql_num_rows($PD10);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΠΕΡΙΣΥΛΛΟΓΗ - ΚΑΤΑΣΤΡΟΦΗ ΠΕΙΣΤΗΡΙΩΝ - ΛΑΦΥΡΩΝ ">Κ</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYKCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD10; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity10 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=10 "; ?>   
                                        <?php
                                        $Quantity10 = mysql_query($queryQuantity10) or die('Error, query failed' . mysql_error());
                                        $num_Quantity10 = mysql_num_rows($Quantity10);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity10; $i++) {
                                            echo $Quan10 = mysql_result($Quantity10, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD11 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=11  "; ?>   
                            <?php
                            $PD11 = mysql_query($queryPD11) or die('Error, query failed' . mysql_error());
                            $num_PD11 = mysql_num_rows($PD11);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΕΚΚΑΘΑΡΙΣΗ ΥΠΟΠΤΩΝ ΧΩΡΩΝ - ΠΕΔΙΩΝ ΒΟΛΗΣ ">Λ</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYLCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD11; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity11 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=11  "; ?>   
                                        <?php
                                        $Quantity11 = mysql_query($queryQuantity11) or die('Error, query failed' . mysql_error());
                                        $num_Quantity11 = mysql_num_rows($Quantity11);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity11; $i++) {
                                            echo $Quan11 = mysql_result($Quantity11, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD12 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=12  "; ?>   
                            <?php
                            $PD12 = mysql_query($queryPD12) or die('Error, query failed' . mysql_error());
                            $num_PD12 = mysql_num_rows($PD12);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΕΡΕΥΝΑ - ΑΝΙΧΝΕΥΣΗ - ΑΣΦΑΛΕΙΑ ΥΠΟΠΤΩΝ ΧΩΡΩΝ - ΤΡΟΜΟΚΡΑΤΙΚΩΝ ΣΤΟΧΩΝ ">Μ</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYMCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD12; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity12 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=12  "; ?>   
                                        <?php
                                        $Quantity12 = mysql_query($queryQuantity12) or die('Error, query failed' . mysql_error());
                                        $num_Quantity12 = mysql_num_rows($Quantity12);
                                        ?>


                                        <?php
                                        for ($i = 0; $i < $num_Quantity12; $i++) {
                                            echo $Quan12 = mysql_result($Quantity12, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="pricing-box-alt">
                            <?php $queryPD13 = "SELECT * FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=13  "; ?>   
                            <?php
                            $PD13 = mysql_query($queryPD13) or die('Error, query failed' . mysql_error());
                            $num_PD13 = mysql_num_rows($PD13);
                            ?>
                            <div class="pricing-heading">
                                <h3><strong><span title="ΑΛΛΗ ΠΕΡΙΠΤΩΣΗ ">Ν</span></strong></h3>
                            </div>
                            <div class="pricing-terms">
                                <div>
                                    <h8>
                                        <a href="<?php echo base_url('User/ViewInstanceKEYNCode'); ?>" class="btn btn-group-sm btn-info">ΠΡΟΒΟΛΗ</a>
                                    </h8>
                                    <br>
                                    <h6><?php echo $num_PD13; ?><br>
                                        <i>περιστατικά!</i>
                                        <br><br>
                                        <i>Αριθμός Καταστροφών:</i>
                                        <br>
                                        <?php $queryQuantity13 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=13  "; ?>   
                                        <?php
                                        $Quantity13 = mysql_query($queryQuantity13) or die('Error, query failed' . mysql_error());
                                        $num_Quantity13 = mysql_num_rows($Quantity13);
                                        ?>

                                        <?php
                                        for ($i = 0; $i < $num_Quantity13; $i++) {
                                            echo $Quan = mysql_result($Quantity13, $i, 'SUM(quantity)');
                                        }
                                        ?>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>           
        <div class="row"> 
            <?php
            if (isset($gens)):
                ?>
                <?php if (count($gen) > 0) : ?>
                    <table class="table table-hover table-striped">

                        <tr>
                            <?php foreach ($fields as $field_name => $field_display): ?>
                                <td <?php if ($sort_by == $field_name) echo "class=\"sort_$sort_order\"" ?>>
                                    <?php
                                    echo anchor("User/ViewInstanceKEYStatistics/$field_name/" .
                                            ( ($sort_order == 'asc' && $sort_by == $field_name ) ? 'desc' : 'asc' ), $field_display);
                                    ?>
                                </td>
                            <?php endforeach; ?>
                            <td>Επεξεργασία</td>
                        </tr>
                        <?php foreach ($gen as $gen): ?>
                            <tr>
                                <?php foreach ($fields as $field_name => $field_display): ?>
                                    <td>
                                        <?php
                                        echo $gen->$field_name;
                                        ?>
                                    <?php endforeach; ?> 
                                </td>
                                <td>
                                    <?php
                                    $edit = 'Επεξεργασία';
                                    $delete = 'Διαγραφή';
                                    $vieweach = 'Προβολή';
                                    $peristatiko_id = $gen->peristatiko_id;
                                    echo anchor("User/ViewInstanceOneKEY/$peristatiko_id", $vieweach, array('onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                    echo "<br>";
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>                                
                        <tr><td colspan="5" ></td></tr>
                        <tr>

                            <td colspan="10" class="pagi">
                                <?php if (strlen($pagination)): ?>
                                    <?php echo $pagination; ?>
                                <?php endif; ?>
                            </td>    
                        </tr>
                    </table>
                <?php else : ?>
                    <p><div style="padding-left: 25px;"><i>Δεν υπάρχει καταχωρημένη εγγραφή !!</i></div></p>
                <?php endif ?>
            <?php endif; ?> 
            </table>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="alert alert-info" style="font-size: 18px;">
                        <i><?= $username ?></i>, <strong>δείτε τα στατιστικά των περιστατικών, με βάση το χρήστη </strong> 
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
                    <?php
                    $queryUsername = "SELECT * FROM personal_details ";
                    $Username = mysql_query($queryUsername) or die('Error, query failed' . mysql_error());
                    $num_Username = mysql_num_rows($Username);
                    ?>


                    <?php
                    $queryUserStatis1 = "select count(*),SUM(quantity), personal_details.pd_username "
                            . "       from peristatiko "
                            . "       LEFT join personal_details on peristatiko.personal_details_id=personal_details.personal_details_id "
                            . "       where peristatiko.status_id=1 "
                            . "       GROUP BY peristatiko.personal_details_id "
                            . " limit 20";
                    $UserStat1 = mysql_query($queryUserStatis1) or die('Error, query failed' . mysql_error());
                    $num_UserStat1 = mysql_num_rows($UserStat1);

                    $queryUserStatis2 = "select count(*),SUM(quantity),  personal_details.pd_username "
                            . "       from peristatiko "
                            . "       LEFT join personal_details on peristatiko.personal_details_id=personal_details.personal_details_id "
                            . "       where peristatiko.status_id=2 GROUP BY peristatiko.personal_details_id "
                            . " limit 20";
                    $UserStat2 = mysql_query($queryUserStatis2) or die('Error, query failed' . mysql_error());
                    $num_UserStat2 = mysql_num_rows($UserStat2);

                    $queryUserStatis3 = "select count(*),SUM(quantity),  personal_details.pd_username "
                            . "       from peristatiko "
                            . "       LEFT join personal_details on peristatiko.personal_details_id=personal_details.personal_details_id "
                            . "       where peristatiko.status_id=3 GROUP BY peristatiko.personal_details_id "
                            . " limit 20";
                    $UserStat3 = mysql_query($queryUserStatis3) or die('Error, query failed' . mysql_error());
                    $num_UserStat3 = mysql_num_rows($UserStat3);

                    $queryUserStatis4 = "select count(*),SUM(quantity),  personal_details.pd_username "
                            . "       from peristatiko "
                            . "       LEFT join personal_details on peristatiko.personal_details_id=personal_details.personal_details_id "
                            . "       where peristatiko.status_id=4 GROUP BY peristatiko.personal_details_id "
                            . " limit 20";
                    $UserStat4 = mysql_query($queryUserStatis4) or die('Error, query failed' . mysql_error());
                    $num_UserStat4 = mysql_num_rows($UserStat4);
                    ?>
                    <div class="col-lg-3">

                        <table class="table table-hover table-striped">
                            <tr >
                                <td>
                                    <b>Username</b>
                                </td>
                                <td colspan="2">
                                    <b>ΑΡΧΙΚΗ <br>ΚΑΤΑΣΤΑΣΗ</b>
                                </td>
                            </tr>

                            <?php for ($i = 0; $i < $num_UserStat1; $i++) { ?>
                                <tr class="insertform">
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat1, $i, 'pd_username');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat1, $i, 'count(*)');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat1, $i, 'SUM(quantity)');
                                        ?>
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <tr>
                                <td colspan="3"><div class="btn btn-group-justified active">
                                        <p><b><a href="<?php echo base_url('User/UserStatisticsStart'); ?>" >Δειτε περισσοτερα  . . .  !</a></b></p>        
                                    </div>
                                </td>
                            </tr>
                        </table>        
                    </div>

                    <div class="col-lg-3">
                        <table class="table table-hover table-striped">
                            <tr>
                                <td>
                                    <b>Username</b>
                                </td>
                                <td colspan="2">
                                    <b>ΠΡΟΣΩΡΙΝΗ ΑΠΟΘΗΚΕΥΣΗ</b>
                                </td>
                            </tr>

                            <?php for ($i = 0; $i < $num_UserStat2; $i++) { ?>
                                <tr class="insertform">
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat2, $i, 'pd_username');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat2, $i, 'count(*)');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat2, $i, 'SUM(quantity)');
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3"><div class="btn btn-group-justified active">
                                        <p><b><a href="<?php echo base_url('User/UserStatisticsSave'); ?>" >Δειτε περισσοτερα  . . .  !</a></b></p>        
                                    </div>
                                </td>
                            </tr>
                        </table>        

                    </div>
                    <div class="col-lg-3">
                        <table class="table table-hover table-striped">
                            <tr>
                                <td>
                                    <b>Username</b>
                                </td>
                                <td colspan="2">
                                    <b>ΠΡΟΩΘΗΣΗ <br>&nbsp;ΣΤΟ ΚΕΥ</b>
                                </td>
                            </tr>

                            <?php for ($i = 0; $i < $num_UserStat3; $i++) { ?>
                                <tr class="insertform">
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat3, $i, 'pd_username');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat3, $i, 'count(*)');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat3, $i, 'SUM(quantity)');
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3"><div class="btn btn-group-justified active">
                                        <p><b><a href="<?php echo base_url('User/UserStatisticsKEY'); ?>" >Δειτε περισσοτερα  . . .  !</a></b></p>        
                                    </div>
                                </td>
                            </tr>
                        </table>        

                    </div>
                    <div class="col-lg-3">
                        <table class="table table-hover table-striped">
                            <tr>
                                <td>
                                    <b>Username</b>
                                </td>
                                <td colspan="2">
                                    <b>ΚΑΤΑΧΩΡΗΘΗΚΕ</b>
                                    <br>&nbsp;
                                </td>
                            </tr>

                            <?php for ($i = 0; $i < $num_UserStat4; $i++) { ?>
                                <tr class="insertform">
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat4, $i, 'pd_username');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat4, $i, 'count(*)');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo mysql_result($UserStat4, $i, 'SUM(quantity)');
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="3"><div class="btn btn-group-justified active">
                                        <p><b><a href="<?php echo base_url('User/UserStatisticsSubmit'); ?>" >Δειτε περισσοτερα  . . .  !</a></b></p>        
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>

                </div>
            </div>
            <!-- end divider -->
        </div>       
    </div>

</section>

<?php $this->load->view('Include/include_footer'); ?>

