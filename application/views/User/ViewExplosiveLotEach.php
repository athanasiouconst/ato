

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
                            <td colspan="3">
                                <!--  FORM -->
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 20%;  ">
                                        <strong><?= $error ?></strong>
                                        <strong><?php echo validation_errors(); ?></strong>
                                    </div>                    
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php if (count($editE) > 0) : ?>
                            <?php foreach ($editE as $editE): ?>
                                <tr class="insertform">
                                    <td>Α/Α</td>
                                    <td>
                                        <p><span title="αύξων αριθμός εκρηκτικού"><?= $editE['ekriktika_id'] ?>
                                            </span>
                                    </td>
                                    
                                    <td></td>
                                </tr>
                                <tr class="insertform">
                                    <td>Είδος Εκρηκτικού</td>
                                    <td><span title="είδος εκρηκτικού">
                                            <?= $editE['ek_eidos'] ?>
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif ?>
                                
                        <?php if (count($edit) > 0) : ?>
                            <?php foreach ($edit as $edit): ?>
                                <tr class="insertform">
                                    <td >Μερίδα Εκρηκτικού</td>
                                    <td><span title="μερίδα εκρηκτικού">
                                            <?= $edit['lot'] ?><br>
                                        </span>
                                    </td>
                                    <td>
                                            <?php
                                            $ekriktika_lot_id = $edit['ekriktika_lot_id'];
                                            $ek_eidos = $editE['ekriktika_id'];
                                            $edit = '<span title="' . $edit['lot'] . '">Επεξεργασία</span>';
                                            $delete = '<span title="' . $ekriktika_lot_id . '">Διαγραφή</span>';
                                            ?>
                                            <?php
                                            echo anchor("User/ViewExplosiveLotEdit/$ekriktika_lot_id/$ek_eidos", $edit, array('onClick' => "return confirm('Είστε σίγουρος για τις αλλαγές;;')"));
                                            echo "<br>";
                                            ?>
                                            <?php echo anchor("User/ViewExplosiveLotDelete/$ekriktika_lot_id", $delete, array('onClick' => "return confirm('Είστε σίγουρος για τη διαγραφή;;')")); ?>    
                                        </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php endif ?>
                    </table>


                </div>      

            </div>
        </div>
    </div>

</section>

<?php $this->load->view('Include/include_footer'); ?>
