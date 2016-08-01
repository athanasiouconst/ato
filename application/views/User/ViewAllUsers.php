<?php $this->load->view('Include/include_content'); ?>
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div><br><br><br><br></div>
                    <div class="alert alert-info" style="font-size: 18px;">
                        <i><?= $username ?></i>, <strong>δείτε τους διαθέσιμους χρήστες της εφαρμογής,</strong> 
                    </div>

                    <?php echo validation_errors(); ?>
                    <?php if (isset($error)) : ?>
                        <?= $error ?>
                    <?php endif; ?>
                    <div style="float: left; padding-top: 40px;">
                        <a href="javascript:history.go(-1)" class="btn btn-large btn-info">ΕΠΙΣΤΡΟΦΗ</a>
                        <br><br>
                    </div>
                    <div style="float: right; padding-top: 40px;">
                        <?php
                        $vieweach = '<span title="Πίνακας Στατιστικών Στοιχείων">ΠΙΝΑΚΑΣ ΣΤΑΤΙΣΤΙΚΩΝ ΣΤΟΙΧΕΙΩΝ</span>';
                        echo anchor("User/TotalStatistics", $vieweach, array('class'=>'btn btn-large btn-info','target' => '_blank', 'onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                        ?>

                        <br><br>
                    </div>
                    <?php
                    if (isset($gens)):
                        ?>
                        <?php if (count($gen) > 0) : ?>

                            <table class="table table-hover table-striped">
                                <tr>
                                    <?php foreach ($fields as $field_name => $field_display): ?>
                                        <td <?php if ($sort_by == $field_name) echo "class=\"sort_$sort_order\"" ?>>
                                            <?php
                                            echo anchor("User/ViewAllUsers/$field_name/" .
                                                    ( ($sort_order == 'asc' && $sort_by == $field_name ) ? 'desc' : 'asc' ), $field_display);
                                            ?>
                                        </td>

                                    <?php endforeach; ?>
                                    <td>Περισσότερα Στοιχεία</td>
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
                                            $personal_details_id = $gen->personal_details_id;
                                            $pd_onoma = $gen->pd_onoma;
                                            $pd_eponimo = $gen->pd_eponimo;
                                            $pd_am = $gen->pd_am;
                                            $monada_name = $gen->monada_name;
                                            $vieweach = '<span title="' . $pd_eponimo . ' ' . $pd_onoma . ' ,' . $pd_am . ', ' . $monada_name . '">Προβολή</span>';
                                            echo anchor("User/ViewPersonalDetailsTotal/$personal_details_id", $vieweach, array('onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                            echo "<br>";
                                            $vieweach = '<span title="' . $pd_eponimo . ' ' . $pd_onoma . ' ,' . $pd_am . ', ' . $monada_name . '">Ατομική Καρτέλα(pdf)</span>';
                                            echo anchor("User/PersonalStatistics/$personal_details_id", $vieweach, array('target' => '_blank', 'onClick' => "return confirm('Είστε σίγουρος για την επιλογή σας;;')"));
                                            ?>
                                        </td>
                                        <?php endforeach; ?>
                                </tr>
                                <tr><td colspan="9" > </td></tr>
                                <tr>

                                    <td colspan="9" class="pagi">
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
