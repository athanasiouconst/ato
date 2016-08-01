
<?php $this->load->view('Include/include_content'); ?>
<section id="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div><br><br><br><br></div>
                    <div class="alert alert-info" style="font-size: 18px;">
                        <i><?= $username ?></i>, <strong>επεξεργαστείτε το περιστατικό,</strong> 
                    </div>



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
                    <table class="table table-hover table-striped">

                        <tr>
                            <td>
                                <h2>Επεξεργαστείτε τα παρακάτω στοιχεία :</h2>
                            </td>
                        </tr>

                        <tr class="insertform">
                            <td>
                                <!--  FORM -->
                                <?php if (isset($error)) : ?>
                                    <div class="alert alert-danger" style="width: 100%; font-size: 18px; padding-left: 0%;  ">
                                        <strong>                                               
                                            <?php echo $this->session->flashdata('edit_msg'); ?>
                                        </strong>
                                        <strong><?php echo validation_errors(); ?></strong>
                                    </div>                    
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <?php if (count($edit) > 0) : ?>
                        <?php foreach ($edit as $edit): ?>


                            <table class="table table-hover table-striped">

                                <tr class="insertform">
                                    <td>ΑΥΞΩΝ ΑΡΙΘΜΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td>
                                    <td><span title="Ο κωδικός του Περιστατικού"><?= $edit['peristatiko_id'] ?></span></td>
                                </tr>

                                <tr class="insertform">

                                    <td>ΠΥΡΟΤΕΧΝΟΥΡΓΟΣ :</td>
                                    <td><span title="το όνομά σας"><?= $edit['pd_username'] ?> </span></td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΚΑΤΑΝΟΜΗ ΑΡΜΟΔΙΟΤΗΤΩΝ :</td>
                                    <td><span title="η αρμοδιότητα του περιστατικού"><?= $edit['ka_armodiotites'] ?> </span></td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΚΑΤΗΓΟΡΙΑ ΣΥΜΒΑΝΤΟΣ :</td>
                                    <td> <span title="η κατηγορία συμβάντος">         <?= $edit['ks_epipedo'] ?> </span></td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΙΔΟΣ ΣΥΜΒΑΝΤΟΣ :</td>
                                    <td><span title="το είδος του συμβάντος"><?= $edit['es_code'] ?> </span></td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΙΔΟΣ ΠΥΡΟΜΑΧΙΚΟΥ :</td>
                                    <td><span title="το είδος του πυρομαχικού"><?= $edit['ep_eidos'] ?></span></td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΚΑΤΗΓΟΡΙΑ ΠΡΟΤΕΡΑΙΟΤΗΤΑΣ :</td>
                                    <td><span title="η προτεραιότητα του περιστατικού"><?= $edit['kp_code'] ?> </span></td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΘΕΣΗ ΣΥΜΒΑΝΤΟΣ :</td>
                                    <td><span title="η θέση του συμβάντος"><?= $edit['ts_thesi'] ?> </span></td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΣΗΜΑ ΔΙΑΘΕΣΗΣ ΠΥΡΟΤΕΧΝΟΥΡΓΟΥ :</td>
                                    <td><span title="το σήμα διάθεσης πυροτεχνουργού"><?= $edit['document'] ?></span></td>
                                </tr>

                                <?php echo form_open('User/UpdateInstanceFinish') ?>    

                                <tr class="insertform">
                                    <td>ΗΜΕΡΟΜΗΝΙΑ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td>
                                    <td>  <span title="Συμπληρώστε την ημερομηνία του περιστατικού">                                          
                                            <p>
                                                <input type="hidden" name="peristatiko_id" id="peristatiko_id" placeholder="" value="<?= $edit['peristatiko_id'] ?>"  />                          
                                                <input type="text" name="ps_date" id="ps_date" placeholder="Ημερομηνία" value="<?= $edit['ps_date'] ?>"  />                          
                                        </span>
                                    </td>
                                </tr>



                                <tr class="insertform">
                                    <td>ΤΟΠΟΣ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td>
                                    <td> <span title="Συπληρώστε τη περιοχή του περιστατικού"> <p>
                                                <input type="text" name="ps_topos" id="ps_topos" placeholder="Περιοχή Δράσης" value="<?= $edit['ps_topos'] ?>"  />
                                        </span> 
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΩΡΑ ΕΝΑΡΞΗΣ :</td>
                                    <td><span title="Συμπληρώστε την ώρα έναρξης των εργασιών">
                                            <p>
                                                <input type="text" name="ps_ora_enarxis" id="ps_ora_enarxis" placeholder="Ώρα Έναρξης" value="<?= $edit['ps_ora_enarxis'] ?>"  />
                                        </span> 
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΩΡΑ ΛΗΞΗΣ :</td>
                                    <td>                                            
                                        <span title="Συπληρώστε την ώρα λήξης των εργασιών"><p>

                                                <input type="text" name="ps_ora_lixis" id="ps_ora_lixis" placeholder="Ώρα Λήξης" value="<?= $edit['ps_ora_lixis'] ?>"  />
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΑΡΙΘΜΟΣ ΟΝΟΜΑΣΤΙΚΟΥ :</td>
                                    <td>
                                        <span title="Συπληρώστε τον Αριθμό Ονομαστικού, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                <input type="text" name="ao_nsn" id="ao_nsn" placeholder="Αριθμός Ονομαστικού" value="<?= $edit['ao_nsn'] ?>"  />
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΜΕΡΙΔΑ :</td>
                                    <td>
                                        <span title="Συπληρώστε τη Μερίδα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                <input type="text" name="merida" id="merida" placeholder="Μερίδα Πυρομαχικού" value="<?= $edit['merida'] ?>"  />
                                        </span>
                                    </td>
                                </tr>
                                    <tr class="insertform">
                                        <td>ΠΟΣΟΤΗΤΑ ΑΝΕΥΡΕΥΘΕΝΤΩΝ ΠΥΡΟΜΑΧΙΚΩΝ :</td>
                                        <td><span title="Συπληρώστε τη Ποσότητα των ανευρεθέντων πυρομαχικών"><p>
                                                    <input type="text" name="quantity" id="quantity" placeholder="Ποσότητα Ανευρεθέντων Πυρομαχικών" value="<?= $edit['quantity'] ?>"  />
                                            </span>
                                        </td>
                                    </tr>
                                <tr class="insertform">
                                    <td>ΠΕΡΙΓΡΑΦΗ ΠΥΡΟΜΑΧΙΚΟΥ :</td>
                                    <td>
                                        <span title="Συμπληρώστε τη περιγραφή του αντικειμένου"><p>
                                                <textarea rows="4" name="perigrafi" class="input-block-level"  id="perigrafi" placeholder="* Περιγραφή..." value="<?= $edit['perigrafi'] ?>" ><?= $edit['perigrafi'] ?></textarea>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΣΕΙΡΙΑΚΟΣ ΑΡΙΘΜΟΣ :</td>
                                    <td>
                                        <span title="Συπληρώστε τον Σειριακό Αριθμό, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                <input type="text" name="sn" id="sn" placeholder="Σειριακός Αριθμός" value="<?= $edit['sn'] ?>"  />
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΑΡΙΘΜΟΣ ΟΝΟΜΑΣΤΙΚΟΥ ΠΥΡΟΣΩΛΗΝΑ :</td>
                                    <td>
                                        <span title="Συπληρώστε τον Αριθμό Ονομαστικού του Πυροσωλήνα, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                <input type="text" name="ao_nsn_prl" id="ao_nsn_prl" placeholder="Αριθμός Ονομαστικού Πυροσωλήνα" value="<?= $edit['ao_nsn_prl'] ?>"  />
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΜΕΡΙΔΑ ΠΥΡΟΣΩΛΗΝΑ :</td>
                                    <td>
                                        <span title="Συπληρώστε τη Μερίδα του Πυροσωλήνα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                <input type="text" name="merida_prl" id="merida_prl" placeholder="Μερίδα Πυροσωλήνα" value="<?= $edit['merida_prl'] ?>"  />
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΠΕΡΙΓΡΑΦΗ ΠΥΡΟΣΩΛΗΝΑ :</td>
                                    <td><span title="Συπληρώστε τη περιγραγή του πυροσωλήνα"><p><p>
                                                <textarea rows="4" name="perigrafi_prl" class="input-block-level" id="perigrafi_prl" placeholder="* Περιγραφή Πυροσωλήνα ..." value="<?= $edit['perigrafi_prl'] ?>" ><?= $edit['perigrafi_prl'] ?></textarea>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΑΡΙΘΜΟΣ ΟΝΟΜΑΣΤΙΚΟΥ ΚΙΝΗΤΗΡΑ :</td>
                                    <td>
                                        <span title="Συπληρώστε τον Αριθμό Ονομαστικού του κινητήρα, αν δε είναι γνωστός, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                <input type="text" name="ao_nsn_rock_mis_assistant" id="ao_nsn_rock_mis_assistant" placeholder="Αριθμός Ονομαστικού Κινητήρα" value="<?= $edit['ao_nsn_rock_mis_assistant'] ?>"  />
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΜΕΡΙΔΑ ΚΙΝΗΤΗΡΑ :</td>
                                    <td>
                                        <span title="Συπληρώστε τη μερίδα του κινητήρα, αν δε είναι γνωστή, συμπληρώστε με τη φράση:'ΔΕΝ ΑΝΑΓΡΕΦΕΤΑΙ'"><p>
                                                <input type="text" name="merida_rock_mis_assistant" id="merida_rock_mis_assistant" placeholder="Μερίδα Κινητήρα" value="<?= $edit['merida_rock_mis_assistant'] ?>"  />
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΠΕΡΙΓΡΑΦΗ ΚΙΝΗΤΗΡΑ :</td>
                                    <td>
                                        <span title="Συπληρώστε τη περιγραφή του κινητήρα"><p>
                                                <textarea rows="4" name="perigrafi_rock_mis_assistant" class="input-block-level" id="perigrafi_rock_mis_assistant" placeholder="* Περιγραφή Κινητήρα ..." value="<?= $edit['perigrafi_rock_mis_assistant'] ?>" ><?= $edit['perigrafi_rock_mis_assistant'] ?></textarea>
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΥΠΑΡΧΟΥΣΕΣ ΕΓΚΑΤΑΣΤΑΣΕΙΣ :</td>
                                    <td>        
                                        <span title="Συπληρώστε την ύπαρξη και το είδος των εγκαταστάσεων στη γύρω περιοχή"><p>
                                                <textarea rows="4" name="egatastasis_ktiria" class="input-block-level"  id="egatastasis_ktiria" placeholder="* Ύπαρξη Εγκαταστάσεων ..." value="<?= $edit['egatastasis_ktiria'] ?>" ><?= $edit['egatastasis_ktiria'] ?></textarea>                                            
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΠΙΚΡΑΤΟΥΣΕΣ ΚΑΙΡΙΚΕΣ ΣΥΝΘΗΚΕΣ :</td>
                                    <td>           
                                        <span title="Συπληρώστε τις καιρικές συνθήκες κατά την διάρκεια του περιστατικού"><p>

                                                <input type="text" name="kairos" id="kairos" placeholder="Καιρός" value="<?= $edit['kairos'] ?>"  />
                                        </span>
                                    </td>
                                </tr>

                                <tr class="insertform">
                                    <td>ΥΠΑΡΞΗ ΕΚΑΒ :</td>
                                    <td>
                                        <span title="Επιλέξτε τη διαθεσιμότητα του ΕΚΑΒ">   
                                            <select name="topikes_arxes_ekav" id="topikes_arxes_ekav" class="select_option">
                                                <option value="<?= $edit['topikes_arxes_ekav'] ?>"><?= $edit['topikes_arxes_ekav'] ?></option>
                                                <option value="ΝΑΙ">Ναι</option>
                                                <option value="ΟΧΙ">Όχι</option>
                                            </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΥΠΑΡΞΗ ΕΛΛΑΣ :</td>
                                    <td><span title="Επιλέξτε τη διαθεσιμότητα της ΕΛΛΑΣ">     
                                            <p><select name="topikes_arxes_elas" id="topikes_arxes_elas" class="select_option">
                                                    <option value="<?= $edit['topikes_arxes_elas'] ?>"><?= $edit['topikes_arxes_elas'] ?></option>
                                                    <option value="ΝΑΙ">Ναι</option>
                                                    <option value="ΟΧΙ">Όχι</option>
                                                </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΥΠΑΡΞΗ ΛΙΜΕΝΙΚΟΥ :</td>
                                    <td><span title="Επιλέξτε τη διαθεσιμότητα του Λιμενικού">           
                                            <p><select name="topikes_arxes_limeniko" id="topikes_arxes_limeniko" class="select_option">
                                                    <option value="-<?= $edit['topikes_arxes_limeniko'] ?>"><?= $edit['topikes_arxes_limeniko'] ?></option>
                                                    <option value="ΝΑΙ">Ναι</option>
                                                    <option value="ΟΧΙ">Όχι</option>
                                                </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΥΠΑΡΞΗ ΠΥΡΟΣΒΕΣΤΙΚΗΣ :</td>
                                    <td><span title="Επιλέξτε τη διαθεσιμότητα της Πυροσβεστικής Υπηρεσίας">     
                                            <p><select name="topikes_arxes_pyrosvestiki" id="topikes_arxes_pyrosvestiki" class="select_option">
                                                    <option value="<?= $edit['topikes_arxes_pyrosvestiki'] ?>"><?= $edit['topikes_arxes_pyrosvestiki'] ?></option>
                                                    <option value="ΝΑΙ">Ναι</option>
                                                    <option value="ΟΧΙ">Όχι</option>
                                                </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΝΕΡΓΕΙΕΣ ΑΝΑΓΝΩΡΙΣΗΣ :</td>
                                    <td><span title="Συπληρώστε τις ενέργειες αναγνώρισης">            
                                            <p>
                                                <textarea rows="4" name="anagnorisi" class="input-block-level"  id="anagnorisi" placeholder="* Ενέργειες Αναγνώρισης ..." value="<?= $edit['anagnorisi'] ?>" ><?= $edit['anagnorisi'] ?></textarea>                                                
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΝΕΡΓΕΙΕΣ ΕΞΟΥΔΕΤΕΡΩΣΗΣ :</td>
                                    <td><span title="Συπληρώστε τις ενέργειες της εξουδετέρωσης">    
                                            <p>
                                                <textarea rows="4" name="exoudeterosi" class="input-block-level"  id="exoudeterosi" placeholder="* Ενέργειες Εξουδετέρωσης ..." value="<?= $edit['exoudeterosi'] ?>" ><?= $edit['exoudeterosi'] ?></textarea>                                                
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΝΕΡΓΕΙΕΣ ΠΕΡΙΣΥΛΛΟΓΗΣ :</td>
                                    <td><span title="Συπληρώστε τις ενέργειες της περισυλλογής">       
                                            <p>
                                                <textarea rows="4" name="perisillogi" class="input-block-level"  id="perisillogi" placeholder="* Ενέργειες Περισυλλογής ..." value="<?= $edit['perisillogi'] ?>" ><?= $edit['perisillogi'] ?></textarea>                                                
                                        </span> 
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΝΕΡΓΕΙΕΣ ΜΕΤΑΦΟΡΑΣ :</td>
                                    <td><span title="Συπληρώστε τις ενέργειες της μεταφοράς"> 
                                            <p>
                                                <textarea rows="4" name="metafora" class="input-block-level"  id="metafora" placeholder="* Ενέργειες Μεταφοράς ..." value="<?= $edit['metafora'] ?>" ><?= $edit['metafora'] ?></textarea>                                                
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΝΕΡΓΕΙΕΣ ΚΑΤΑΣΤΡΟΦΗΣ :</td>
                                    <td><span title="Συπληρώστε τις ενέργειες της καταστροφής">    
                                            <p>
                                                <textarea rows="4" name="katastrofi" class="input-block-level"  id="katastrofi" placeholder="* Ενέργειες Καταστροφής ..." value="<?= $edit['katastrofi'] ?>" > <?= $edit['katastrofi'] ?> </textarea>                                                
                                        </span> 
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΝΕΡΓΕΙΕΣ ΕΛΕΓΧΟΥ ΕΣΤΙΑΣ :</td>
                                    <td><span title="Συπληρώστε τα αποτελέσματα του ελέγχου της εστίας, μετά την έκρηξη ή εξουδετέρωση">
                                            <p>
                                                <textarea rows="4" name="elegxos_estias" class="input-block-level"  id="elegxos_estias" placeholder="* Ενέργειες Ελέγχου Εστίας ..." value="<?= $edit['elegxos_estias'] ?>" ><?= $edit['elegxos_estias'] ?></textarea>                                                
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΠΡΟΚΛΗΘΗΣΕΣ ΖΗΜΙΕΣ :</td>
                                    <td><span title="Συπληρώστε τις όποιες ζημίες προκλήθηκαν στη περιοχή. Διαφορετικά συμπληρώστε 'KAMIA'"> 
                                            <p>
                                                <textarea rows="4" name="zimies" class="input-block-level"  id="zimies" placeholder="* Προκληθήσες Ζημίες ..." value="<?= $edit['zimies'] ?>" ><?= $edit['zimies'] ?></textarea>                                                
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΠΑΡΑΤΗΡΗΣΕΙΣ :</td>
                                    <td><span title="Συπληρώστε παρατηρήσεις για το περιστατικό. Διαφορετικά συμπληρώστε 'KAMIA'">    
                                            <p>
                                                <textarea rows="4" name="paratiriseis" class="input-block-level"  id="paratiriseis" placeholder="* Παρατηρήσεις ..." value="<?= $edit['paratiriseis'] ?>" ><?= $edit['paratiriseis'] ?></textarea>                                                
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΕΙΣΤΕ ΕΠΙΚΕΦΑΛΗΣ :</td>
                                    <td><span title="Συπληρώστε αν είστε επικεφαλής ή όχι">
                                            <p><select name="epikefalis" id="epikefalis" class="select_option">
                                                    <option value="<?= $edit['epikefalis'] ?>"><?= $edit['epikefalis'] ?></option>
                                                    <option value="ΝΑΙ">Ναι</option>
                                                    <option value="ΟΧΙ">Όχι</option>
                                                </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr class="insertform">
                                    <td>ΚΑΤΑΣΤΑΣΗ ΠΕΡΙΣΤΑΤΙΚΟΥ :</td>
                                    <td><span title="H κατάσταση του περιστατικού">
                                            <p><select name="status_id" id="status_id" class="select_option">
                                                    <option value="<?= $edit['status_id'] ?>"><?= $edit['status_var'] ?></option>
                                                </select>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="btn btn-group-justified" style="padding-left: 60%;">
                                            <p><?php echo form_submit('submit', ' Ε Π Ε Ξ Ε Ρ Γ Α Σ Ι Α'); ?></p>
                                            <?php echo form_close() ?>
                                        </div>                                              
                                    </td>
                                </tr>
                                <tr>
                                    <td>                                                                                              
                                    <?php endforeach; ?>
                                <?php endif ?> 
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- end divider -->
        </div>
</section>
<?php $this->load->view('Include/include_footer'); ?>  