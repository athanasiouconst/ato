
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
                        $queryMonada = "SELECT
                                    *
                                    FROM monada
                                   order by monada_id asc
                                   ";
                        $Monada = mysql_query($queryMonada) or die('Error, query failed' . mysql_error());
                        $num_Monada = mysql_num_rows($Monada);
                        ?>
                        <?php echo form_open('User/CreateOverMonada') ?> 
                        <tr class="insertform">
                            <td>

                                <p><span title="Συμπληρώστε την ονομασία του Σχηματισμού">
                                        <input type="text" name="sximatismos_name" id="sximatismos_name" placeholder="Ονομασία" value="<?php echo set_value('sximatismos_name'); ?>"  />
                                    </span>
                            </td>
                        </tr>
                        <tr class="insertform">
                            <td><span title="Συμπληρώστε τη περιοχή του Σχηματισμού">   
                                    <input type="text" name="sximatismos_area" id="sximatismos_area" placeholder="Περιοχή" value="<?php echo set_value('sximatismos_area'); ?>"  />
<!--                                    <textarea rows="6" name="monada_area" class="input-block-level" placeholder="* Περιγραφή..." value="<?php echo set_value('monada_area'); ?>" ></textarea>-->
                                    <!--<input type="text" name="ex_paratiriseis" id="ex_paratiriseis" placeholder="Παρατηρήσεις" value="<?php echo set_value('ex_paratiriseis'); ?>"  />--> 
                                </span>
                            </td>
                        </tr>
                        <tr class="insertform" >
                            <td colspan="2">   
                                <p>
                                    Επιλέξτε τη Μονάδα υπαγωγής στον Σχηματισμό <span title="επιλέξτε το Σχηματισμό/Μονάδα που υπηρετείτε">
                                        <label for="monada_id"></label>
                                        <select name='monada_id' id='monada_id' style="font-size: 20px;">
                                            <option value="-1">Σχηματισμός/Μονάδα
                                                <?php
                                                for ($i = 0; $i < $num_Monada; $i++) {
                                                    ?>
                                                <option
                                                    value="<?php echo mysql_result($Monada, $i, 'monada_id'); ?>">
                                                        <?php echo mysql_result($Monada, $i, 'monada_name'); ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
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
