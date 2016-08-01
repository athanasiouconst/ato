
<?php $this->load->view('Include/include_content'); ?>
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div><br><br><br><br></div>
                    <div class="alert alert-info" style="font-size: 18px;">
                        <i><?= $username ?></i>, <strong>δείτε τα περιστατικά στα οποία έχετε συμμετάσχει,</strong> 
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
                    <?php if ($role == 3) { ?>
                        <div style="float: right; padding-top: 40px;">
                            <a href="<?php echo base_url('User/ViewInstanceCreationForm'); ?>" class="btn btn-large btn-info">ΠΡΟΣΘΗΚΗ ΝΕΟΥ ΠΕΡΙΣΤΑΙΚΟΥ</a>
                            <br><br>
                        </div>
                    <?php } ?>

                    <?php
                    if (isset($gens)):
                        ?>
                        <?php if (count($gen) > 0) : ?>
                            <table  class="table table-hover table-striped">
                                <tr>
                                    <?php foreach ($fields as $field_name => $field_display): ?>
                                        <td <?php if ($sort_by == $field_name) echo "class=\"sort_$sort_order\"" ?>>
                                            <?php
                                            echo anchor("User/ViewInstanceSubmitStatus/$field_name/" .
                                                    ( ($sort_order == 'asc' && $sort_by == $field_name ) ? 'desc' : 'asc' ), $field_display);
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <?php foreach ($fieldsStatus as $field_nameStatus => $field_display): ?>    
                                        <td <?php if ($sort_by == $field_nameStatus) echo "class=\"sort_$sort_order\"" ?>>
                                            <?php
                                            echo anchor("User/ViewInstanceSubmitStatus/$field_nameStatus/" .
                                                    ( ($sort_order == 'asc' && $sort_by == $field_nameStatus ) ? 'desc' : 'asc' ), $field_display);
                                            ?>
                                        </td>
                                    <?php endforeach; ?>

                                    <td colspan="2">Επεξεργασία</td>
                                </tr>
                                <?php foreach ($gen as $gen): ?>
                                    <tr>
                                        <?php $nameStatus = $gen->status_id; ?>
                                        <?php foreach ($fields as $field_name => $field_display): ?>
                                            <td>
                                                <?php
                                                echo $gen->$field_name;
                                                ?>
                                            <?php endforeach; ?> 
                                            <?php foreach ($fieldsStatus as $field_nameStatus => $field_display): ?>
                                                <?php if ($nameStatus == 4) { ?>
                                                <td>
                                                    <div style="color: background;"><b><?php echo $gen->$field_nameStatus; ?></b></div>
                                                </td>

                                                <td>
                                                    <?php
                                                    $peristatiko_id = $gen->peristatiko_id;
                                                    $edit = '<span title="' . $peristatiko_id . '">Επεξεργασία</span>';
                                                    $delete = '<span title="' . $peristatiko_id . '">Διαγραφή</span>';
                                                    $vieweach = '<span title="' . $peristatiko_id . '">Προβολή</span>';
                                                    $creareReport = '<span title="' . $peristatiko_id . '">Έκθεση Καταστροφής</span>';
                                                    $creareStatisticReport = '<span title="' . $peristatiko_id . '">Στατιστική Φόρμα Παρακολούθησης</span>';

                                                    echo anchor("User/CreateStatisticReport/$peristatiko_id", $creareStatisticReport, array('target' => '_blank','onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    echo anchor("User/CreateExplosiveReport/$peristatiko_id", $creareReport, array('target' => '_blank','onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    echo anchor("User/ViewInstanceOne/$peristatiko_id", $vieweach, array('onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    ?>

                                                    <?php
                                                    
                                                    ?> 
                                                </td>
                                                <?php
                                            } else if ($nameStatus == 3) {
                                                ?><td>
                                                    <div style="color: #4cae4c;"><b><?php echo $gen->$field_nameStatus; ?></b></div>                                                    
                                                </td>
                                                <td>
                                                    <?php
                                                    $peristatiko_id = $gen->peristatiko_id;
                                                    $edit = '<span title="' . $peristatiko_id . '">Επεξεργασία</span>';
                                                    $delete = '<span title="' . $peristatiko_id . '">Διαγραφή</span>';
                                                    $vieweach = '<span title="' . $peristatiko_id . '">Προβολή</span>';
                                                    $creareReport = '<span title="' . $peristatiko_id . '">Έκθεση Καταστροφής</span>';
                                                    $creareStatisticReport = '<span title="' . $peristatiko_id . '">Στατιστική Φόρμα Παρακολούθησης</span>';

                                                    echo anchor("User/CreateStatisticReport/$peristatiko_id", $creareStatisticReport, array('target' => '_blank','onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    echo anchor("User/CreateExplosiveReport/$peristatiko_id", $creareReport, array('target' => '_blank','onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    echo anchor("User/ViewInstanceOne/$peristatiko_id", $vieweach, array('onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    ?>
                                                </td>
                                            <?php } else if ($nameStatus == 2) {
                                                ?> 
                                                <td>
                                                    <div style="color: tomato;"><b><?php echo $gen->$field_nameStatus; ?></b></div>                                                    
                                                </td>
                                                <td>
                                                    <?php
                                                    $peristatiko_id = $gen->peristatiko_id;
                                                    $edit = '<span title="' . $peristatiko_id . '">Επεξεργασία</span>';
                                                    $delete = '<span title="' . $peristatiko_id . '">Διαγραφή</span>';
                                                    $vieweach = '<span title="' . $peristatiko_id . '">Προβολή</span>';

                                                    echo anchor("User/ViewInstanceOne/$peristatiko_id", $vieweach, array('onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    ?>
                                                    <?php
                                                    echo anchor("User/ViewInstanceEdit/$peristatiko_id", $edit, array('onClick' => "return confirm('Είστε σίγουρος για τις αλλαγές;;')"));
                                                    echo "<br>";
                                                    ?>
                                                </td>
                                            <?php } else if ($nameStatus == 1) {
                                                ?> 
                                                <td>
                                                    <div style="color: tomato;"><b><?php echo $gen->$field_nameStatus; ?></b></div>                                                    
                                                </td>
                                                <td>
                                                    <?php
                                                    $peristatiko_id = $gen->peristatiko_id;
                                                    $creareReport = '<span title="' . $peristatiko_id . '">Έκθεση Καταστροφής</span>';
                                                    $creareStatisticReport = '<span title="' . $peristatiko_id . '">Στατιστική Φόρμα Παρακολούθησης</span>';
                                                    
                                                    $edit = '<span title="' . $peristatiko_id . '">Επεξεργασία</span>';
                                                    $delete = '<span title="' . $peristatiko_id . '">Διαγραφή</span>';
                                                    $vieweach = '<span title="' . $peristatiko_id . '">Προβολή</span>';
                                                    
                                                    echo anchor("User/CreateStatisticReport/$peristatiko_id", $creareStatisticReport, array('target' => '_blank','onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    echo anchor("User/CreateExplosiveReport/$peristatiko_id", $creareReport, array('target' => '_blank','onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    echo anchor("User/ViewInstanceOne/$peristatiko_id", $vieweach, array('onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                                    echo "<br>";
                                                    ?>
                                                    <?php
                                                    echo anchor("User/ViewInstanceEdit/$peristatiko_id", $edit, array('onClick' => "return confirm('Είστε σίγουρος για τις αλλαγές;;')"));
                                                    echo "<br>";
                                                    ?>
                                                    <?php echo anchor("User/ViewInstanceOneDelete/$peristatiko_id", $delete, array('onClick' => "return confirm('Είστε σίγουρος για τη διαγραφή;;')")); ?>    
                                                    
                                                </td>
                                                <?php
                                            } else if ($nameStatus != 4 || $nameStatus != 3 || $nameStatus != 2 || $nameStatus != 1) {
                                                ?>
                                            <div style="color: black;"><b><?php echo $gen->$field_nameStatus; ?></b></div>
                                        <?php } ?> 
                                        </td>

                                    <?php endforeach; ?>

                                <?php endforeach; ?>
                                </tr>
                                <tr><td colspan="10" ></td></tr>
                                <tr>

                                    <td colspan="10" class="pagi">
                                        <?php if (strlen($pagination)): ?>
                                            <?php echo $pagination; ?>
                                        <?php endif; ?>
                                    </td>    
                                </tr>

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