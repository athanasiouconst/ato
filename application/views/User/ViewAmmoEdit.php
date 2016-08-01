
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
                    <table class="table table-hover table-striped">

                        <?php if (count($edit) > 0) : ?>
                            <?php foreach ($edit as $edit): ?>

                                <tr class="insertform">
                                    <td>
                                        <?php echo form_open('User/ViewAmmoEditForm') ?>
                                        <p><input type="hidden" size="80" id="eidos_puromaxikou_id" name="eidos_puromaxikou_id" value="<?= $edit['eidos_puromaxikou_id'] ?>"/>    

                                        <p><span title="Συμπληρώστε το είδος του πυρομαχικού">
                                                <input type="text" name="ep_eidos" id="ep_eidos" placeholder="Status" value="<?= $edit['ep_eidos'] ?>"  />
                                            </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>     
                                        <p><span title="Συμπληρώστε τον κωδικό επιλογής">
                                                <input type="text" name="ep_value" id="ep_value" placeholder="Κωδικός Επιλογής" value="<?= $edit['ep_value'] ?>"  />
                                            </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><span title="Συμπληρώστε τη περιγραφή του πυρομαχικού">
                                            <textarea rows="6" name="ep_perigrafi" class="input-block-level" placeholder="* Περιγραφή..." value="<?= $edit['ep_perigrafi'] ?>" ><?= $edit['ep_perigrafi'] ?></textarea>
                                            <!--<input type="textarea" name="r_description" id="r_description" placeholder="Περιγραφή" value="<?php echo set_value('r_description'); ?>"  />--> 
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
                                <p><?php echo form_submit('submit', 'ΕΠΕΞΕΡΓΑΣΙΑ'); ?></p>
                                <?php echo form_close() ?>
                            <?php endforeach; ?>

                        <?php endif ?>

                    </div>      

                </div>
            </div>
        </div>
    </div>

</section>

<?php $this->load->view('Include/include_footer'); ?>