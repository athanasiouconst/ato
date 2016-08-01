
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

                    <table class="table table-hover table-striped" style="font-size: 19px;font:  bold; ">

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
                                    <td colspan="2">
                                        <span title="Στοιχεία Πυροτεχνουργού">
                                            <p>Στοιχεία Πυροτεχνουργού :<?= $edit['pd_vathmos'] ?>  <?= $edit['pd_oplo_soma'] ?> <?= $edit['pd_onoma'] ?>  <?= $edit['pd_eponimo'] ?> 
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td colspan="2">
                                        <span title="Στοιχεία Πυροτεχνουργού">
                                            <p>Αριθμός Μητρώου:  <?= $edit['pd_am'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td colspan="2">
                                        <span title="Στοιχεία Πυροτεχνουργού">
                                            <p>Username:  <?= $edit['pd_username'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td colspan="0">
                                        <span title="Σχηματισμός/Μονάδα Υπηρέτησης">
                                            <p><?= $edit['monada_name'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td colspan="0">
                                        <span title="Απόφοιτος EOD">
                                            <p>Απόφοιτος EOD : <?= $edit['eod'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php $queryQuantitya = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=1  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantitya = mysql_query($queryQuantitya) or die('Error, query failed' . mysql_error());
                                $num_Quantitya = mysql_num_rows($Quantitya);
                                ?>

                                <?php $queryQuantityb = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=2  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantityb = mysql_query($queryQuantitya) or die('Error, query failed' . mysql_error());
                                $num_Quantityb = mysql_num_rows($Quantityb);
                                ?>


                                <?php $queryQuantityc = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=3 and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantityc = mysql_query($queryQuantityc) or die('Error, query failed' . mysql_error());
                                $num_Quantityc = mysql_num_rows($Quantityc);
                                ?>


                                <?php $queryQuantityd = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=4 and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantityd = mysql_query($queryQuantityd) or die('Error, query failed' . mysql_error());
                                $num_Quantityd = mysql_num_rows($Quantityd);
                                ?>


                                <?php $queryQuantity5 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=5 and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity5 = mysql_query($queryQuantity5) or die('Error, query failed' . mysql_error());
                                $num_Quantity5 = mysql_num_rows($Quantity5);
                                ?>


                                <?php $queryQuantity6 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=6 and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity6 = mysql_query($queryQuantitya) or die('Error, query failed' . mysql_error());
                                $num_Quantity6 = mysql_num_rows($Quantity6);
                                ?>


                                <?php $queryQuantity7 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=7  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity7 = mysql_query($queryQuantity7) or die('Error, query failed' . mysql_error());
                                $num_Quantity7 = mysql_num_rows($Quantity7);
                                ?>


                                <?php $queryQuantity8 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=8  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity8 = mysql_query($queryQuantity8) or die('Error, query failed' . mysql_error());
                                $num_Quantity8 = mysql_num_rows($Quantity8);
                                ?>


                                <?php $queryQuantity9 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=9  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity9 = mysql_query($queryQuantity9) or die('Error, query failed' . mysql_error());
                                $num_Quantity9 = mysql_num_rows($Quantity9);
                                ?>


                                <?php $queryQuantity10 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=10  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity10 = mysql_query($queryQuantity10) or die('Error, query failed' . mysql_error());
                                $num_Quantity10 = mysql_num_rows($Quantity10);
                                ?>


                                <?php $queryQuantity11 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=11  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity11 = mysql_query($queryQuantity11) or die('Error, query failed' . mysql_error());
                                $num_Quantity11 = mysql_num_rows($Quantity11);
                                ?>


                                <?php $queryQuantity12 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=12  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $Quantity12 = mysql_query($queryQuantity12) or die('Error, query failed' . mysql_error());
                                $num_Quantity12 = mysql_num_rows($Quantity12);
                                ?>

                                <?php $queryQuantity13 = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4 and eidos_sumvantos_id=13  "; ?>   
                                <?php
                                $Quantity13 = mysql_query($queryQuantity13) or die('Error, query failed' . mysql_error());
                                $num_Quantity13 = mysql_num_rows($Quantity13);
                                ?>
                                <?php $queryQuantityTotal = "SELECT SUM(quantity) FROM peristatiko LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id where status_id = 4  and personal_details.personal_details_id = '" . $edit['personal_details_id'] . "'"; ?>   
                                <?php
                                $QuantityTotal = mysql_query($queryQuantityTotal) or die('Error, query failed' . mysql_error());
                                $num_QuantityTotal = mysql_num_rows($QuantityTotal);
                                ?> 
                                <tr class="insertform">
                                    <td><p>Κατηγορία Α:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                         
                                            <span title="Αριθμός Καταστροφών">
                                                <?php
                                                if ($num_Quantitya > 0) {
                                                    for ($i = 0; $i < $num_Quantitya; $i++) {
                                                        echo $Quana = mysql_result($Quantitya, $i, 'SUM(quantity)');
                                                    }
                                                    ?> 
                                                    <?php
                                                } else
                                                    echo 0;
                                                ?>
                                            </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>
                                        <p>Κατηγορία Β:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantityb > 0) {
                                                for ($i = 0; $i < $num_Quantityb; $i++) {
                                                    echo $Quanb = mysql_result($Quantityb, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>
                                        <p>Κατηγορία Γ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantityc > 0) {
                                                for ($i = 0; $i < $num_Quantityc; $i++) {
                                                    echo $Quanc = mysql_result($Quantityc, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>
                                        <p>Κατηγορία Δ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantityd > 0) {
                                                for ($i = 0; $i < $num_Quantityd; $i++) {
                                                    echo $Quand = mysql_result($Quantityd, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Ε:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                  
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantity5 > 0) {
                                                for ($i = 0; $i < $num_Quantity5; $i++) {
                                                    echo $Quan5 = mysql_result($Quantity5, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Ζ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                         
                                        <span title="Αριθμός Καταστροφών">
                                            <?php
                                            if ($num_Quantity6 > 0) {
                                                for ($i = 0; $i < $num_Quantity6; $i++) {
                                                    echo $Quan6 = mysql_result($Quantity6, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Η:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      
                                        <span title="Αριθμός Καταστροφών">
                                                <?php
                                                if ($num_Quantity7 > 0) {
                                                    for ($i = 0; $i < $num_Quantity7; $i++) {
                                                        echo $Quan7 = mysql_result($Quantity7, $i, 'SUM(quantity)');
                                                    }
                                                    ?> 
                                                    <?php
                                                } else
                                                    echo 0;
                                                ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Θ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                        
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantity8 > 0) {
                                                for ($i = 0; $i < $num_Quantity8; $i++) {
                                                    echo $Quan8 = mysql_result($Quantity8, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Ι:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                         
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantity9 > 0) {
                                                for ($i = 0; $i < $num_Quantity9; $i++) {
                                                    echo $Quan9 = mysql_result($Quantity9, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Κ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                        
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantity10 > 0) {
                                                for ($i = 0; $i < $num_Quantity10; $i++) {
                                                    echo $Quan10 = mysql_result($Quantity10, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Λ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                       
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantity11 > 0) {
                                                for ($i = 0; $i < $num_Quantity11; $i++) {
                                                    echo $Quan11 = mysql_result($Quantity11, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Μ:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                     
                                        <span title="Αριθμός Καταστροφών">

                                            <?php
                                            if ($num_Quantity12 > 0) {
                                                for ($i = 0; $i < $num_Quantity12; $i++) {
                                                    echo $Quan12 = mysql_result($Quantity12, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td><p>Κατηγορία Ν:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        if ($num_Quantity13 > 0) {
                                            for ($i = 0; $i < $num_Quantity13; $i++) {
                                                echo $Quan13 = mysql_result($Quantity13, $i, 'SUM(quantity)');
                                            }
                                            ?> 
                                            <?php
                                        } else
                                            echo 0;
                                        ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td colspan="0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br></td>
                                </tr>
                                <tr>
                                    <td><p>Συνολικά:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span title="Αριθμός Καταστροφών">
                                            <?php
                                            if ($num_QuantityTotal > 0) {
                                                for ($i = 0; $i < $num_QuantityTotal; $i++) {
                                                    echo $QuanTotal = mysql_result($QuantityTotal, $i, 'SUM(quantity)');
                                                }
                                                ?> 
                                                <?php
                                            } else
                                                echo 0;
                                            ?>
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