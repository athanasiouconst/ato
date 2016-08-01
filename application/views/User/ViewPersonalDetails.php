<?php $this->load->view('Include/include_content'); ?>


<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div><br><br><br><br></div>
                    <div class="alert alert-info" style="font-size: 18px;">
                        <i><?= $username ?></i>, <strong>δείτε τα προσωπικά σας στοιχεία,</strong> 
                    </div>
                    <?php echo validation_errors(); ?>
                    <?php if (isset($error)) : ?>
                        <?= $error ?>
                    <?php endif; ?>
                    <?php
                    if (isset($gens)):
                        ?>
                        <?php if (count($gen) > 0) : ?>
                            <?php foreach ($gen as $gen): ?>
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
                                        <a href="<?php echo base_url('User/ViewPersonalDetailsCreationForm'); ?>" class="btn btn-large btn-info">ΠΡΟΣΘΗΚΗ ΝΕΟΥ ΧΡΗΣΤΗ</a>
                                        <br><br>
                                    </div>
                                <?php } ?>
                                <div style="float: right; padding-top: 40px;">
                                    <a href="<?php echo base_url('User/ViewPersonalDetailsEditForm'); ?>" class="btn btn-large btn-info">ΕΠΕΞΕΡΓΑΣΙΑ</a>
                                    <br><br>
                                </div>

                                <table class="table table-hover table-striped">
                                    <th><u><i>ΠΡΟΣΩΠΙΚΕΣ ΠΛΗΡΟΦΟΡΙΕΣ</i></u></th>
                                    <tr><td><br> </td></tr>
                                    <tr>
                                        <td>
                                            <span title="Ο αύξων αριθμός χρήστη στη εφαρμογή">
                                                <p><b>ΑΥΞΩΝ ΑΡΙΘΜΟΣ: </b><?php echo $gen->personal_details_id; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="ο βαθμός σας">
                                                <p><b>ΒΑΘΜΟΣ: </b><?php echo $gen->pd_vathmos; ?> <?php echo $gen->pd_oplo_soma; ?>
                                            </span> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="το ονομά σας">
                                                <p><b>ΟΝΟΜΑ:  </b><?php echo $gen->pd_onoma; ?> <?php echo $gen->pd_eponimo; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="ο αριθμός μητρώου σας">
                                                <p><b>ΑΜ:     </b><?php echo $gen->pd_am; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="ο Σχηματισμός/Μονάδα που υηρετείτε">
                                                <p><b>ΣΧΗΜΑΤΙΜΟΣ/ΜΟΝΑΔΑ ΠΟΥ ΥΠΗΡΕΤΩ:     </b><?php echo $gen->monada_name; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="απόφοιτος σχολείου EOD">
                                                <p><b>ΑΠΟΦΟΙΤΟΣ EOD: </b><?php echo $gen->eod; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="ο ρόλος χρήσης της εφαρμογής">
                                                <p><b>ΡΟΛΟΣ:  </b><?php echo $gen->r_name; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="το username που χρησιμοποιείτε στη διαδικασία εισόδου">
                                                <p><b>USERNAME: </b><?php echo $gen->pd_username; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="το password που χρησιμοποιείτε στη διαδικασία εισόδου">
                                                <p><b>PASSWORD: </b><?php echo sha1($gen->pd_password); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span title="το λεκτικό ανάκτησης κωδικού εισόδου">
                                                <p><b>ΛΕΚΤΙΚΟ ΧΡΗΣΤΗ: </b><?php echo $gen->choosenWord; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr><td><br> </td></tr>

                                <?php endforeach; ?>
                            <?php else : ?>
                                <p><div style="padding-left: 25px;"><i>Δεν υπάρχει καταχωρημένη εγγραφή !!</i></div></p>
                            <?php endif ?>
                        <?php endif; ?>
                    </table>

                </div>       
            </div>
        </div>
    </div>
    <!-- end divider -->
</div>
</section>
<?php $this->load->view('Include/include_footer'); ?>
