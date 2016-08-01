
<?php $this->load->view('Include/include_content'); ?>
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div><br><br><br><br></div>
                    <div class="alert alert-info" style="font-size: 18px;">
                        <i><?= $username ?></i>, <strong>δείτε τις θέσεις συμβάντων της εφαρμογής,</strong> 
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

                    <?php if ($role == 1) { ?>
                        <div style="float: right; padding-top: 40px;">
                            <a href="<?php echo base_url('User/ViewIncidentPositionCreationForm'); ?>" class="btn btn-large btn-info">ΠΡΟΣΘΗΚΗ ΝΕΑΣ ΘΕΣΗΣ ΣΥΜΒΑΝΤΟΣ</a>
                            <br><br>
                        </div>
                    <?php } ?>


                    <?php
                    if (isset($gens)):
                        ?>
                        <?php if (count($gen) > 0) : ?>
                            <table class="table table-hover table-striped">
                                <tr>
                                    <?php foreach ($fields as $field_name => $field_display): ?>
                                        <td <?php if ($sort_by == $field_name) echo "class=\"sort_$sort_order\"" ?>>
                                            <?php
                                            echo anchor("User/ViewIncidentPosition/$field_name/" .
                                                    ( ($sort_order == 'asc' && $sort_by == $field_name ) ? 'desc' : 'asc' ), $field_display);
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td>Επεξεργασία</td>
                                </tr>
                                <?php foreach ($gen as $gen): ?>
                                    <tr>
                                        <?php foreach ($fields as $field_name => $field_display): ?>
                                            <td>
                                                <?php
                                                echo $gen->$field_name;
                                                ?>
                                            <?php endforeach; ?> 
                                        </td>
                                        <td>
                                            <?php
                                            $thesi_simvantos_id = $gen->thesi_simvantos_id;
                                            $edit = '<span title="' . $thesi_simvantos_id . '">Επεξεργασία</span>';
                                            $delete = '<span title="' . $thesi_simvantos_id . '">Διαγραφή</span>';
                                            $vieweach = '<span title="' . $thesi_simvantos_id . '">Προβολή</span>';
                                            
                                            echo anchor("User/ViewIncidentPositionEach/$thesi_simvantos_id", $vieweach, array('onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                            echo "<br>";
                                            ?>
                                            <?php
                                            echo anchor("User/ViewIncidentPositionEdit/$thesi_simvantos_id", $edit, array('onClick' => "return confirm('Είστε σίγουρος για τις αλλαγές;;')"));
                                            echo "<br>";
                                            ?>
                                            <?php echo anchor("User/ViewIncidentPositionDelete/$thesi_simvantos_id", $delete, array('onClick' => "return confirm('Είστε σίγουρος για τη διαγραφή;;')")); ?>    
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr><td colspan="5" ></td></tr>
                                <tr>

                                    <td colspan="5" class="pagi">
                                        <?php if (strlen($pagination)): ?>
                                            <?php echo $pagination; ?>
                                        <?php endif; ?>
                                    </td>    
                                </tr>
                            </table>
                        <?php else : ?>
                            <p><div style="padding-left: 25px;"><i>Δεν υπάρχει καταχωρημένη εγγραφή !!</i></div></p>
                        <?php endif ?>
                    <?php endif; ?> 
                    </table>
                </div>
            </div>
            <!-- end divider -->
        </div>
</section>
<?php $this->load->view('Include/include_footer'); ?>