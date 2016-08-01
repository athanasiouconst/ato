
<?php $this->load->view('Include/include_content'); ?>
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div><br><br><br><br></div>
                    <div class="alert alert-info" style="font-size: 18px;">
                        <i><?= $username ?></i>, <strong>δείτε ολοκληρωμένο το περιστατικό,</strong> 
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
                    <div style="float: left; padding-top: 40px;">
                        <a href="javascript:history.go(-1)" class="btn btn-large btn-info">ΕΠΙΣΤΡΟΦΗ</a>
                        <br><br>
                    </div>
                    <div style="float: right; padding-top: 40px;">
                        <a href="<?php echo base_url('User/ViewInstanceExplosiveCreationForm'); ?>" class="btn btn-large btn-info">ΠΡΟΣΘΗΚΗ ΕΚΡΗΚΤΙΚΩΝ</a>
                        <br><br>
                    </div>
                    <?php
                    if (isset($gens)):
                        ?>
                        <?php if (count($gen) > 0) : ?>
                            <?php foreach ($gen as $gen): ?>
                                <table class="table table-hover table-striped">
                                    <tr><td >ΑΥΞΩΝ ΑΡΙΘΜΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td>
                                        <td colspan="4"><span title="Ο κωδικός του Περιστατικού">
                                                <?php echo $peristatiko; ?></span>
                                        </td>
                                    <?php endforeach; ?>
                                <?php endif ?>
                                <td colspan="2">
                                    Επεξεργασία των Εκρηκτικών από το Περιστατικό
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
                                                <?php echo $genEkriktika->ek_eidos; ?>&nbsp;&nbsp;
                                                <?php echo $genEkriktika->lot; ?>&nbsp;&nbsp </span>
                                        </td>
                                        <td colspan="2">       ΠΟΣΟΤΗΤΑ : <?php echo $genEkriktika->ekr_posotika; ?></td>
                                        <td>
                                            <?php
                                            $peristatikoExplosive=$genEkriktika->peristatiko_ekriktika_id;
                                            $delete = '<span title="' . $genEkriktika->ek_eidos . '">Διαγραφή</span>';
                                            ?>
                                            <?php echo anchor("User/ViewInstanceOneExplosiveDelete/$peristatikoExplosive", $delete, array('onClick' => "return confirm('Είστε σίγουρος για τη διαγραφή;;')")); ?>    
                                        </td>
                                    <?php endforeach; ?>
                                <?php endif; ?> 
                            <?php endif; ?> 
                        </tr>

                    </table>

                </div>
            </div>
            <!-- end divider -->
        </div>
</section>
<?php $this->load->view('Include/include_footer'); ?>  