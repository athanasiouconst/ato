
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

                        <tr class="insertform">
                            <td>
                                <?php echo form_open('User/CreateRoles') ?>    
                                <p><span title="Συμπληρώστε την ονομασία του ρόλου">
                                        <input type="text" name="r_name" id="r_name" placeholder="Ονομασία" value="<?php echo set_value('r_name'); ?>"  />
                                    </span>
                            </td>
                        </tr>
                        <tr class="insertform">
                            <td><span title="Συμπληρώστε τη περιγραφή του ρόλου">
                                    <textarea rows="6" name="r_description" class="input-block-level" placeholder="* Περιγραφή..." value="<?php echo set_value('r_description'); ?>" ></textarea>
                                    <!--<input type="text" name="r_description" id="r_description" placeholder="Περιγραφή" value="<?php echo set_value('r_description'); ?>"  />-->
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
