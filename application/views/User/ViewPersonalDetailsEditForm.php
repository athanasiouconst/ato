

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
                                <h2>Επεξεργαστείτε τα παρακάτω στοιχεία :</h2>
                            </td>
                        </tr>

                        <tr class="insertform">
                            <td>
                                <!--  FORM -->
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 0%;  ">
                                        <strong>                                               
                                            <?php echo $this->session->flashdata('edit_msg'); ?>
                                        </strong>
                                        <strong><?php echo validation_errors(); ?></strong>
                                    </div>                    
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
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
                        <?php if (count($edit) > 0) : ?>

                            <?php foreach ($edit as $edit): ?>
                                <?php echo form_open('User/EditPersonalDetails') ?>    
                                <br>
                                <input type="hidden" size="80" id="personal_details_id" name="personal_details_id" value="<?= $edit['personal_details_id'] ?>"/>

                                <p><span title="Συμπληρώστε το βαθμό σας">
                                        <input type="text" name="pd_vathmos" id="pd_vathmos" placeholder="Βαθμός" value="<?= $edit['pd_vathmos'] ?>"  />
                                    </span>
                                <p><span title="Συμπληρώστε το όπλο/σώμα που ανήκετε">
                                        <input type="text" name="pd_oplo_soma" id="pd_oplo_soma" placeholder="Όπλο/Σώμα" value="<?= $edit['pd_oplo_soma'] ?>"  />
                                    </span>
                                <p><span title="Συμπληρώστε το ονομά σας">
                                        <input type="text" name="pd_onoma" id="pd_onoma" placeholder="Όνομα" value="<?= $edit['pd_onoma'] ?>"  />
                                    </span>
                                <p><span title="Συμπληρώστε το επώνυμό σας">
                                        <input type="text" name="pd_eponimo" id="pd_eponimo" placeholder="Επώνυμο" value="<?= $edit['pd_eponimo'] ?>"  />
                                    </span>
                                <p><span title="Συμπληρώστε τον Αριθμό Μητρώου">
                                        <input type="text" name="pd_am" id="pd_am" placeholder="ΑΜ" value="<?= $edit['pd_am'] ?>"  />
                                    </span>

                                <p><span title="επιλέξτε το Σχηματισμό/Μονάδα που υπηρετείτε">
                                        <label for="monada_id"></label>
                                        <select name='monada_id' id='monada_id' >
                                            <option value="<?= $edit['monada_id'] ?>"><?= $edit['monada_name'] ?></option>
                                            <option value="-1"> </option>
                                            <option value="-1">Επιλέξτε το/τη Σχηματισμό/Μονάδα που υπηρετείτε</option>
                                            <?php
                                            for ($i = 0; $i < $num_Monada; $i++) {
                                                ?>
                                                <option
                                                    value="<?php echo mysql_result($Monada, $i, 'monada_id'); ?>">
                                                        <?php echo mysql_result($Monada, $i, 'monada_name'); ?>
                                                        <?php
                                                    }
                                                    ?>
                                            </option>

                                        </select>
                                    </span>
                                <p><span title="Επιλέξτε αν είστε απόφοιτος EOD">
                                        <label for="eod"></label>
                                        <select name='eod' id='eod' >
                                            <option value="<?= $edit['eod'] ?>"><?= $edit['eod'] ?></option>
                                            <option value="-1"> </option>
                                            <option value="-1">Επιλέξτε αν είστε απόφοιτος EOD</option>
                                            <option value="ΝΑΙ">ΝΑΙ</option>
                                            <option value="ΟΧΙ">ΟΧΙ</option>

                                        </select>
                                        
                                    </span>    
                                <p><span title="επιλέξτε το ρόλο χρήσης της εφαρμογής">
                                        <label for="roles_id"></label>
                                        <select name='roles_id' id='roles_id' >
                                            <option value="<?= $edit['roles_id'] ?>"><?= $edit['r_name'] ?></option>
                                        </select>
                                    </span>
                                <p><span title="Συμπληρώστε το username που θα χρησιμοποιήσετε στη διαδικασία εισόδου ">
                                        <select name='pd_username' id='pd_username' >
                                            <option value="<?= $edit['pd_username'] ?>"><?php echo $edit['pd_username']; ?></option>
                                        </select> </span>
                                <p><span title="Συμπληρώστε τον κωδικό που θα χρησιμοποιήσετε στη διαδικασία εισόδου">
                                        <input type="password" name="pd_password" id="pd_password" placeholder="Password" value="<?= $edit['pd_password'] ?>"  />
                                    </span>
                                <p><span title="Συμπληρώστε το λεκτικό ανάκτησης κωδικού εισόδου">
                                        <input type="text" name="choosenWord" id="choosenWord" placeholder="Λεκτικό Χρήστη" value="<?= $edit['choosenWord'] ?>"  />
                                    </span>
                                <div class="btn btn-large btn-default" style="float: top; width: 140px;font-size: 30px; margin-left: 550px;">        
                                    <?php echo form_submit('submit', 'ΕΠΕΞΕΡΓΑΣΙΑ!'); ?>
                                </div>
                                <?php echo form_close() ?>
                            <?php endforeach; ?> 
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end divider -->
    </div>
</section>
<?php $this->load->view('Include/include_footer'); ?>
