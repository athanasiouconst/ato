<?php $this->load->view('Include/include_content'); ?>
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div><br><br><br><br></div>
                    <div class="alert alert-info" style="font-size: 18px; ">
                        <i><?= $username ?></i>, <strong>συμπληρώστε τα παρακάτω πεδία, με Κεφαλαία!</strong> 
                    </div>


                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                            <strong>Συμπληρώστε τα πεδία, με Κεφαλαία!</strong>
                            <?php echo validation_errors(); ?> 
                            <?= $error ?>
                        </div>
                    <?php endif; ?>
                    <?php
                    $queryRoles = "SELECT
                                    *
                                    FROM roles
                                   order by roles_id asc
                                   ";
                    $Roles = mysql_query($queryRoles) or die('Error, query failed' . mysql_error());
                    $num_Roles = mysql_num_rows($Roles);
                    ?>
                    <?php
                    $queryMonada = "SELECT
                                    *
                                    FROM monada
                                   order by monada_id asc
                                   ";
                    $Monada = mysql_query($queryMonada) or die('Error, query failed' . mysql_error());
                    $num_Monada = mysql_num_rows($Monada);
                    ?>
                    <div class="progress progress-striped active">
                        <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                            <span class="sr-only">100% Complete</span><b>1 0 0  %</b>
                        </div>
                    </div>

                    <div class="insert_form">
                        <?php echo form_open('User/CreatePersonalDetails') ?>    
                        <br>
                        <p><span title="Συμπληρώστε το βαθμό σας">
                                <input type="text" name="pd_vathmos" id="pd_vathmos" placeholder="Βαθμός" value="<?php echo strtoupper(set_value('pd_vathmos')); ?>"  />
                            </span>
                        <p><span title="Συμπληρώστε το όπλο/σώμα που ανήκετε">
                                <input type="text" name="pd_oplo_soma" id="pd_oplo_soma" placeholder="Όπλο/Σώμα" value="<?php echo strtoupper(set_value('pd_oplo_soma')); ?>"  />
                            </span>
                        <p><span title="Συμπληρώστε το ονομά σας">
                                <input type="text" name="pd_onoma" id="pd_onoma" placeholder="Όνομα" value="<?php echo strtoupper(set_value('pd_onoma')); ?>"  />
                            </span>
                        <p><span title="Συμπληρώστε το επώνυμό σας">
                                <input type="text" name="pd_eponimo" id="pd_eponimo" placeholder="Επώνυμο" value="<?php echo strtoupper(set_value('pd_eponimo')); ?>"  />
                            </span>
                        <p><span title="Συμπληρώστε τον Αριθμό Μητρώου">
                                <input type="text" name="pd_am" id="pd_am" placeholder="ΑΜ" value="<?php echo strtoupper(set_value('pd_am')); ?>"  />
                            </span>

                        <p><span title="επιλέξτε το Σχηματισμό/Μονάδα που υπηρετείτε">
                                <label for="monada_id"></label>
                                <select name='monada_id' id='monada_id' >
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


                        <p><span title="Επιλέξτε αν είστε απόφοιτος EOD">
                                <select name='eod' id='eod'>
                                    <option value="-1">Επιλέξτε αν είστε απόφοιτος EOD</option>
                                    <option value="ΝΑΙ">ΝΑΙ</option>
                                    <option value="ΟΧΙ">ΟΧΙ</option>
                                </select>
                            </span>
                            
                        <p><span title="επιλέξτε το ρόλο χρήσης της εφαρμογής">
                                <label for="roles_id"></label>
                                <select name='roles_id' id='roles_id' >
                                    <option value="-1">Ρόλος
                                        <?php
                                        for ($i = 0; $i < $num_Roles; $i++) {
                                            ?>
                                        <option
                                            value="<?php echo mysql_result($Roles, $i, 'roles_id'); ?>">
                                            <?php echo mysql_result($Roles, $i, 'r_name'); ?>,  <?php echo mysql_result($Roles, $i, 'r_description'); ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </span>
                        <p><span title="Συμπληρώστε το username που θα χρησιμοποιήσετε στη διαδικασία εισόδου ">
                                <input type="text" name="pd_username" id="pd_username" placeholder="Username" value="<?php echo strtoupper(set_value('pd_username')); ?>"  />
                            </span>
                        <p><span title="Συμπληρώστε τον κωδικό που θα χρησιμοποιήσετε στη διαδικασία εισόδου">
                                <input type="password" name="pd_password" id="pd_password" placeholder="Password" value="<?php echo strtoupper(set_value('pd_password')); ?>"  />
                            </span>
                        <p><span title="Συμπληρώστε το λεκτικό ανάκτησης κωδικού εισόδου">
                                <input type="text" name="choosenWord" id="choosenWord" placeholder="Λεκτικό Χρήστη" value="<?php echo strtoupper(set_value('choosenWord')); ?>"  />
                            </span>    
                        <div class="btn btn-large btn-default" style="float: top; width: 140px;font-size: 30px; margin-left: 550px;">        
                            <?php echo form_submit('submit', 'Επιβεβαίωση!'); ?>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end divider -->
    </div>
</section>
<?php $this->load->view('Include/include_footer'); ?>
