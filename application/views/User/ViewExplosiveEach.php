

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

                        <tr class="insertform">
                            <td colspan="2">
                                <!--  FORM -->
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                                        <strong><?= $error ?></strong>
                                        <strong><?php echo validation_errors(); ?></strong>
                                    </div>                    
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php if (count($edit) > 0) : ?>
                            <?php foreach ($edit as $edit): ?>

                                <tr class="insertform">
                                    <td>Α/Α</td>
                                    <td>
                                        <p><span title="αύξων αριθμός εκρηκτικού"><?= $edit['ekriktika_id'] ?>
                                            </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>Είδος Εκρηκτικού</td>
                                    <td><span title="είδος εκρηκτικού">
                                            <?= $edit['ek_eidos'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>Περιγραφή</td>
                                    <td><span title="παρατηρήσεις εκρηκτικού">
                                            <?= $edit['ek_paratiriseis'] ?>
                                        </span>
                                    </td>
                                </tr>


                            </table>
                        <?php endforeach; ?>

                    <?php endif ?>

                </div>      

            </div>
        </div>
    </div>

</section>

<?php $this->load->view('Include/include_footer'); ?>