

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
                                        <p><?= $edit['sximatismos_id'] ?>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>Ονομασία Σχηματισμού</td>
                                    <td><span title="Ονομασία Σχηματισμού">
                                            <?= $edit['sximatismos_name'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>Περιοχή Σχηματισμού</td>
                                    <td><span title="Περιοχή Σχηματισμού">
                                            <?= $edit['sximatismos_area'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                $queryMonada = "SELECT
                                    *
                                    FROM sximatismos,monada 
                                    where sximatismos.monada_id=monada.monada_id
                                    and sximatismos.monada_id='" . $edit['monada_id'] . "'
                                   order by sximatismos.monada_id asc
                                   ";
                                $Monada = mysql_query($queryMonada) or die('Error, query failed' . mysql_error());
                                $num_Monada = mysql_num_rows($Monada);
                                ?>
                                <tr class="insertform">
                                    <td>Μονάδες Υπαγωγής</td>
                                    <td><span title="Μονάδες Υπαγωγής">
                                            <?php for ($i = 0; $i < $num_Monada; $i++) { ?>
                                            <p><?php echo mysql_result($Monada, $i, 'monada_name');?></p>
                                            <p><?php echo mysql_result($Monada, $i, 'monada_area');?></p>
                                            <?php } ?>
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
