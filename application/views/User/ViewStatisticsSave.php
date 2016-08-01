<?php $this->load->view('Include/include_content'); ?>

<section id="content">
    <div class="container">
        <div class="row">

            <div><br><br><br><br></div>
            <div class="alert alert-info" style="font-size: 18px;">
                <?= $username ?>,<strong> δείτε τα στατιστικά των περιστατικών με κατάσταση "Προσωρινή Αποθήκευση"</strong> 
            </div>

            <section id="content"> 

                <?php
                $queryUserStatis1 = "select count(*), SUM(quantity), personal_details.pd_username "
                        . "       from peristatiko "
                        . "       LEFT join personal_details on peristatiko.personal_details_id=personal_details.personal_details_id "
                        . "       where peristatiko.status_id=2 "
                        . "       GROUP BY peristatiko.personal_details_id "
                        . " ";
                $UserStat1 = mysql_query($queryUserStatis1) or die('Error, query failed' . mysql_error());
                $num_UserStat1 = mysql_num_rows($UserStat1);
                ?>


                <table class="table table-hover table-striped">
            <div style="float: left; padding-top: 40px;">
                <a href="javascript:history.go(-1)" class="btn btn-large btn-info">ΕΠΙΣΤΡΟΦΗ</a>
                <br><br>
            </div>
                    <th>Username</th>
                    <th>Συνολικός Αριθμός Περιστατικών</th>
                    <th> Αριθμός Καταστροφών</th>
                    <?php for ($i = 0; $i < $num_UserStat1; $i++) { ?>
                        <tr>
                            <td>
                                <?php
                                echo mysql_result($UserStat1, $i, 'pd_username');
                                ?>
                            </td>
                            <td>
                                <?php
                                echo mysql_result($UserStat1, $i, 'count(*)');
                                ?>
                            </td>
                            <td>
                                <?php
                                echo mysql_result($UserStat1, $i, 'SUM(quantity)');
                                ?>
                            </td>
                        </tr>

                        <?php
                    }
                    ?>

                </table>        
            </section> 
        </div>
    </div>
</section>    


<?php $this->load->view('Include/include_footer'); ?>