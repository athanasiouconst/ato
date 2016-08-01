
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
                    <table class="table table-hover table-striped">

                        <tr>
                            <td>
                                <h2>Εισάγετε τα παρακάτω στοιχεία :</h2>
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
                        <?php
                        $queryExplosive = "SELECT
                                    *
                                    FROM ekriktika
                                   order by ekriktika_id asc
                                   ";
                        $Explosive = mysql_query($queryExplosive) or die('Error, query failed' . mysql_error());
                        $num_Explosive = mysql_num_rows($Explosive);
                        ?>
                        <tr class="insertform">
                            <td>
                                <?php echo form_open('User/CreateExplosiveLot') ?>  
                                <p><span title="επιλέξτε το εκρηκτικό της επιλογής σας">
                                        <label for="ekriktika_id"></label>
                                        <select name='ekriktika_id' id='ekriktika_id' >
                                            <option value="-1">Διαθέσιμα Εκρηκτικά 
                                                <?php
                                                for ($i = 0; $i < $num_Explosive; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($Explosive, $i, 'ekriktika_id'); ?>">
                                                        <?php echo mysql_result($Explosive, $i, 'ek_eidos'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </span>

                                <p><span title="Συμπληρώστε τη μερίδα του εκρηκτικού">
                                        <input type="text" name="lot" id="lot" placeholder="Μερίδα Εκρηκτικού" value="<?php echo set_value('lot'); ?>"  />
                                    </span>
                            </td>
                        </tr>
                        
                    </table>
                    <div class="progress progress-striped active">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                            <span class="sr-only">100% Complete</span><b>1 0 0  %</b>
                        </div>
                    </div>


                    <div class="btn btn-group-justified" style="padding-left: 60%;">
                        <p><?php echo form_submit('submit', 'ΠΡΟΣΘΗΚΗ'); ?></p>
                        <?php echo form_close() ?>
                    </div>      
                </div>
            </div>
        </div>
    </div>
</section>



<?php $this->load->view('Include/include_footer'); ?>
                                      