
<?php $this->load->view('Include/include_content'); ?>
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
                    $queryPD = "SELECT * FROM personal_details where   pd_username='" . $username . "' ";
                    $PD = mysql_query($queryPD) or die('Error, query failed' . mysql_error());
                    $num_PD = mysql_num_rows($PD);
                    ?>
                    <?php
                    $queryKA = "SELECT * FROM katanomi_armodiotiton order by katanomi_armodiotiton_id asc";
                    $KA = mysql_query($queryKA) or die('Error, query failed' . mysql_error());
                    $num_KA = mysql_num_rows($KA);
                    ?>
                    <?php
                    $queryKS = "SELECT * FROM katigoria_sumbantos order by katigoria_sumvantos_id asc";
                    $KS = mysql_query($queryKS) or die('Error, query failed' . mysql_error());
                    $num_KS = mysql_num_rows($KS);
                    ?>
                    <?php
                    $queryES = "SELECT * FROM eidos_sumvantos order by eidos_sumvantos_id asc";
                    $ES = mysql_query($queryES) or die('Error, query failed' . mysql_error());
                    $num_ES = mysql_num_rows($ES);
                    ?> 
                    <?php
                    $queryEP = "SELECT * FROM eidos_puromaxikou order by eidos_puromaxikou_id asc";
                    $EP = mysql_query($queryEP) or die('Error, query failed' . mysql_error());
                    $num_EP = mysql_num_rows($EP);
                    ?> 
                    <?php
                    $queryKP = "SELECT * FROM katigoria_proteraiotitas order by katigoria_proteraiotitas_id asc";
                    $KP = mysql_query($queryKP) or die('Error, query failed' . mysql_error());
                    $num_KP = mysql_num_rows($KP);
                    ?>                                 
                    <?php
                    $queryTS = "SELECT * FROM thesi_sumvantos order by thesi_simvantos_id asc";
                    $TS = mysql_query($queryTS) or die('Error, query failed' . mysql_error());
                    $num_TS = mysql_num_rows($TS);
                    ?>                                  

                    <table class="table table-hover table-striped">

                        <tr>
                            <td>
                                <h2>Για τη Δημιουργία ενός περιστατικού, εισάγετε τα παρακάτω στοιχεία :</h2>
                            </td>
                        </tr>

                        <tr class="insertform">
                            <td>
                                <!--  FORM -->
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                                        <strong><?= $error ?></strong>
                                        <strong><?php echo validation_errors(); ?></strong>
                                    </div>                    
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr class="insertform">
                            <td>
                                <?php echo form_open('User/SelectInstance') ?>

                                <span title="το όνομά σας">
                                    <p>  <label for="personal_details_id"></label>
                                        <select name='personal_details_id' id='personal_details_id' class="select_option">
                                            <?php
                                            for ($i = 0; $i < $num_PD; $i++) {
                                                ?>
                                                <option
                                                    value="<?php echo mysql_result($PD, $i, 'personal_details_id'); ?>">
                                                    <?php echo mysql_result($PD, $i, 'pd_eponimo'); ?>,  <?php echo mysql_result($PD, $i, 'pd_onoma'); ?>,  <?php echo mysql_result($PD, $i, 'pd_am'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                </span>
                            </td>
                        </tr>
                        <tr class="insertform">
                            <td> <span title="επιλέξτε την αρμοδιότητα του περιστατικού"> 
                                    <p><label for="katanomi_armodiotiton_id"></label>
                                        <select name='katanomi_armodiotiton_id' id='katanomi_armodiotiton_id' class="select_option">
                                            <option value="-1">Κατανομή Αρμοδιοτήτων
                                                <?php
                                                for ($i = 0; $i < $num_KA; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($KA, $i, 'katanomi_armodiotiton_id'); ?>">
                                                        <?php echo mysql_result($KA, $i, 'ka_armodiotites'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>  
                                </span>
                            </td>
                        </tr>

                        <tr class="insertform">
                            <td><span title="επιλέξτε τη κατηγορία συμβάντος">
                                    <p><label for="katigoria_sumvantos_id"></label>
                                        <select name='katigoria_sumvantos_id' id='katigoria_sumvantos_id' class="select_option">
                                            <option value="-1">Κατηγορία Συμβάντος
                                                <?php
                                                for ($i = 0; $i < $num_KS; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($KS, $i, 'katigoria_sumvantos_id'); ?>">
                                                    <?php echo mysql_result($KS, $i, 'ks_epipedo'); ?>,<?php echo mysql_result($KS, $i, 'ks_perigrafi'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>  
                                </span>
                            </td>
                        </tr>



                        <tr class="insertform">
                            <td><span title="επιλέξτε το είδος του συμβάντος">
                                    <p><label for="eidos_sumvantos_id"></label>
                                        <select name='eidos_sumvantos_id' id='eidos_sumvantos_id' class="select_option">
                                            <option value="-1">Είδος Συμβάντος
                                                <?php
                                                for ($i = 0; $i < $num_ES; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($ES, $i, 'eidos_sumvantos_id'); ?>">
                                                    <?php echo mysql_result($ES, $i, 'es_code'); ?> - <?php echo mysql_result($ES, $i, 'es_perigrafi'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>  
                                </span>
                            </td>
                        </tr>


                        <tr class="insertform">
                            <td><span title="επιλέξτε το είδος του πυρομαχικού">
                                    <p><label for="eidos_puromaxikou_id"></label>
                                        <select name='eidos_puromaxikou_id' id='eidos_puromaxikou_id' class="select_option">
                                            <option value="-1">Είδος Πυρομαχικού
                                                <?php
                                                for ($i = 0; $i < $num_EP; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($EP, $i, 'eidos_puromaxikou_id'); ?>">
                                                        <?php echo mysql_result($EP, $i, 'ep_eidos'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select> 
                                </span>
                            </td>
                        </tr>
                        <tr class="insertform">
                            <td><span title="επιλέξτετη προτεραιότητα του περιστατικού">
                                    <p><label for="katigoria_proteraiotitas_id"></label>
                                        <select name='katigoria_proteraiotitas_id' id='katigoria_proteraiotitas_id' class="select_option">
                                            <option value="-1">Κατηγορία Προτεραιότητας
                                                <?php
                                                for ($i = 0; $i < $num_KP; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($KP, $i, 'katigoria_proteraiotitas_id'); ?>">
                                                        <?php echo mysql_result($KP, $i, 'kp_code'); ?> <?php echo mysql_result($KP, $i, 'kp_perigrafi'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select> 
                                </span>
                            </td>
                        </tr>
                        <tr class="insertform">
                            <td><span title="επιλέξτε τη θέση του συμβάντος">
                                    <p><label for="thesi_simvantos_id"></label>
                                        <select name='thesi_simvantos_id' id='thesi_simvantos_id' class="select_option">
                                            <option value="-1">Θέση Συμβάντος
                                                <?php
                                                for ($i = 0; $i < $num_TS; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($TS, $i, 'thesi_simvantos_id'); ?>">
                                                        <?php echo mysql_result($TS, $i, 'ts_thesi'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>       
                                </span>                         
                            </td>
                        </tr>

                        <tr class="insertform">
                            <td>     
                                <span title="Συμπληρώστε το σήμα διάθεσης πυροτεχνουργού">
                                    <p><label for="document"></label>
                                        <input type="text" name="document" id="document" placeholder="Σήμα Διάθεσης Πυροτεχνουργού" value="<?php echo set_value('document'); ?>"  />
                                </span>  
                            </td> 
                        </tr>



                    </table>
                    <div class="progress progress-striped active">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 25%;">
                            <span class="sr-only">25% Complete</span><b> 2 5  %</b>
                        </div>
                    </div>


                    <div class="btn btn-group-justified" style="padding-left: 60%;">
                        <p><?php echo form_submit('submit', ' E Π Ο Μ Ε Ν Ο '); ?></p>
                        <?php echo form_close() ?>
                    </div>      
                </div>
            </div>
        </div>
    </div>
</section>



<?php $this->load->view('Include/include_footer'); ?>