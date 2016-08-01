<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends CI_Controller {

    public function index() {

        if ($this->session->userdata('userIsLoggedIn')) {
            //authentication of user
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            //user information
            $data['uid'] = $this->session->userdata('uid');
            //pass username to home page
            $data['username'] = $this->session->userdata('username');
            //view the home page
            $this->load->view('User/Home', $data);
        } else {
            //if not authentication the go to Login Page
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function Verify() {
        //call model
        $this->load->model('Usermodel');
        //call library valdiation 
        $this->load->library('form_validation');
        //form validation to login page
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['is_authenticated'] = FALSE;
            //pass the error to the page
            $data['error'] = '<h2>Λανθασμένη εισαγωγή στοιχείων! <br>Προσπαθήστε ξανά! </h2>';
            $this->load->view('User/Login', $data);
        } else {
            if ($this->Usermodel->Login($this->input->post('username'), $this->input->post('password'))) {
                //set session data
                $this->session->set_userdata('userIsLoggedIn', 'true');
                $this->session->set_userdata('username', $this->input->post('username'));
                //$this->session->set_userdata('uid', $this->Usermodel->GetId($this->input->post('username')));
                //redirect to user home page
                redirect('User/Home', 'refresh');
            } else {
                $data['error'] = '<h2>Λανθασμένη εισαγωγή στοιχείων! <br>Προσπαθήστε ξανά! </h2>';
                $data['is_authenticated'] = FALSE;
                $this->load->view('User/Login', $data);
            }
        }
    }

    public function Home() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['username'] = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['uid'] = $this->session->userdata('uid');


            //user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            //load User home page

            $this->load->view('User/Home', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function Logout() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $this->session->unset_userdata('userIsLoggedIn');
            $this->session->unset_userdata('username');
            redirect('User', 'refresh');
        }
    }

    private function getResponse($res, $successMessage) {
        if ($res->status == "200") { //success
            $this->session->set_userdata('messageText', $successMessage);
            $this->session->set_userdata('messageType', 'ok');
        } else { //error
            $this->session->set_userdata('messageText', (string) $res->errorText);
            $this->session->set_userdata('messageType', 'error');
        }

        redirect('User/Home'); //back to user home page to display the results
    }

//    public function CreateRoleForm() {
//        if ($this->session->userdata('userIsLoggedIn')) {
//            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
//            $data['username'] = $this->session->userdata('username');
//            $data['uid'] = $this->session->userdata('uid');
//
//            $this->load->library('form_validation');
//            $error = '';
//
//            $uid = $this->session->userdata('uid');
//            $r_name = stripslashes($_POST['r_name']);
//            $r_description = stripslashes($_POST['r_description']);
//
//            $this->form_validation->set_rules('r_name', 'Ονομασία', 'trim|required|xss_clean');
//            $this->form_validation->set_rules('r_description', 'Περιγραφή', 'trim|required|xss_clean');
//
//            if ($this->form_validation->run() == FALSE) {
//                $data['messageType'] = Null;
//                $data['messageText'] = Null;
//                $data['error'] = $error;
//                $this->load->view('User/ViewApp', $data);
//            } else {
//
//                $client = new SoapClient(
//                        null, array(
//                    'location' => "http://localhost/ato/api_server.php",
//                    'uri' => "urn://localhost/req",
//                    'trace' => 1)
//                );
//
//                #Call the service to create a tax form
//                $result = $client->submitRoleForm($r_name, $r_description);
//
//                $this->getResponse($result, $this->session->set_flashdata('success_msg', ''
//                                . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
//                                . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
//                                . '</div>'));
//            }
//        } else {
//            $data['is_authenticated'] = FALSE;
//            $this->load->view('User/Login', $data);
//        }
//    }
//    
    //PersonalDetails of user
    public function ViewPersonalDetails($sort_by = 'personal_details_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            //user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            //pass messages
            $data['gens'] = $this->Usermodel->getViewPersonalDetails($user);
            $limit = 10;
            $this->load->model('Usermodel');
            $results = $this->Usermodel->searchViewPersonalDetails($user, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewPersonalDetails/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('personal_details');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'personal_details_id' => 'Α/Α',
                'pd_vathmos' => 'Βαθμός',
                'pd_oplo_soma' => 'Όπλο/Σώμα',
                'pd_onoma' => 'Όνομα',
                'pd_eponimo' => 'Επώνυμο',
                'pd_am' => 'ΑΜ',
                'monada_name' => 'Μονάδα',
                'r_name' => 'Ρόλος',
                'pd_username' => 'Username',
                'pd_password' => 'Password'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewPersonalDetails', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewPersonalDetailsCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $user = $this->session->userdata('username');

            $this->load->model('Usermodel');
            //pass messages
            //$data['gens'] = $this->Usermodel->getEditPersonalDetails($user);

            $this->load->view('User/ViewPersonalDetailsCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreatePersonalDetails() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('pd_vathmos', 'Βαθμός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_oplo_soma', 'Όπλο/Σώμα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_onoma', 'Όνομα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_eponimo', 'Επώνυμο', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_am', 'ΑΜ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('monada_id', 'Σχηματισμός/Μονάδα που Υπηρετώ', 'required|callback_Select_MONADA');
            $this->form_validation->set_rules('eod', 'Απόφοιτος EOD', 'required|callback_Select_EOD');

            $this->form_validation->set_rules('roles_id', 'Επιλέξτε από το πεδίο   Επιλογή Ρόλου ', 'required|callback_Select_ROLES'); // Validating select option field.
            $this->form_validation->set_rules('pd_username', 'Username', 'trim|required|is_unique[personal_details.pd_username]|xss_clean');
            $this->form_validation->set_rules('pd_password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('choosenWord', 'Λεκτικό Χρήστη', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewPersonalDetailsCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $pd_vathmos = stripslashes($_POST['pd_vathmos']);
                    $pd_oplo_soma = stripslashes($_POST['pd_oplo_soma']);
                    $pd_onoma = stripslashes($_POST['pd_onoma']);
                    $pd_eponimo = stripslashes($_POST['pd_eponimo']);
                    $pd_am = stripslashes($_POST['pd_am']);
                    $monada_id = stripslashes($_POST['monada_id']);
                    $eod = stripslashes($_POST['eod']);
                    $roles_id = stripslashes($_POST['roles_id']);
                    $pd_username = stripslashes($_POST['pd_username']);
                    $pd_password = stripslashes($_POST['pd_password']);
                    $choosenWord = stripslashes($_POST['choosenWord']);
                    $data = array(
                        'personal_details_id' => NULL,
                        'pd_vathmos' => $pd_vathmos,
                        'pd_oplo_soma' => $pd_oplo_soma,
                        'pd_onoma' => $pd_onoma,
                        'pd_eponimo' => $pd_eponimo,
                        'pd_am' => $pd_am,
                        'monada_id' => $monada_id,
                        'eod' => $eod,
                        'roles_id' => $roles_id,
                        'pd_username' => $pd_username,
                        'pd_password' => $pd_password,
                        'choosenWord' => $choosenWord
                    );
                    $this->Usermodel->add_PersonalDetails($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');
                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_ROLES($roles_id) {

        if ($roles_id == "-1") {
            $this->form_validation->set_message('Select_ROLES', 'Επιλέξτε από το πεδίο   Επιλογή Ρόλου');
            return false;
        } else {
            return true;
        }
    }

    function Select_MONADA($monada_id) {

        if ($monada_id == "-1") {
            $this->form_validation->set_message('Select_MONADA', 'Επιλέξτε από το πεδίο   Σχηματισμός/Μονάδα');
            return false;
        } else {
            return true;
        }
    }

    function Select_EOD($eod) {

        if ($eod == "-1") {
            $this->form_validation->set_message('Select_EOD', 'Επιλέξτε από το πεδίο  Απόφοιτος EOD');
            return false;
        } else {
            return true;
        }
    }

    public function ViewPersonalDetailsEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

            $user = $this->session->userdata('username');
            $data['edit'] = $this->Usermodel->PersonalDetailsEditForm($user);

            $this->load->view('User/ViewPersonalDetailsEditForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function EditPersonalDetails() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('pd_vathmos', 'Βαθμός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_oplo_soma', 'Όπλο/Σώμα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_onoma', 'Όνομα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_eponimo', 'Επώνυμο', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pd_am', 'ΑΜ', 'trim|required|xss_clean');
            //$this->form_validation->set_rules('monada_id', 'Σχηματισμός/Μονάδα που Υπηρετώ', 'trim|required|xss_clean');Edit_MONADA
            $this->form_validation->set_rules('monada_id', 'Επιλέξτε από το πεδίο   Σχηματισμός/Μονάδα που Υπηρετώ ', 'required|callback_Edit_MONADA'); // Validating select option field.
            $this->form_validation->set_rules('eod', 'Επιλέξτε από το πεδίο   Απόφοιτος EOD ', 'required|callback_Edit_EOD'); // Validating select option field.
            //$this->form_validation->set_rules('roles_id', 'Επιλέξτε από το πεδίο   Επιλογή Ρόλου ', 'required|callback_Edit_ROLES'); // Validating select option field.
            //$this->form_validation->set_rules('pd_username', 'Username', 'trim|required|is_unique[personal_details.pd_username]|xss_clean');
            $this->form_validation->set_rules('pd_password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('choosenWord', 'Λεκτικό Χρήστη', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewPersonalDetailsEditForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $personal_details_id = $this->input->post('personal_details_id');
                    $pd_vathmos = $this->input->post('pd_vathmos');
                    $pd_oplo_soma = $this->input->post('pd_oplo_soma');
                    $pd_onoma = $this->input->post('pd_onoma');
                    $pd_eponimo = $this->input->post('pd_eponimo');
                    $pd_am = $this->input->post('pd_am');
                    $monada_id = $this->input->post('monada_id');
                    $eod = $this->input->post('eod');
                    $roles_id = $this->input->post('roles_id');
                    $pd_username = $this->input->post('pd_username');
                    $pd_password = $this->input->post('pd_password');
                    $choosenWord = $this->input->post('choosenWord');

                    //call soap library 
                    $this->load->library('nusoap');

                    //call client of soap to the following ip
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        // At this point, you know the call that follows will fail
                    }
                    // Call the SOAP method and pass the variables to it
                    $result = $client->call('EditPersonaleDetails', array(
                        'personal_details_id' => $personal_details_id,
                        'pd_vathmos' => $pd_vathmos,
                        'pd_oplo_soma' => $pd_oplo_soma,
                        'pd_onoma' => $pd_onoma,
                        'pd_eponimo' => $pd_eponimo,
                        'pd_am' => $pd_am,
                        'monada_id' => $monada_id,
                        'eod' => $eod,
                        'roles_id' => $roles_id,
                        'pd_username' => $pd_username,
                        'pd_password' => $pd_password,
                        'choosenWord' => $choosenWord
                    ));
                    //Display the messages!!!
                    // Check for a fault 
                    if ($client->fault) {
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        print_r($result);
                    } else {
                        // Check for errors
                        $error = $client->getError();
                        if ($error) {
                            // Display the error
                            $error = $this->session->set_flashdata('edit_msg', ''
                                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                    . '</div>');
                        } else {
                            // Display the result
                            $this->session->set_flashdata('success_msg', ''
                                    . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                                    . '</div>');
                            redirect('User/Home');
                        }
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Edit_ROLES($roles_id) {

        if ($roles_id == "-1") {
            $this->form_validation->set_message('Edit_ROLES', 'Επιλέξτε από το πεδίο   Επιλογή Ρόλου');
            return false;
        } else {
            return true;
        }
    }

    function Edit_MONADA($monada_id) {

        if ($monada_id == "-1") {
            $this->form_validation->set_message('Edit_MONADA', 'Επιλέξτε από το πεδίο   Σχηματισμό/Μονάδα');
            return false;
        } else {
            return true;
        }
    }

    function Edit_EOD($eod) {

        if ($eod == "-1") {
            $this->form_validation->set_message('Edit_EOD', 'Επιλέξτε από το πεδίο  Απόφοιτος EOD');
            return false;
        } else {
            return true;
        }
    }

    public function ViewRoles($sort_by = 'roles_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            //pass messages
            $data['gens'] = $this->Usermodel->getViewRoles();
            $limit = 10;
            $results = $this->Usermodel->searchViewRoles($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewRoles/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('roles');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'r_name' => 'Ονομασία',
                'r_description' => 'Περιγραφή'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewRoles', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewRolesCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');

            $this->load->view('User/ViewRolesCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateRoles() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $r_name = stripslashes($_POST['r_name']);
            $r_description = stripslashes($_POST['r_description']);

            $this->form_validation->set_rules('r_name', 'Ονομασία', 'trim|required|xss_clean');
            $this->form_validation->set_rules('r_description', 'Περιγραφή', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewRolesCreationForm', $data);
            } else {

                $r_name = $this->input->post('r_name');
                $r_description = $this->input->post('r_description');

                $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                $error = $client->getError();
                if ($error) {
                    // Display the error
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    // At this point, you know the call that follows will fail
                }
                // Call the SOAP method
                $result = $client->call('Roles', array('r_name' => $r_name, 'r_description' => $r_description));
                // Check for a fault
                if ($client->fault) {
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    print_r($result);
                } else {
                    // Check for errors
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                    } else {
                        // Display the result
                        $this->session->set_flashdata('success_msg', ''
                                . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                                . '</div>');
                        redirect('User/Home');
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewRolesEach($roles_id, $sort_by = 'roles_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditRoles($roles_id);
//pagination

            $this->load->view('User/ViewRolesEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewRolesEdit($roles_id, $sort_by = 'roles_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditRoles($roles_id);
//pagination

            $this->load->view('User/ViewRolesEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewRolesEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $r_name = stripslashes($_POST['r_name']);
            $r_description = stripslashes($_POST['r_description']);
            $roles_id = stripslashes($_POST['roles_id']);

            $this->form_validation->set_rules('r_name', 'Ονομασία', 'trim|required|xss_clean');
            $this->form_validation->set_rules('r_description', 'Περιγραφή', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewRolesEdit', $data);
            } else {

                $r_name = stripslashes($_POST['r_name']);
                $r_description = stripslashes($_POST['r_description']);
                $roles_id = stripslashes($_POST['roles_id']);

                $data = array(
                    'roles_id' => $roles_id,
                    'r_name' => $r_name,
                    'r_description' => $r_description
                );
                $this->Usermodel->edit_Roles($roles_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewRolesDelete($roles_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->RolesDelete($roles_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewStatus($sort_by = 'status_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

//pass messages
            $data['gens'] = $this->Usermodel->getViewStatus();
            $limit = 10;
            $results = $this->Usermodel->searchViewStatus($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewStatus/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('status');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'status_var' => 'Status'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewStatus', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewStatusEach($status_id, $sort_by = 'status_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditStatus($status_id);
//pagination

            $this->load->view('User/ViewStatusEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewStatusCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');

//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->view('User/ViewStatusCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateStatus() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');

//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $status_var = stripslashes($_POST['status_var']);

            $this->form_validation->set_rules('status_var', 'Status', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewStatusCreationForm', $data);
            } else {

                $status = stripslashes($_POST['status']);

                $data = array(
                    'status_id' => NULL,
                    'status_var' => $this->input->post('status_var')
                );
                $this->Usermodel->add_Status($data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewStatusEdit($status_id, $sort_by = 'status_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditStatus($status_id);
//pagination

            $this->load->view('User/ViewStatusEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewStatusEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $status_var = stripslashes($_POST['status_var']);
            $status_id = stripslashes($_POST['status_id']);
//$this->form_validation->set_rules('r_name', 'Ονομασία', 'trim|required|xss_clean');
            $this->form_validation->set_rules('status_var', 'Ονομασία', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewStatusEdit', $data);
            } else {

                $status_var = stripslashes($_POST['status_var']);
                $status_id = stripslashes($_POST['status_id']);

                $data = array(
                    'status_id' => $status_id,
                    'status_var' => $status_var
                );
                $this->Usermodel->edit_Status($status_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewStatusDelete($status_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->StatusDelete($status_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewAmmo($sort_by = 'eidos_puromaxikou_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
//pass messages
            $data['gens'] = $this->Usermodel->getViewAmmo();
            $limit = 10;
            $results = $this->Usermodel->searchViewAmmo($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewAmmo/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('eidos_puromaxikou');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'eidos_puromaxikou_id' => 'Α/Α',
                'ep_eidos' => 'Είδος Πυρομαχικού',
                'ep_value' => 'Κωδικός Επιλογής',
                'ep_perigrafi' => 'Περιγραφή'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewAmmo', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewAmmoCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');

//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->view('User/ViewAmmoCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateAmmo() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';
            $ep_eidos = stripslashes($_POST['ep_eidos']);
            $ep_value = stripslashes($_POST['ep_value']);
            $ep_perigrafi = stripslashes($_POST['ep_perigrafi']);

            $this->form_validation->set_rules('ep_eidos', 'ep_eidos', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ep_value', 'ep_value', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ep_perigrafi', 'ep_perigrafi', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewAmmoCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $ep_eidos = stripslashes($_POST['ep_eidos']);
                    $ep_value = stripslashes($_POST['ep_value']);
                    $ep_perigrafi = stripslashes($_POST['ep_perigrafi']);

                    $data = array(
                        'eidos_puromaxikou_id' => NULL,
                        'ep_eidos' => $this->input->post('ep_eidos'),
                        'ep_value' => $this->input->post('ep_value'),
                        'ep_perigrafi' => $this->input->post('ep_perigrafi')
                    );
                    $this->Usermodel->add_Ammo($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');

                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewAmmoEach($eidos_puromaxikou_id, $sort_by = 'eidos_puromaxikou_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditAmmo($eidos_puromaxikou_id);
//pagination

            $this->load->view('User/ViewAmmoEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewAmmoEdit($eidos_puromaxikou_id, $sort_by = 'eidos_puromaxikou_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditAmmo($eidos_puromaxikou_id);
//pagination

            $this->load->view('User/ViewAmmoEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewAmmoEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $ep_eidos = stripslashes($_POST['ep_eidos']);
            $ep_value = stripslashes($_POST['ep_value']);
            $ep_perigrafi = stripslashes($_POST['ep_perigrafi']);

            $eidos_puromaxikou_id = stripslashes($_POST['eidos_puromaxikou_id']);

            $this->form_validation->set_rules('ep_eidos', 'Είδος Πυρομαχικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ep_value', 'Κωδικός Πυρομαχικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ep_perigrafi', 'Περιγραφή Είδος Πυρομαχικού', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewAmmoEdit', $data);
            } else {
                $ep_eidos = stripslashes($_POST['ep_eidos']);
                $ep_value = stripslashes($_POST['ep_value']);
                $ep_perigrafi = stripslashes($_POST['ep_perigrafi']);

                $eidos_puromaxikou_id = stripslashes($_POST['eidos_puromaxikou_id']);

                $data = array(
                    'eidos_puromaxikou_id' => $eidos_puromaxikou_id,
                    'ep_eidos' => $this->input->post('ep_eidos'),
                    'ep_value' => $this->input->post('ep_value'),
                    'ep_perigrafi' => $this->input->post('ep_perigrafi')
                );
                $this->Usermodel->edit_Ammo($eidos_puromaxikou_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewAmmoDelete($eidos_puromaxikou_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->AmmoDelete($eidos_puromaxikou_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewEvent($sort_by = 'eidos_sumvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
//pass messages
            $data['gens'] = $this->Usermodel->getViewEvent();
            $limit = 10;

            $results = $this->Usermodel->searchViewEvent($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewEvent/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('eidos_sumvantos');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'eidos_sumvantos_id' => 'Α/Α',
                'es_code' => 'Κωδικός Επιλογής',
                'es_perigrafi' => 'Περιγραφή',
                'es_notes' => 'Σημειώσεις'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewEvent', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEventCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->view('User/ViewEventCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateEvent() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';
            $es_code = stripslashes($_POST['es_code']);
            $es_perigrafi = stripslashes($_POST['es_perigrafi']);
            $es_notes = stripslashes($_POST['es_notes']);

            $this->form_validation->set_rules('es_code', 'Κωδικός Συμβάντος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('es_perigrafi', 'Περιγραφή Συμβάντος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('es_notes', 'Σημειώσεις', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewEventCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $es_code = stripslashes($_POST['es_code']);
                    $es_perigrafi = stripslashes($_POST['es_perigrafi']);
                    $es_notes = stripslashes($_POST['es_notes']);

                    $data = array(
                        'eidos_sumvantos_id' => NULL,
                        'es_code' => $this->input->post('es_code'),
                        'es_perigrafi' => $this->input->post('es_perigrafi'),
                        'es_notes' => $this->input->post('es_notes')
                    );
                    $this->Usermodel->add_Event($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');

                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEventEach($eidos_sumvantos_id, $sort_by = 'eidos_sumvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditEvent($eidos_sumvantos_id);
//pagination

            $this->load->view('User/ViewEventEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEventEdit($eidos_sumvantos_id, $sort_by = 'eidos_sumvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditEvent($eidos_sumvantos_id);
//pagination

            $this->load->view('User/ViewEventEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEventEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $eidos_sumvantos_id = stripslashes($_POST['eidos_sumvantos_id']);

            $es_code = stripslashes($_POST['es_code']);
            $es_perigrafi = stripslashes($_POST['es_perigrafi']);
            $es_notes = stripslashes($_POST['es_notes']);


            $this->form_validation->set_rules('es_code', 'Κωδικός Συμβάντος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('es_perigrafi', 'Περιγραφή Συμβάντος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('es_notes', 'Σημειώσεις', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewEventEdit', $data);
            } else {

                $eidos_sumvantos_id = stripslashes($_POST['eidos_sumvantos_id']);

                $es_code = stripslashes($_POST['es_code']);
                $es_perigrafi = stripslashes($_POST['es_perigrafi']);
                $es_notes = stripslashes($_POST['es_notes']);

                $data = array(
                    'eidos_sumvantos_id' => $eidos_sumvantos_id,
                    'es_code' => $this->input->post('es_code'),
                    'es_perigrafi' => $this->input->post('es_perigrafi'),
                    'es_notes' => $this->input->post('es_notes')
                );
                $this->Usermodel->edit_Event($eidos_sumvantos_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEventDelete($eidos_sumvantos_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->EventDelete($eidos_sumvantos_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewCompetence($sort_by = 'katanomi_armodiotiton_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');
//pass messages
            $data['gens'] = $this->Usermodel->getViewCompetence();
            $limit = 10;

            $results = $this->Usermodel->searchViewCompetence($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewCompetence/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('katanomi_armodiotiton');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'ka_armodiotites' => 'Αρμοδιότητες',
                'ka_perigrafi_armodiotiton' => 'Περιγραφή'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewCompetence', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewCompetenceCreationForm() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $this->load->view('User/ViewCompetenceCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateCompetence() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $ka_armodiotites = stripslashes($_POST['ka_armodiotites']);
            $ka_perigrafi_armodiotiton = stripslashes($_POST['ka_perigrafi_armodiotiton']);

            $this->form_validation->set_rules('ka_armodiotites', 'Αρμοδιότητες', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ka_perigrafi_armodiotiton', 'Περιγραφή', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewCompetenceCreationForm', $data);
            } else {


                $ka_armodiotites = stripslashes($_POST['ka_armodiotites']);
                $ka_perigrafi_armodiotiton = stripslashes($_POST['ka_perigrafi_armodiotiton']);

                $data = array(
                    'katanomi_armodiotiton_id' => NULL,
                    'ka_armodiotites' => $this->input->post('ka_armodiotites'),
                    'ka_perigrafi_armodiotiton' => $this->input->post('ka_perigrafi_armodiotiton')
                );
                $this->Usermodel->add_Competence($data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewCompetenceEach($katanomi_armodiotiton_id, $sort_by = 'katanomi_armodiotiton_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditCompetence($katanomi_armodiotiton_id);
//pagination

            $this->load->view('User/ViewCompetenceEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewCompetenceEdit($katanomi_armodiotiton_id, $sort_by = 'katanomi_armodiotiton_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditCompetence($katanomi_armodiotiton_id);
//pagination

            $this->load->view('User/ViewCompetenceEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewCompetenceEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $katanomi_armodiotiton_id = stripslashes($_POST['katanomi_armodiotiton_id']);

            $ka_armodiotites = stripslashes($_POST['ka_armodiotites']);
            $ka_perigrafi_armodiotiton = stripslashes($_POST['ka_perigrafi_armodiotiton']);

            $this->form_validation->set_rules('ka_armodiotites', 'Αρμοδιότητες', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ka_perigrafi_armodiotiton', 'Περιγραφή', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewCompetenceEdit', $data);
            } else {
                $katanomi_armodiotiton_id = stripslashes($_POST['katanomi_armodiotiton_id']);

                $ka_armodiotites = stripslashes($_POST['ka_armodiotites']);
                $ka_perigrafi_armodiotiton = stripslashes($_POST['ka_perigrafi_armodiotiton']);

                $data = array(
                    'katanomi_armodiotiton_id' => $katanomi_armodiotiton_id,
                    'ka_armodiotites' => $this->input->post('ka_armodiotites'),
                    'ka_perigrafi_armodiotiton' => $this->input->post('ka_perigrafi_armodiotiton')
                );
                $this->Usermodel->edit_Competence($katanomi_armodiotiton_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewCompetenceDelete($katanomi_armodiotiton_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->CompetenceDelete($katanomi_armodiotiton_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewPriority($sort_by = 'katigoria_proteraiotitas_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

//pass messages
            $data['gens'] = $this->Usermodel->getViewPriority();
            $limit = 10;
            $results = $this->Usermodel->searchViewPriority($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewPriority/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('katigoria_proteraiotitas');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'kp_code' => 'Κωδικός',
                'kp_perigrafi' => 'Περιγραφή'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewPriority', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewPriorityCreationForm() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->view('User/ViewPriorityCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreatePriority() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';
            $kp_code = stripslashes($_POST['kp_code']);
            $kp_perigrafi = stripslashes($_POST['kp_perigrafi']);

            $this->form_validation->set_rules('kp_code', 'Κωδικός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('kp_perigrafi', 'Περιγραφή', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewPriorityCreationForm', $data);
            } else {


                $kp_code = stripslashes($_POST['kp_code']);
                $kp_perigrafi = stripslashes($_POST['kp_perigrafi']);

                $data = array(
                    'katigoria_proteraiotitas_id' => NULL,
                    'kp_code' => $this->input->post('kp_code'),
                    'kp_perigrafi' => $this->input->post('kp_perigrafi')
                );
                $this->Usermodel->add_Priority($data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewPriorityEach($katigoria_proteraiotitas_id, $sort_by = 'katigoria_proteraiotitas_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditPriority($katigoria_proteraiotitas_id);
//pagination

            $this->load->view('User/ViewPriorityEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewPriorityEdit($katigoria_proteraiotitas_id, $sort_by = 'katigoria_proteraiotitas_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditPriority($katigoria_proteraiotitas_id);
//pagination

            $this->load->view('User/ViewPriorityEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewPriorityEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $katigoria_proteraiotitas_id = stripslashes($_POST['katigoria_proteraiotitas_id']);
            $kp_code = stripslashes($_POST['kp_code']);
            $kp_perigrafi = stripslashes($_POST['kp_perigrafi']);

            $this->form_validation->set_rules('kp_code', 'Κωδικός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('kp_perigrafi', 'Περιγραφή', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewPriorityEdit', $data);
            } else {

                $katigoria_proteraiotitas_id = stripslashes($_POST['katigoria_proteraiotitas_id']);

                $kp_code = stripslashes($_POST['kp_code']);
                $kp_perigrafi = stripslashes($_POST['kp_perigrafi']);

                $data = array(
                    'katigoria_proteraiotitas_id' => $katigoria_proteraiotitas_id,
                    'kp_code' => $this->input->post('kp_code'),
                    'kp_perigrafi' => $this->input->post('kp_perigrafi')
                );
                $this->Usermodel->edit_Priority($katigoria_proteraiotitas_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewPriorityDelete($katigoria_proteraiotitas_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->PriorityDelete($katigoria_proteraiotitas_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewIncident($sort_by = 'katigoria_sumvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

//pass messages
            $data['gens'] = $this->Usermodel->getViewIncident();
            $limit = 10;

            $results = $this->Usermodel->searchViewIncident($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewIncident/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('katigoria_sumbantos');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'ks_epipedo' => 'Επίπεδο',
                'ks_perigrafi' => 'Περιγραφή'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewIncident', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');

            $this->load->view('User/ViewIncidentCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateIncident() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';
            $ks_epipedo = stripslashes($_POST['ks_epipedo']);
            $ks_perigrafi = stripslashes($_POST['ks_perigrafi']);

            $this->form_validation->set_rules('ks_epipedo', 'Επίπεδο', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ks_perigrafi', 'Περιγραφή', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewIncidentCreationForm', $data);
            } else {

                $ks_epipedo = stripslashes($_POST['ks_epipedo']);
                $ks_perigrafi = stripslashes($_POST['ks_perigrafi']);
                $data = array(
                    'katigoria_sumvantos_id' => NULL,
                    'ks_epipedo' => $this->input->post('ks_epipedo'),
                    'ks_perigrafi' => $this->input->post('ks_perigrafi')
                );
                $this->Usermodel->add_Incident($data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentEach($katigoria_sumvantos_id, $sort_by = 'katigoria_sumvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditIncident($katigoria_sumvantos_id);
//pagination

            $this->load->view('User/ViewIncidentEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentEdit($katigoria_sumvantos_id, $sort_by = 'katigoria_sumvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditIncident($katigoria_sumvantos_id);
//pagination

            $this->load->view('User/ViewIncidentEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $katigoria_sumvantos_id = stripslashes($_POST['katigoria_sumvantos_id']);

            $ks_epipedo = stripslashes($_POST['ks_epipedo']);
            $ks_perigrafi = stripslashes($_POST['ks_perigrafi']);

            $this->form_validation->set_rules('ks_epipedo', 'Επίπεδο', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ks_perigrafi', 'Περιγραφή', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewIncidentEdit', $data);
            } else {
                $katigoria_sumvantos_id = stripslashes($_POST['katigoria_sumvantos_id']);

                $ks_epipedo = stripslashes($_POST['ks_epipedo']);
                $ks_perigrafi = stripslashes($_POST['ks_perigrafi']);

                $data = array(
                    'katigoria_sumvantos_id' => $katigoria_sumvantos_id,
                    'ks_epipedo' => $this->input->post('ks_epipedo'),
                    'ks_perigrafi' => $this->input->post('ks_perigrafi')
                );
                $this->Usermodel->edit_Incident($katigoria_sumvantos_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentDelete($katigoria_sumvantos_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->IncidentDelete($katigoria_sumvantos_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewIncidentPosition($sort_by = 'thesi_simvantos_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

//pass messages
            $data['gens'] = $this->Usermodel->getViewIncidentPosition();
            $limit = 10;

            $results = $this->Usermodel->searchViewIncidentPosition($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewIncidentPosition/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('thesi_sumvantos');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'ts_thesi' => 'Θέση Συμβάντος',
                'ts_value' => 'Κωδικός',
                'ts_perigrafi' => 'Περιγραφή'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewIncidentPosition', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentPositionCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->view('User/ViewIncidentPositionCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateIncidentPosition() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $ts_thesi = stripslashes($_POST['ts_thesi']);
            $ts_value = stripslashes($_POST['ts_value']);
            $ts_perigrafi = stripslashes($_POST['ts_perigrafi']);

            $this->form_validation->set_rules('ts_thesi', 'Θέση Συμβάντος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ts_value', 'Κωδικός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ts_perigrafi', 'Περιγραφή', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewIncidentPositionCreationForm', $data);
            } else {

                $ts_thesi = stripslashes($_POST['ts_thesi']);
                $ts_value = stripslashes($_POST['ts_value']);
                $ts_perigrafi = stripslashes($_POST['ts_perigrafi']);

                $data = array(
                    'thesi_simvantos_id' => NULL,
                    'ts_thesi' => $this->input->post('ts_thesi'),
                    'ts_value' => $this->input->post('ts_value'),
                    'ts_perigrafi' => $this->input->post('ts_perigrafi')
                );
                $this->Usermodel->add_IncidentPosition($data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentPositionEach($thesi_simvantos_id, $sort_by = 'thesi_simvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditIncidentPosition($thesi_simvantos_id);
//pagination

            $this->load->view('User/ViewIncidentPositionEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentPositionEdit($thesi_simvantos_id, $sort_by = 'thesi_simvantos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditIncidentPosition($thesi_simvantos_id);
//pagination

            $this->load->view('User/ViewIncidentPositionEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentPositionEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $thesi_simvantos_id = stripslashes($_POST['thesi_simvantos_id']);

            $ts_thesi = stripslashes($_POST['ts_thesi']);
            $ts_value = stripslashes($_POST['ts_value']);
            $ts_perigrafi = stripslashes($_POST['ts_perigrafi']);

            $this->form_validation->set_rules('ts_thesi', 'Θέση Συμβάντος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ts_value', 'Κωδικός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ts_perigrafi', 'Περιγραφή', 'trim|required|xss_clean');


            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewIncidentPositionEdit', $data);
            } else {

                $thesi_simvantos_id = stripslashes($_POST['thesi_simvantos_id']);

                $ts_thesi = stripslashes($_POST['ts_thesi']);
                $ts_value = stripslashes($_POST['ts_value']);
                $ts_perigrafi = stripslashes($_POST['ts_perigrafi']);

                $data = array(
                    'thesi_simvantos_id' => $thesi_simvantos_id,
                    'ts_thesi' => $this->input->post('ts_thesi'),
                    'ts_value' => $this->input->post('ts_value'),
                    'ts_perigrafi' => $this->input->post('ts_perigrafi')
                );
                $this->Usermodel->edit_IncidentPosition($thesi_simvantos_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewIncidentPositionDelete($thesi_simvantos_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->AmmoDelete($thesi_simvantos_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewExplosive($sort_by = 'ekriktika_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
//pass messages
            $data['gens'] = $this->Usermodel->getViewExplosive();
            $limit = 10;
            $this->load->model('Usermodel');
            $results = $this->Usermodel->searchViewExplosive($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewExplosive/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('ekriktika');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'ekriktika_id' => 'Α/Α',
                'ek_eidos' => 'Τύπος Εκρηκτικού',
                'ek_paratiriseis' => 'Παρατηρήσεις'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewExplosive', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->view('User/ViewExplosiveCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateExplosive() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';
            $ek_eidos = stripslashes($_POST['ek_eidos']);
            $ek_paratiriseis = stripslashes($_POST['ek_paratiriseis']);


            $this->form_validation->set_rules('ek_eidos', 'Είδος Εκρηκτικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ek_paratiriseis', 'Παρατηρήσεις', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewExplosiveCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $ek_eidos = stripslashes($_POST['ek_eidos']);
                    $ek_paratiriseis = stripslashes($_POST['ek_paratiriseis']);


                    $data = array(
                        'ekriktika_id' => NULL,
                        'ek_eidos' => $this->input->post('ek_eidos'),
                        'ek_paratiriseis' => $this->input->post('ek_paratiriseis')
                    );
                    $this->Usermodel->add_Explosive($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');

                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('Admin/Login', $data);
        }
    }

    public function ViewExplosiveEach($ekriktika_id, $sort_by = 'ekriktika_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditExplosive($ekriktika_id);
//pagination

            $this->load->view('User/ViewExplosiveEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveEdit($ekriktika_id, $sort_by = 'ekriktika_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditExplosive($ekriktika_id);
//pagination

            $this->load->view('User/ViewExplosiveEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $ekriktika_id = stripslashes($_POST['ekriktika_id']);

            $ek_eidos = stripslashes($_POST['ek_eidos']);
            $ek_paratiriseis = stripslashes($_POST['ek_paratiriseis']);


            $this->form_validation->set_rules('ek_eidos', 'Είδος Εκρηκτικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ek_paratiriseis', 'Παρατηρήσεις', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewExplosiveEdit', $data);
            } else {

                $ekriktika_id = stripslashes($_POST['ekriktika_id']);

                $ek_eidos = stripslashes($_POST['ek_eidos']);
                $ek_paratiriseis = stripslashes($_POST['ek_paratiriseis']);


                $data = array(
                    'ekriktika_id' => $ekriktika_id,
                    'ek_eidos' => $this->input->post('ek_eidos'),
                    'ek_paratiriseis' => $this->input->post('ek_paratiriseis')
                );
                $this->Usermodel->edit_Explosive($ekriktika_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveDelete($ekriktika_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->ExplosiveDelete($ekriktika_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    
    
    
    
    
    
        public function ViewExplosiveLot($sort_by = 'ekriktika_lot_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
//pass messages
            $data['gens'] = $this->Usermodel->getViewExplosiveLot();
            $limit = 10;
            $this->load->model('Usermodel');
            $results = $this->Usermodel->searchViewExplosiveLot($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewExplosiveLot/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('ekriktika');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'ekriktika_id' => 'Α/Α Εκρηκτικού',
                'ek_eidos' => 'Τύπος Εκρηκτικού',
                'lot' => 'Μερίδα'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewExplosiveLot', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveLotCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->view('User/ViewExplosiveLotCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateExplosiveLot() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $this->load->library('form_validation');
            $error = '';
            $ekriktika_id = stripslashes($_POST['ekriktika_id']);
            $lot = stripslashes($_POST['lot']);

            $this->form_validation->set_rules('ekriktika_id', 'Επιλέξτε από το πεδίο   Είδος Εκρηκτικού ', 'required|callback_SELECT_EXPLOSIVE'); // Validating select option field.
            $this->form_validation->set_rules('lot', 'Μερίδα Εκρηκτικού', 'trim|required|xss_clean');

            
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewExplosiveLotCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $ekriktika_id = stripslashes($_POST['ekriktika_id']);
                    $lot = stripslashes($_POST['lot']);


                    $data = array(
                        'ekriktika_lot_id' => NULL,
                        'ekriktika_id' => $this->input->post('ekriktika_id'),
                        'lot' => $this->input->post('lot')
                    );
                    $this->Usermodel->add_ExplosiveLot($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');

                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('Admin/Login', $data);
        }
    }
    
    
        function SELECT_EXPLOSIVE($ekriktika_id) {

        if ($ekriktika_id == "-1") {
            $this->form_validation->set_message('SELECT_EXPLOSIVE', 'Επιλέξτε από το πεδίο   Είδος Εκρηκτικού');
            return false;
        } else {
            return true;
        }
    }


    public function ViewExplosiveLotEach($ekriktika_id, $sort_by = 'ekriktika_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['editE'] = $this->Usermodel->getEditExplosiveELot($ekriktika_id);
            $data['edit'] = $this->Usermodel->getEditExplosiveLot($ekriktika_id);
//pagination

            $this->load->view('User/ViewExplosiveLotEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveLotEdit($ekriktika_lot_id, $ek_eidos, $sort_by = 'ekriktika_lot_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['editExplosive'] = $this->Usermodel->getEditExplosiveLotExplosiveEdit($ek_eidos);
            $data['edit'] = $this->Usermodel->getEditExplosiveLotEdit($ekriktika_lot_id);
            
//pagination

            $this->load->view('User/ViewExplosiveLotEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveLotEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $ekriktika_lot_id = stripslashes($_POST['ekriktika_lot_id']);

            $lot = stripslashes($_POST['lot']);

            $this->form_validation->set_rules('lot', 'Μερίδα Πυρομαχικού', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewExplosiveLotEdit', $data);
            } else {

                $ekriktika_lot_id = stripslashes($_POST['ekriktika_lot_id']);
                $lot = stripslashes($_POST['lot']);


                $data = array(
                    'ekriktika_lot_id' => $ekriktika_lot_id,
                    'lot' => $this->input->post('lot')
                );
                $this->Usermodel->edit_ExplosiveLot($ekriktika_lot_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewExplosiveLotDelete($ekriktika_lot_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->ExplosiveLotDelete($ekriktika_lot_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function ViewEquipment($sort_by = 'exoplismos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

//pass messages
            $data['gens'] = $this->Usermodel->getViewEquipment();
            $limit = 10;
            $results = $this->Usermodel->searchViewEquipment($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewEquipment/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('exoplismos');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'exoplismos_id' => 'Α/Α',
                'ex_eidos' => 'Είδος',
                'ex_paratiriseis' => 'Παρατηρήσεις'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewEquipment', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEquipmentCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->view('User/ViewEquipmentCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateEquipment() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $ex_eidos = stripslashes($_POST['ex_eidos']);
            $ex_paratiriseis = stripslashes($_POST['ex_paratiriseis']);

            $this->form_validation->set_rules('ex_eidos', 'Είδος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ex_paratiriseis', 'Παρατηρήσεις', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewEquipmentCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $ex_eidos = stripslashes($_POST['ex_eidos']);
                    $ex_paratiriseis = stripslashes($_POST['ex_paratiriseis']);


                    $data = array(
                        'exoplismos_id' => NULL,
                        'ex_eidos' => $this->input->post('ex_eidos'),
                        'ex_paratiriseis' => $this->input->post('ex_paratiriseis')
                    );
                    $this->Usermodel->add_Equipment($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');

                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEquipmentEach($exoplismos_id, $sort_by = 'exoplismos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditEquipment($exoplismos_id);
//pagination

            $this->load->view('User/ViewEquipmentEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEquipmentEdit($exoplismos_id, $sort_by = 'exoplismos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditEquipment($exoplismos_id);
//pagination

            $this->load->view('User/ViewEquipmentEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEquipmentEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $exoplismos_id = stripslashes($_POST['exoplismos_id']);

            $ex_eidos = stripslashes($_POST['ex_eidos']);
            $ex_paratiriseis = stripslashes($_POST['ex_paratiriseis']);

            $this->form_validation->set_rules('ex_eidos', 'Είδος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ex_paratiriseis', 'Παρατηρήσεις', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewEquipmentEdit', $data);
            } else {

                $exoplismos_id = stripslashes($_POST['exoplismos_id']);

                $ex_eidos = stripslashes($_POST['ex_eidos']);
                $ex_paratiriseis = stripslashes($_POST['ex_paratiriseis']);


                $data = array(
                    'exoplismos_id' => $exoplismos_id,
                    'ex_eidos' => $this->input->post('ex_eidos'),
                    'ex_paratiriseis' => $this->input->post('ex_paratiriseis')
                );
                $this->Usermodel->edit_Equipment($exoplismos_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewEquipmentDelete($exoplismos_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->EquipmentDelete($exoplismos_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewMonada($sort_by = 'monada_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

//pass messages
            $data['gens'] = $this->Usermodel->getViewMonada();
            $limit = 25;
            $results = $this->Usermodel->searchViewMonada($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewMonada/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('monada');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'monada_id' => 'Α/Α',
                'monada_name' => 'Σχηματισμός/Μονάδα',
                'monada_area' => 'Περιοχή Σχηματισμού/Μονάδας'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewMonada', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewMonadaCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->view('User/ViewMonadaCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateMonada() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $monada_name = stripslashes($_POST['monada_name']);
            $monada_area = stripslashes($_POST['monada_area']);

            $this->form_validation->set_rules('monada_name', 'Ονομασία Σχηματισμού/Μονάδος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('monada_area', 'Περιοχή Σχηματισμού/Μονάδος', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewMonadaCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $monada_name = stripslashes($_POST['monada_name']);
                    $monada_area = stripslashes($_POST['monada_area']);


                    $data = array(
                        'monada_id' => NULL,
                        'monada_name' => $this->input->post('monada_name'),
                        'monada_area' => $this->input->post('monada_area')
                    );
                    $this->Usermodel->add_Monada($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');

                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewMonadaEach($monada_id, $sort_by = 'monada_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditMonada($monada_id);
//pagination

            $this->load->view('User/ViewMonadaEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewMonadaEdit($monada_id, $sort_by = 'monada_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditMonada($monada_id);
//pagination

            $this->load->view('User/ViewMonadaEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewMonadaEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $monada_id = stripslashes($_POST['monada_id']);

            $monada_name = stripslashes($_POST['monada_name']);
            $monada_area = stripslashes($_POST['monada_area']);

            $this->form_validation->set_rules('monada_name', 'Ονομασία Σχηματισμού/Μονάδος', 'trim|required|xss_clean');
            $this->form_validation->set_rules('monada_area', 'Περιοχή Σχηματισμού/Μονάδος', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewMonadaEdit', $data);
            } else {

                $monada_id = stripslashes($_POST['monada_id']);

                $monada_name = stripslashes($_POST['monada_name']);
                $monada_area = stripslashes($_POST['monada_area']);


                $data = array(
                    'monada_id' => $monada_id,
                    'monada_name' => $this->input->post('monada_name'),
                    'monada_area' => $this->input->post('monada_area')
                );
                $this->Usermodel->edit_Monada($monada_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewMonadaDelete($monada_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->MonadaDelete($monada_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewOverMonada($sort_by = 'sximatismos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

//pass messages
            $data['gens'] = $this->Usermodel->getViewOverMonada();
            $limit = 25;
            $results = $this->Usermodel->searchViewOverMonada($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewOverMonada/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('sximatismos');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'sximatismos_id' => 'Α/Α',
                'sximatismos_name' => 'Σχηματισμός',
                'sximatismos_area' => 'Περιοχή Σχηματισμού',
                'monada_name' => 'Μονάδα',
                'monada_area' => 'Περιοχή Μονάδας'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewOverMonada', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewOverMonadaCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->view('User/ViewOverMonadaCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateOverMonada() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $sximatismos_name = stripslashes($_POST['sximatismos_name']);
            $sximatismos_area = stripslashes($_POST['sximatismos_area']);
            $monada_id = stripslashes($_POST['monada_id']);

            $this->form_validation->set_rules('sximatismos_name', 'Ονομασία Σχηματισμού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sximatismos_area', 'Περιοχή Σχηματισμού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('monada_id', 'Ονομασία Μονάδος', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewOverMonadaCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $sximatismos_name = stripslashes($_POST['sximatismos_name']);
                    $sximatismos_area = stripslashes($_POST['sximatismos_area']);
                    $monada_id = stripslashes($_POST['monada_id']);


                    $data = array(
                        'sximatismos_id' => NULL,
                        'sximatismos_name' => $this->input->post('sximatismos_name'),
                        'sximatismos_area' => $this->input->post('sximatismos_area'),
                        'monada_id' => $this->input->post('monada_id')
                    );
                    $this->Usermodel->add_OverMonada($data);
                    $this->session->set_flashdata('success_msg', ''
                            . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                            . '</div>');

                    redirect('User/Home');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewOverMonadaEach($sximatismos_id, $sort_by = 'sximatismos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditOverMonada($sximatismos_id);
//pagination

            $this->load->view('User/ViewOverMonadaEach', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewOverMonadaEdit($sximatismos_id, $sort_by = 'sximatismos_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditOverMonada($sximatismos_id);
//pagination

            $this->load->view('User/ViewOverMonadaEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewOverMonadaEditForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $sximatismos_id = stripslashes($_POST['sximatismos_id']);
            $sximatismos_name = stripslashes($_POST['sximatismos_name']);
            $sximatismos_area = stripslashes($_POST['sximatismos_area']);
            $monada_id = stripslashes($_POST['monada_id']);

            $this->form_validation->set_rules('sximatismos_name', 'Ονομασία Σχηματισμού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sximatismos_area', 'Περιοχή Σχηματισμού', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewOverMonadaEdit', $data);
            } else {

                $sximatismos_id = stripslashes($_POST['sximatismos_id']);
                $sximatismos_name = stripslashes($_POST['sximatismos_name']);
                $sximatismos_area = stripslashes($_POST['sximatismos_area']);
                $monada_id = stripslashes($_POST['monada_id']);


                $data = array(
                    'sximatismos_id' => $sximatismos_id,
                    'sximatismos_name' => $this->input->post('sximatismos_name'),
                    'sximatismos_area' => $this->input->post('sximatismos_area'),
                    'monada_id' => $this->input->post('monada_id')
                );
                $this->Usermodel->edit_OverMonada($sximatismos_id, $data);
                $this->session->set_flashdata('success_msg', ''
                        . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewOverMonadaDelete($sximatismos_id) {

        $this->load->model('Usermodel');
        $this->Usermodel->OverMonadaDelete($sximatismos_id);
        $this->session->set_flashdata('delete_msg', ''
                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                . '</div>');

        redirect('User/Home');
    }

    public function ViewInstanceCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->view('User/ViewInstanceCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SelectInstance() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('personal_details_id', 'Επιλέξτε από το πεδίο   Προσωπικές Πληροφορίες ', 'required|callback_Select_Instance'); // Validating select option field.
            $this->form_validation->set_rules('katanomi_armodiotiton_id', 'Επιλέξτε από το πεδίο   Κατανομή Αρμοδιοτήτων', 'required|callback_Select_ARMODIOTITES'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_sumvantos_id', 'Επιλέξτε από το πεδίο   Κατηγορία Συμβάντος ', 'required|callback_Select_INCIDENT_CATEGORY'); // Validating select option field.
            $this->form_validation->set_rules('eidos_sumvantos_id', 'Επιλέξτε από το πεδίο   Είδος Συμβάντος', 'required|callback_Select_EIDOS_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('eidos_puromaxikou_id', 'Επιλέξτε από το πεδίο   Είδος Πυρομαχικού', 'required|callback_Select_AMMO'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_proteraiotitas_id', 'Επιλέξτε από το πεδίο   Κατηγορία Προτεραιότητας ', 'required|callback_Select_PRIORITY'); // Validating select option field.
            $this->form_validation->set_rules('thesi_simvantos_id', 'Επιλέξτε από το πεδίο   Θέση Συμβάντος ', 'required|callback_Select_THESI_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('document', 'Σήμα Διάθεσης Πυροτεχνουργού', 'trim|required|xss_clean');


            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewInstanceCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $personal_details_id = stripslashes($_POST['personal_details_id']);

                    $data = array(
                        'username' => $this->session->userdata('username'),
                        'personal_details_id' => $this->input->post('personal_details_id'),
                        'katanomi_armodiotiton_id' => $this->input->post('katanomi_armodiotiton_id'),
                        'katigoria_sumvantos_id' => $this->input->post('katigoria_sumvantos_id'),
                        'eidos_sumvantos_id' => $this->input->post('eidos_sumvantos_id'),
                        'eidos_puromaxikou_id' => $this->input->post('eidos_puromaxikou_id'),
                        'katigoria_proteraiotitas_id' => $this->input->post('katigoria_proteraiotitas_id'),
                        'thesi_simvantos_id' => $this->input->post('thesi_simvantos_id'),
                        'document' => $this->input->post('document')
                    );
                    $this->load->view('User/SelectInstance', $data);
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SaveTempInstanceNext() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('personal_details_id', 'Επιλέξτε από το πεδίο   Προσωπικές Πληροφορίες ', 'required|callback_Select_Instance'); // Validating select option field.
            $this->form_validation->set_rules('katanomi_armodiotiton_id', 'Επιλέξτε από το πεδίο   Κατανομή Αρμοδιοτήτων', 'required|callback_Select_ARMODIOTITES'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_sumvantos_id', 'Επιλέξτε από το πεδίο   Κατηγορία Συμβάντος ', 'required|callback_Select_INCIDENT_CATEGORY'); // Validating select option field.
            $this->form_validation->set_rules('eidos_sumvantos_id', 'Επιλέξτε από το πεδίο   Είδος Συμβάντος', 'required|callback_Select_EIDOS_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('eidos_puromaxikou_id', 'Επιλέξτε από το πεδίο   Είδος Πυρομαχικού', 'required|callback_Select_AMMO'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_proteraiotitas_id', 'Επιλέξτε από το πεδίο   Κατηγορία Προτεραιότητας ', 'required|callback_Select_PRIORITY'); // Validating select option field.
            $this->form_validation->set_rules('thesi_simvantos_id', 'Επιλέξτε από το πεδίο   Θέση Συμβάντος ', 'required|callback_Select_THESI_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('document', 'Σήμα Διάθεσης Πυροτεχνουργού', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/SaveInstance', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $this->load->helper('date');
                    $now = time();
                    $sha_peristatiko_id = sha1($now);

                    // Call the SOAP method
                    $peristatiko_id = $sha_peristatiko_id;
                    $personal_details_id = $this->input->post('personal_details_id');
                    $katanomi_armodiotiton_id = $this->input->post('katanomi_armodiotiton_id');
                    $katigoria_sumvantos_id = $this->input->post('katigoria_sumvantos_id');
                    $eidos_sumvantos_id = $this->input->post('eidos_sumvantos_id');
                    $eidos_puromaxikou_id = $this->input->post('eidos_puromaxikou_id');
                    $katigoria_proteraiotitas_id = $this->input->post('katigoria_proteraiotitas_id');
                    $thesi_simvantos_id = $this->input->post('thesi_simvantos_id');
                    $document = $this->input->post('document');
                    $ps_date = '2016-01-01';
                    $ps_topos = '*... απαιτείται επεξεργασία ...*';
                    $ps_ora_enarxis = '00:00:00';
                    $ps_ora_lixis = '00:00:00';
                    $ao_nsn = '*... απαιτείται επεξεργασία ...*';
                    $merida = '*... απαιτείται επεξεργασία ...*';
                    $quantity = '*... απαιτείται επεξεργασία ...*';
                    $perigrafi = '*... απαιτείται επεξεργασία ...*';
                    $sn = '*... απαιτείται επεξεργασία ...*';
                    $ao_nsn_prl = '*... απαιτείται επεξεργασία ...*';
                    $merida_prl = '*... απαιτείται επεξεργασία ...*';
                    $perigrafi_prl = '*... απαιτείται επεξεργασία ...*';
                    $ao_nsn_rock_mis_assistant = '*... απαιτείται επεξεργασία ...*';
                    $merida_rock_mis_assistant = '*... απαιτείται επεξεργασία ...*';
                    $perigrafi_rock_mis_assistant = '*... απαιτείται επεξεργασία ...*';
                    $egatastasis_ktiria = '*... απαιτείται επεξεργασία ...*';
                    $kairos = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_ekav = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_elas = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_limeniko = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_pyrosvestiki = '*... απαιτείται επεξεργασία ...*';
                    $anagnorisi = '*... απαιτείται επεξεργασία ...*';
                    $exoudeterosi = '*... απαιτείται επεξεργασία ...*';
                    $perisillogi = '*... απαιτείται επεξεργασία ...*';
                    $metafora = '*... απαιτείται επεξεργασία ...*';
                    $katastrofi = '*... απαιτείται επεξεργασία ...*';
                    $elegxos_estias = '*... απαιτείται επεξεργασία ...*';
                    $paratiriseis = '*... απαιτείται επεξεργασία ...*';
                    $zimies = '*... απαιτείται επεξεργασία ...*';
                    $epikefalis = '*... απαιτείται επεξεργασία ...*';
                    $status_id = 2;
                    $peristatiko_key_notes = '';


                    $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        // At this point, you know the call that follows will fail
                    }
                    // Call the SOAP method
                    $result = $client->call('TempInstance', array(
                        'peristatiko_id' => $peristatiko_id,
                        'personal_details_id' => $personal_details_id,
                        'katanomi_armodiotiton_id' => $katanomi_armodiotiton_id,
                        'katigoria_sumvantos_id' => $katigoria_sumvantos_id,
                        'eidos_sumvantos_id' => $eidos_sumvantos_id,
                        'eidos_puromaxikou_id' => $eidos_puromaxikou_id,
                        'katigoria_proteraiotitas_id' => $katigoria_proteraiotitas_id,
                        'thesi_simvantos_id' => $thesi_simvantos_id,
                        'document' => $document,
                        'ps_date' => $ps_date,
                        'ps_topos' => $ps_topos,
                        'ps_ora_enarxis' => $ps_ora_enarxis,
                        'ps_ora_lixis' => $ps_ora_lixis,
                        'ao_nsn' => $ao_nsn,
                        'merida' => $merida,
                        'quantity' => $quantity,
                        'perigrafi' => $perigrafi,
                        'sn' => $sn,
                        'ao_nsn_prl' => $ao_nsn_prl,
                        'merida_prl' => $merida_prl,
                        'perigrafi_prl' => $perigrafi_prl,
                        'ao_nsn_rock_mis_assistant' => $ao_nsn_rock_mis_assistant,
                        'merida_rock_mis_assistant' => $merida_rock_mis_assistant,
                        'perigrafi_rock_mis_assistant' => $perigrafi_rock_mis_assistant,
                        'egatastasis_ktiria' => $egatastasis_ktiria,
                        'kairos' => $kairos,
                        'topikes_arxes_ekav' => $topikes_arxes_ekav,
                        'topikes_arxes_elas' => $topikes_arxes_elas,
                        'topikes_arxes_limeniko' => $topikes_arxes_limeniko,
                        'topikes_arxes_pyrosvestiki' => $topikes_arxes_pyrosvestiki,
                        'anagnorisi' => $anagnorisi,
                        'exoudeterosi' => $exoudeterosi,
                        'perisillogi' => $perisillogi,
                        'metafora' => $metafora,
                        'katastrofi' => $katastrofi,
                        'elegxos_estias' => $elegxos_estias,
                        'paratiriseis' => $paratiriseis,
                        'zimies' => $zimies,
                        'status_id' => $status_id,
                        'epikefalis' => $epikefalis,
                        'peristatiko_key_notes' => $peristatiko_key_notes
                    ));
                    // Check for a fault
                    if ($client->fault) {
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        print_r($result);
                    } else {
                        // Check for errors
                        $error = $client->getError();
                        if ($error) {
                            // Display the error
                            $error = $this->session->set_flashdata('edit_msg', ''
                                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                    . '</div>');
                        } else {
                            // Display the result
                            $this->session->set_flashdata('success_msg', ''
                                    . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                                    . '</div>');
                            redirect('User/Home');
                        }
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SaveInstanceNext() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $this->form_validation->set_rules('personal_details_id', 'Επιλέξτε από το πεδίο   Προσωπικές Πληροφορίες ', 'required|callback_Select_Instance'); // Validating select option field.
            $this->form_validation->set_rules('katanomi_armodiotiton_id', 'Επιλέξτε από το πεδίο   Κατανομή Αρμοδιοτήτων', 'required|callback_Select_ARMODIOTITES'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_sumvantos_id', 'Επιλέξτε από το πεδίο   Κατηγορία Συμβάντος ', 'required|callback_Select_INCIDENT_CATEGORY'); // Validating select option field.
            $this->form_validation->set_rules('eidos_sumvantos_id', 'Επιλέξτε από το πεδίο   Είδος Συμβάντος', 'required|callback_Select_EIDOS_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('eidos_puromaxikou_id', 'Επιλέξτε από το πεδίο   Είδος Πυρομαχικού', 'required|callback_Select_AMMO'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_proteraiotitas_id', 'Επιλέξτε από το πεδίο   Κατηγορία Προτεραιότητας ', 'required|callback_Select_PRIORITY'); // Validating select option field.
            $this->form_validation->set_rules('thesi_simvantos_id', 'Επιλέξτε από το πεδίο   Θέση Συμβάντος ', 'required|callback_Select_THESI_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('document', 'Σήμα Διάθεσης Πυροτεχνουργού', 'trim|required|xss_clean');

            $this->form_validation->set_rules('ps_date', 'Ημερομηνία', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_topos', 'Περιοχή Δράσης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_enarxis', 'Ώρα Έναρξης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_lixis', 'Ώρα Λήξης', 'trim|required|xss_clean');



            $this->form_validation->set_rules('ao_nsn', 'Αριθμός Ονομαστικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida', 'Μερίδα Πυρομαχικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('quantity', 'Ποσότητα Ανευρεθέντων Πυρομαχικών', 'trim|required|is_natural|xss_clean');
            $this->form_validation->set_rules('perigrafi', 'Περιγραφή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sn', 'Σειριακός Αριθμός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ao_nsn_prl', 'Αριθμός Ονομαστικού Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_prl', 'Μερίδα Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perigrafi_prl', 'Περιγραφή Πυροσωλήνα', 'trim|required|xss_clean');

            $this->form_validation->set_rules('ao_nsn_rock_mis_assistant', 'Αριθμός Ονομαστικού Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_rock_mis_assistant', 'Μερίδα Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perigrafi_rock_mis_assistant', 'Περιγραφή Κινητήρα', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $this->load->view('User/SelectInstanceNext', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $this->load->helper('date');
                    $now = time();
                    $sha_peristatiko_id = sha1($now);

                    // Call the SOAP method
                    $peristatiko_id = $sha_peristatiko_id;
                    $personal_details_id = $this->input->post('personal_details_id');
                    $katanomi_armodiotiton_id = $this->input->post('katanomi_armodiotiton_id');
                    $katigoria_sumvantos_id = $this->input->post('katigoria_sumvantos_id');
                    $eidos_sumvantos_id = $this->input->post('eidos_sumvantos_id');
                    $eidos_puromaxikou_id = $this->input->post('eidos_puromaxikou_id');
                    $katigoria_proteraiotitas_id = $this->input->post('katigoria_proteraiotitas_id');
                    $thesi_simvantos_id = $this->input->post('thesi_simvantos_id');
                    $document = $this->input->post('document');
                    $ps_date = $this->input->post('ps_date');
                    $ps_topos = $this->input->post('ps_topos');
                    $ps_ora_enarxis = $this->input->post('ps_ora_enarxis');
                    $ps_ora_lixis = $this->input->post('ps_ora_lixis');
                    $ao_nsn = $this->input->post('ao_nsn');
                    $merida = $this->input->post('merida');
                    $quantity = $this->input->post('quantity');
                    $perigrafi = $this->input->post('perigrafi');
                    $sn = $this->input->post('sn');
                    $ao_nsn_prl = $this->input->post('ao_nsn_prl');
                    $merida_prl = $this->input->post('merida_prl');
                    $perigrafi_prl = $this->input->post('perigrafi_prl');
                    $ao_nsn_rock_mis_assistant = $this->input->post('ao_nsn_rock_mis_assistant');
                    $merida_rock_mis_assistant = $this->input->post('merida_rock_mis_assistant');
                    $perigrafi_rock_mis_assistant = $this->input->post('perigrafi_rock_mis_assistant');
                    $egatastasis_ktiria = '*... απαιτείται επεξεργασία ...*';
                    $kairos = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_ekav = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_elas = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_limeniko = '*... απαιτείται επεξεργασία ...*';
                    $topikes_arxes_pyrosvestiki = '*... απαιτείται επεξεργασία ...*';
                    $anagnorisi = '*... απαιτείται επεξεργασία ...*';
                    $exoudeterosi = '*... απαιτείται επεξεργασία ...*';
                    $perisillogi = '*... απαιτείται επεξεργασία ...*';
                    $metafora = '*... απαιτείται επεξεργασία ...*';
                    $katastrofi = '*... απαιτείται επεξεργασία ...*';
                    $elegxos_estias = '*... απαιτείται επεξεργασία ...*';
                    $paratiriseis = '*... απαιτείται επεξεργασία ...*';
                    $zimies = '*... απαιτείται επεξεργασία ...*';
                    $epikefalis = '*... απαιτείται επεξεργασία ...*';
                    $status_id = 2;
                    $peristatiko_key_notes = '';


                    $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        // At this point, you know the call that follows will fail
                    }
                    // Call the SOAP method
                    $result = $client->call('TempInstance', array(
                        'peristatiko_id' => $peristatiko_id,
                        'personal_details_id' => $personal_details_id,
                        'katanomi_armodiotiton_id' => $katanomi_armodiotiton_id,
                        'katigoria_sumvantos_id' => $katigoria_sumvantos_id,
                        'eidos_sumvantos_id' => $eidos_sumvantos_id,
                        'eidos_puromaxikou_id' => $eidos_puromaxikou_id,
                        'katigoria_proteraiotitas_id' => $katigoria_proteraiotitas_id,
                        'thesi_simvantos_id' => $thesi_simvantos_id,
                        'document' => $document,
                        'ps_date' => $ps_date,
                        'ps_topos' => $ps_topos,
                        'ps_ora_enarxis' => $ps_ora_enarxis,
                        'ps_ora_lixis' => $ps_ora_lixis,
                        'ao_nsn' => $ao_nsn,
                        'merida' => $merida,
                        'quantity' => $quantity,
                        'perigrafi' => $perigrafi,
                        'sn' => $sn,
                        'ao_nsn_prl' => $ao_nsn_prl,
                        'merida_prl' => $merida_prl,
                        'perigrafi_prl' => $perigrafi_prl,
                        'ao_nsn_rock_mis_assistant' => $ao_nsn_rock_mis_assistant,
                        'merida_rock_mis_assistant' => $merida_rock_mis_assistant,
                        'perigrafi_rock_mis_assistant' => $perigrafi_rock_mis_assistant,
                        'egatastasis_ktiria' => $egatastasis_ktiria,
                        'kairos' => $kairos,
                        'topikes_arxes_ekav' => $topikes_arxes_ekav,
                        'topikes_arxes_elas' => $topikes_arxes_elas,
                        'topikes_arxes_limeniko' => $topikes_arxes_limeniko,
                        'topikes_arxes_pyrosvestiki' => $topikes_arxes_pyrosvestiki,
                        'anagnorisi' => $anagnorisi,
                        'exoudeterosi' => $exoudeterosi,
                        'perisillogi' => $perisillogi,
                        'metafora' => $metafora,
                        'katastrofi' => $katastrofi,
                        'elegxos_estias' => $elegxos_estias,
                        'paratiriseis' => $paratiriseis,
                        'zimies' => $zimies,
                        'status_id' => $status_id,
                        'epikefalis' => $epikefalis,
                        'peristatiko_key_notes' => $peristatiko_key_notes
                    ));
                    // Check for a fault
                    if ($client->fault) {
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        print_r($result);
                    } else {
                        // Check for errors
                        $error = $client->getError();
                        if ($error) {
                            // Display the error
                            $error = $this->session->set_flashdata('edit_msg', ''
                                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                    . '</div>');
                        } else {
                            // Display the result
                            $this->session->set_flashdata('success_msg', ''
                                    . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                                    . '</div>');
                            redirect('User/Home');
                        }
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceOneDelete($peristatiko_id) {

        $this->load->model('Usermodel');
        $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
        $error = $client->getError();
        if ($error) {
            // Display the error
            $error = $this->session->set_flashdata('edit_msg', ''
                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                    . 'Η <strong>διαγραφή δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                    . '</div>');
            // At this point, you know the call that follows will fail
        }
        // Call the SOAP method
        $result = $client->call('DeleteInstance', array('peristatiko_id' => $peristatiko_id));
        // Check for a fault
        if ($client->fault) {
            $error = $this->session->set_flashdata('edit_msg', ''
                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                    . 'Η <strong>διαγραφή δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                    . '</div>');
            print_r($result);
        } else {
            // Check for errors
            $error = $client->getError();
            if ($error) {
                // Display the error
                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
            } else {
                // Display the result
                $this->session->set_flashdata('delete_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        }

        //$this->Usermodel->InstanceDelete($peristatiko_id);
    }

    public function SelectInstanceNext() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('personal_details_id', 'Επιλέξτε από το πεδίο   Προσωπικές Πληροφορίες ', 'required|callback_Select_Instance'); // Validating select option field.
            $this->form_validation->set_rules('katanomi_armodiotiton_id', 'Επιλέξτε από το πεδίο   Κατανομή Αρμοδιοτήτων', 'required|callback_Select_ARMODIOTITES'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_sumvantos_id', 'Επιλέξτε από το πεδίο   Κατηγορία Συμβάντος ', 'required|callback_Select_INCIDENT_CATEGORY'); // Validating select option field.
            $this->form_validation->set_rules('eidos_sumvantos_id', 'Επιλέξτε από το πεδίο   Είδος Συμβάντος', 'required|callback_Select_EIDOS_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('eidos_puromaxikou_id', 'Επιλέξτε από το πεδίο   Είδος Πυρομαχικού', 'required|callback_Select_AMMO'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_proteraiotitas_id', 'Επιλέξτε από το πεδίο   Κατηγορία Προτεραιότητας ', 'required|callback_Select_PRIORITY'); // Validating select option field.
            $this->form_validation->set_rules('thesi_simvantos_id', 'Επιλέξτε από το πεδίο   Θέση Συμβάντος ', 'required|callback_Select_THESI_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('document', 'Σήμα Διάθεσης Πυροτεχνουργού', 'trim|required|xss_clean');

            $this->form_validation->set_rules('ps_date', 'Ημερομηνία', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_topos', 'Περιοχή Δράσης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_enarxis', 'Ώρα Έναρξης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_lixis', 'Ώρα Λήξης', 'trim|required|xss_clean');



            $this->form_validation->set_rules('ao_nsn', 'Αριθμός Ονομαστικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida', 'Μερίδα Πυρομαχικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('quantity', 'Ποσότητα Ανευρεθέντων Πυρομαχικών', 'trim|required|is_natural|xss_clean');

            $this->form_validation->set_rules('perigrafi', 'Περιγραφή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sn', 'Σειριακός Αριθμός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ao_nsn_prl', 'Αριθμός Ονομαστικού Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_prl', 'Μερίδα Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perigrafi_prl', 'Περιγραφή Πυροσωλήνα', 'trim|required|xss_clean');

            $this->form_validation->set_rules('ao_nsn_rock_mis_assistant', 'Αριθμός Ονομαστικού Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_rock_mis_assistant', 'Μερίδα Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perigrafi_rock_mis_assistant', 'Περιγραφή Κινητήρα', 'trim|required|xss_clean');

            $data = array(
                'username' => $this->session->userdata('username'),
                'personal_details_id' => $this->input->post('personal_details_id'),
                'katanomi_armodiotiton_id' => $this->input->post('katanomi_armodiotiton_id'),
                'katigoria_sumvantos_id' => $this->input->post('katigoria_sumvantos_id'),
                'eidos_sumvantos_id' => $this->input->post('eidos_sumvantos_id'),
                'eidos_puromaxikou_id' => $this->input->post('eidos_puromaxikou_id'),
                'katigoria_proteraiotitas_id' => $this->input->post('katigoria_proteraiotitas_id'),
                'thesi_simvantos_id' => $this->input->post('thesi_simvantos_id'),
                'document' => $this->input->post('document')
            );


            if ($this->form_validation->run() == FALSE) {

                $data = array(
                    'username' => $this->session->userdata('username'),
                    'personal_details_id' => $this->input->post('personal_details_id'),
                    'katanomi_armodiotiton_id' => $this->input->post('katanomi_armodiotiton_id'),
                    'katigoria_sumvantos_id' => $this->input->post('katigoria_sumvantos_id'),
                    'eidos_sumvantos_id' => $this->input->post('eidos_sumvantos_id'),
                    'eidos_puromaxikou_id' => $this->input->post('eidos_puromaxikou_id'),
                    'katigoria_proteraiotitas_id' => $this->input->post('katigoria_proteraiotitas_id'),
                    'thesi_simvantos_id' => $this->input->post('thesi_simvantos_id'),
                    'document' => $this->input->post('document')
                );
                $data['error'] = $error;

                $this->load->view('User/SelectInstance', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {
                    $personal_details_id = stripslashes($_POST['personal_details_id']);
                    $data = array(
                        'username' => $this->session->userdata('username'),
                        'personal_details_id' => $this->input->post('personal_details_id'),
                        'katanomi_armodiotiton_id' => $this->input->post('katanomi_armodiotiton_id'),
                        'katigoria_sumvantos_id' => $this->input->post('katigoria_sumvantos_id'),
                        'eidos_sumvantos_id' => $this->input->post('eidos_sumvantos_id'),
                        'eidos_puromaxikou_id' => $this->input->post('eidos_puromaxikou_id'),
                        'katigoria_proteraiotitas_id' => $this->input->post('katigoria_proteraiotitas_id'),
                        'thesi_simvantos_id' => $this->input->post('thesi_simvantos_id'),
                        'document' => $this->input->post('document'),
                        'ps_date' => $this->input->post('ps_date'),
                        'ps_topos' => $this->input->post('ps_topos'),
                        'ps_ora_enarxis' => $this->input->post('ps_ora_enarxis'),
                        'ps_ora_lixis' => $this->input->post('ps_ora_lixis'),
                        'ao_nsn' => $this->input->post('ao_nsn'),
                        'merida' => $this->input->post('merida'),
                        'quantity' => $this->input->post('quantity'),
                        'perigrafi' => $this->input->post('perigrafi'),
                        'sn' => $this->input->post('sn'),
                        'ao_nsn_prl' => $this->input->post('ao_nsn_prl'),
                        'merida_prl' => $this->input->post('merida_prl'),
                        'perigrafi_prl' => $this->input->post('perigrafi_prl'),
                        'ao_nsn_rock_mis_assistant' => $this->input->post('ao_nsn_rock_mis_assistant'),
                        'merida_rock_mis_assistant' => $this->input->post('merida_rock_mis_assistant'),
                        'perigrafi_rock_mis_assistant' => $this->input->post('perigrafi_rock_mis_assistant')
                    );
                    $this->load->view('User/SelectInstanceFinish', $data);
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SelectInstanceFinish() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');

//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
            $this->form_validation->set_rules('personal_details_id', 'Επιλέξτε από το πεδίο   Προσωπικές Πληροφορίες ', 'required|callback_Select_Instance'); // Validating select option field.
            $this->form_validation->set_rules('katanomi_armodiotiton_id', 'Επιλέξτε από το πεδίο   Κατανομή Αρμοδιοτήτων', 'required|callback_Select_ARMODIOTITES'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_sumvantos_id', 'Επιλέξτε από το πεδίο   Κατηγορία Συμβάντος ', 'required|callback_Select_INCIDENT_CATEGORY'); // Validating select option field.
            $this->form_validation->set_rules('eidos_sumvantos_id', 'Επιλέξτε από το πεδίο   Είδος Συμβάντος', 'required|callback_Select_EIDOS_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('eidos_puromaxikou_id', 'Επιλέξτε από το πεδίο   Είδος Πυρομαχικού', 'required|callback_Select_AMMO'); // Validating select option field.
            $this->form_validation->set_rules('katigoria_proteraiotitas_id', 'Επιλέξτε από το πεδίο   Κατηγορία Προτεραιότητας ', 'required|callback_Select_PRIORITY'); // Validating select option field.
            $this->form_validation->set_rules('thesi_simvantos_id', 'Επιλέξτε από το πεδίο   Θέση Συμβάντος ', 'required|callback_Select_THESI_INCIDENT'); // Validating select option field.
            $this->form_validation->set_rules('document', 'Σήμα Διάθεσης Πυροτεχνουργού', 'trim|required|xss_clean');

            $this->form_validation->set_rules('ps_date', 'Ημερομηνία', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_topos', 'Περιοχή Δράσης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_enarxis', 'Ώρα Έναρξης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_lixis', 'Ώρα Λήξης', 'trim|required|xss_clean');



            $this->form_validation->set_rules('ao_nsn', 'Αριθμός Ονομαστικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida', 'Μερίδα Πυρομαχικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('quantity', 'Ποσότητα Ανευρεθέντων Πυρομαχικών', 'trim|required|is_natural|xss_clean');
            $this->form_validation->set_rules('perigrafi', 'Περιγραφή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sn', 'Σειριακός Αριθμός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ao_nsn_prl', 'Αριθμός Ονομαστικού Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_prl', 'Μερίδα Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perigrafi_prl', 'Περιγραφή Πυροσωλήνα', 'trim|required|xss_clean');

            $this->form_validation->set_rules('ao_nsn_rock_mis_assistant', 'Αριθμός Ονομαστικού Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_rock_mis_assistant', 'Μερίδα Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perigrafi_rock_mis_assistant', 'Περιγραφή Κινητήρα', 'trim|required|xss_clean');


            $this->form_validation->set_rules('egatastasis_ktiria', 'Εγκαταστάσεις', 'trim|required|xss_clean');
            $this->form_validation->set_rules('kairos', 'Καιρός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('topikes_arxes_ekav', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΚΑΒ', 'required|callback_Select_EKAB'); // Validating select option field.
            $this->form_validation->set_rules('topikes_arxes_elas', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΛΑΣ', 'required|callback_Select_ELAS'); // Validating select option field.
            $this->form_validation->set_rules('topikes_arxes_limeniko', 'Επιλέξτε από το πεδίο   Ύπαρξη Λιμενικού', 'required|callback_Select_LIMENIKO'); // Validating select option field.
            $this->form_validation->set_rules('topikes_arxes_pyrosvestiki', 'Επιλέξτε από το πεδίο   Ύπαρξη Πυροσβεστικής', 'required|callback_Select_PYRROSVESTIKI'); // Validating select option field.


            $this->form_validation->set_rules('anagnorisi', 'Αναγνώριση', 'trim|required|xss_clean');
            $this->form_validation->set_rules('exoudeterosi', 'Εξουδετέρωση', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perisillogi', 'Περισυλλογή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('metafora', 'Μεταφορά', 'trim|required|xss_clean');
            $this->form_validation->set_rules('katastrofi', 'Καταστροφή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('elegxos_estias', 'Έλεγχος Εστίας', 'trim|required|xss_clean');

            $this->form_validation->set_rules('paratiriseis', 'Παρατηρήσεις', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zimies', 'Ζημίες', 'trim|required|xss_clean');

            $this->form_validation->set_rules('epikefalis', 'Επιλέξτε από το πεδίο   Επικεφαλής', 'required|callback_Select_EPIKEFALIS'); // Validating select option field.



            if ($this->form_validation->run() == FALSE) {

                $data = array(
                    'username' => $this->session->userdata('username'),
                    'personal_details_id' => $this->input->post('personal_details_id'),
                    'katanomi_armodiotiton_id' => $this->input->post('katanomi_armodiotiton_id'),
                    'katigoria_sumvantos_id' => $this->input->post('katigoria_sumvantos_id'),
                    'eidos_sumvantos_id' => $this->input->post('eidos_sumvantos_id'),
                    'eidos_puromaxikou_id' => $this->input->post('eidos_puromaxikou_id'),
                    'katigoria_proteraiotitas_id' => $this->input->post('katigoria_proteraiotitas_id'),
                    'thesi_simvantos_id' => $this->input->post('thesi_simvantos_id'),
                    'document' => $this->input->post('document'),
                    'ps_date' => $this->input->post('ps_date'),
                    'ps_topos' => $this->input->post('ps_topos'),
                    'ps_ora_enarxis' => $this->input->post('ps_ora_enarxis'),
                    'ps_ora_lixis' => $this->input->post('ps_ora_lixis'),
                    'ao_nsn' => $this->input->post('ao_nsn'),
                    'merida' => $this->input->post('merida'),
                    'quantity' => $this->input->post('quantity'),
                    'perigrafi' => $this->input->post('perigrafi'),
                    'sn' => $this->input->post('sn'),
                    'ao_nsn_prl' => $this->input->post('ao_nsn_prl'),
                    'merida_prl' => $this->input->post('merida_prl'),
                    'perigrafi_prl' => $this->input->post('perigrafi_prl'),
                    'ao_nsn_rock_mis_assistant' => $this->input->post('ao_nsn_rock_mis_assistant'),
                    'merida_rock_mis_assistant' => $this->input->post('merida_rock_mis_assistant'),
                    'perigrafi_rock_mis_assistant' => $this->input->post('perigrafi_rock_mis_assistant')
                );
                $data['error'] = $error;
                $this->load->view('User/SelectInstanceFinish', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $this->load->helper('date');
                    $now = time();
                    $sha_peristatiko_id = sha1($now);

                    // Call the SOAP method
                    $peristatiko_id = $sha_peristatiko_id;
                    $personal_details_id = $this->input->post('personal_details_id');
                    $katanomi_armodiotiton_id = $this->input->post('katanomi_armodiotiton_id');
                    $katigoria_sumvantos_id = $this->input->post('katigoria_sumvantos_id');
                    $eidos_sumvantos_id = $this->input->post('eidos_sumvantos_id');
                    $eidos_puromaxikou_id = $this->input->post('eidos_puromaxikou_id');
                    $katigoria_proteraiotitas_id = $this->input->post('katigoria_proteraiotitas_id');
                    $thesi_simvantos_id = $this->input->post('thesi_simvantos_id');
                    $document = $this->input->post('document');
                    $ps_date = $this->input->post('ps_date');
                    $ps_topos = $this->input->post('ps_topos');
                    $ps_ora_enarxis = $this->input->post('ps_ora_enarxis');
                    $ps_ora_lixis = $this->input->post('ps_ora_lixis');
                    $ao_nsn = $this->input->post('ao_nsn');
                    $merida = $this->input->post('merida');
                    $quantity = $this->input->post('quantity');
                    $perigrafi = $this->input->post('perigrafi');
                    $sn = $this->input->post('sn');
                    $ao_nsn_prl = $this->input->post('ao_nsn_prl');
                    $merida_prl = $this->input->post('merida_prl');
                    $perigrafi_prl = $this->input->post('perigrafi_prl');
                    $ao_nsn_rock_mis_assistant = $this->input->post('ao_nsn_rock_mis_assistant');
                    $merida_rock_mis_assistant = $this->input->post('merida_rock_mis_assistant');
                    $perigrafi_rock_mis_assistant = $this->input->post('perigrafi_rock_mis_assistant');
                    $egatastasis_ktiria = $this->input->post('egatastasis_ktiria');
                    $kairos = $this->input->post('kairos');
                    $topikes_arxes_ekav = $this->input->post('topikes_arxes_ekav');
                    $topikes_arxes_elas = $this->input->post('topikes_arxes_elas');
                    $topikes_arxes_limeniko = $this->input->post('topikes_arxes_limeniko');
                    $topikes_arxes_pyrosvestiki = $this->input->post('topikes_arxes_pyrosvestiki');
                    $anagnorisi = $this->input->post('anagnorisi');
                    $exoudeterosi = $this->input->post('exoudeterosi');
                    $perisillogi = $this->input->post('perisillogi');
                    $metafora = $this->input->post('metafora');
                    $katastrofi = $this->input->post('katastrofi');
                    $elegxos_estias = $this->input->post('elegxos_estias');
                    $paratiriseis = $this->input->post('paratiriseis');
                    $zimies = $this->input->post('zimies');
                    $epikefalis = $this->input->post('epikefalis');
                    $status_id = 1;
                    $peristatiko_key_notes = '';


                    $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        // At this point, you know the call that follows will fail
                    }
                    // Call the SOAP method
                    $result = $client->call('TempInstance', array(
                        'peristatiko_id' => $peristatiko_id,
                        'personal_details_id' => $personal_details_id,
                        'katanomi_armodiotiton_id' => $katanomi_armodiotiton_id,
                        'katigoria_sumvantos_id' => $katigoria_sumvantos_id,
                        'eidos_sumvantos_id' => $eidos_sumvantos_id,
                        'eidos_puromaxikou_id' => $eidos_puromaxikou_id,
                        'katigoria_proteraiotitas_id' => $katigoria_proteraiotitas_id,
                        'thesi_simvantos_id' => $thesi_simvantos_id,
                        'document' => $document,
                        'ps_date' => $ps_date,
                        'ps_topos' => $ps_topos,
                        'ps_ora_enarxis' => $ps_ora_enarxis,
                        'ps_ora_lixis' => $ps_ora_lixis,
                        'ao_nsn' => $ao_nsn,
                        'merida' => $merida,
                        'quantity' => $quantity,
                        'perigrafi' => $perigrafi,
                        'sn' => $sn,
                        'ao_nsn_prl' => $ao_nsn_prl,
                        'merida_prl' => $merida_prl,
                        'perigrafi_prl' => $perigrafi_prl,
                        'ao_nsn_rock_mis_assistant' => $ao_nsn_rock_mis_assistant,
                        'merida_rock_mis_assistant' => $merida_rock_mis_assistant,
                        'perigrafi_rock_mis_assistant' => $perigrafi_rock_mis_assistant,
                        'egatastasis_ktiria' => $egatastasis_ktiria,
                        'kairos' => $kairos,
                        'topikes_arxes_ekav' => $topikes_arxes_ekav,
                        'topikes_arxes_elas' => $topikes_arxes_elas,
                        'topikes_arxes_limeniko' => $topikes_arxes_limeniko,
                        'topikes_arxes_pyrosvestiki' => $topikes_arxes_pyrosvestiki,
                        'anagnorisi' => $anagnorisi,
                        'exoudeterosi' => $exoudeterosi,
                        'perisillogi' => $perisillogi,
                        'metafora' => $metafora,
                        'katastrofi' => $katastrofi,
                        'elegxos_estias' => $elegxos_estias,
                        'paratiriseis' => $paratiriseis,
                        'zimies' => $zimies,
                        'status_id' => $status_id,
                        'epikefalis' => $epikefalis,
                        'peristatiko_key_notes' => $peristatiko_key_notes
                    ));
                    // Check for a fault
                    if ($client->fault) {
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        print_r($result);
                    } else {
                        // Check for errors
                        $error = $client->getError();
                        if ($error) {
                            // Display the error
                            $error = $this->session->set_flashdata('edit_msg', ''
                                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                    . '</div>');
                        } else {

                            // Display the result
                            $this->session->set_flashdata('success_msg', ''
                                    . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Παρακαλώ επιλέξτε τα <strong>εκρηκτικά</strong> που χρησιμοποιήσατε!Διαφορετικά πατήστε "ΠΑΡΑΛΕΙΨΗ" '
                                    . '</div>');
                            redirect('User/ViewInstanceExplosiveCreationForm', 'refresh');
                        }
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateInstance() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');

//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('egatastasis_ktiria', 'Εγκαταστάσεις', 'trim|required|xss_clean');
            $this->form_validation->set_rules('kairos', 'Καιρός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('topikes_arxes_ekav', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΚΑΒ', 'required|callback_Select_EKAB'); // Validating select option field.
            $this->form_validation->set_rules('topikes_arxes_elas', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΛΑΣ', 'required|callback_Select_ELAS'); // Validating select option field.
            $this->form_validation->set_rules('topikes_arxes_limeniko', 'Επιλέξτε από το πεδίο   Ύπαρξη Λιμενικού', 'required|callback_Select_LIMENIKO'); // Validating select option field.
            $this->form_validation->set_rules('topikes_arxes_pyrosvestiki', 'Επιλέξτε από το πεδίο   Ύπαρξη Πυροσβεστικής', 'required|callback_Select_PYRROSVESTIKI'); // Validating select option field.


            $this->form_validation->set_rules('anagnorisi', 'Αναγνώριση', 'trim|required|xss_clean');
            $this->form_validation->set_rules('exoudeterosi', 'Εξουδετέρωση', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perisillogi', 'Περισυλλογή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('metafora', 'Μεταφορά', 'trim|required|xss_clean');
            $this->form_validation->set_rules('katastrofi', 'Καταστροφή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('elegxos_estias', 'Έλεγχος Εστίας', 'trim|required|xss_clean');

            $this->form_validation->set_rules('paratiriseis', 'Παρατηρήσεις', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zimies', 'Ζημίες', 'trim|required|xss_clean');

            $this->form_validation->set_rules('epikefalis', 'Επιλέξτε από το πεδίο   Επικεφαλής', 'required|callback_Select_EPIKEFALIS'); // Validating select option field.



            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/SelectiveInstanceFinish', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {

                    $personal_details_id = stripslashes($_POST['personal_details_id']);
                    $this->load->helper('date');
                    $now = time();

                    $sha_peristatiko_id = sha1($now);
                    $data = array(
                        'peristatiko_id' => $sha_peristatiko_id,
                        'personal_details_id' => $this->input->post('personal_details_id'),
                        'katanomi_armodiotiton_id' => $this->input->post('katanomi_armodiotiton_id'),
                        'katigoria_sumvantos_id' => $this->input->post('katigoria_sumvantos_id'),
                        'eidos_sumvantos_id' => $this->input->post('eidos_sumvantos_id'),
                        'eidos_puromaxikou_id' => $this->input->post('eidos_puromaxikou_id'),
                        'katigoria_proteraiotitas_id' => $this->input->post('katigoria_proteraiotitas_id'),
                        'thesi_simvantos_id' => $this->input->post('thesi_simvantos_id'),
                        'document' => $this->input->post('document'),
                        'ps_date' => $this->input->post('ps_date'),
                        'ps_topos' => $this->input->post('ps_topos'),
                        'ps_ora_enarxis' => $this->input->post('ps_ora_enarxis'),
                        'ps_ora_lixis' => $this->input->post('ps_ora_lixis'),
                        'ao_nsn' => $this->input->post('ao_nsn'),
                        'merida' => $this->input->post('merida'),
                        'quantity' => $this->input->post('quantity'),
                        'perigrafi' => $this->input->post('perigrafi'),
                        'sn' => $this->input->post('sn'),
                        'ao_nsn_prl' => $this->input->post('ao_nsn_prl'),
                        'merida_prl' => $this->input->post('merida_prl'),
                        'perigrafi_prl' => $this->input->post('perigrafi_prl'),
                        'ao_nsn_rock_mis_assistant' => $this->input->post('ao_nsn_rock_mis_assistant'),
                        'merida_rock_mis_assistant' => $this->input->post('merida_rock_mis_assistant'),
                        'perigrafi_rock_mis_assistant' => $this->input->post('perigrafi_rock_mis_assistant'),
                        'egatastasis_ktiria' => $this->input->post('egatastasis_ktiria'),
                        'kairos' => $this->input->post('kairos'),
                        'topikes_arxes_ekav' => $this->input->post('topikes_arxes_ekav'),
                        'topikes_arxes_elas' => $this->input->post('topikes_arxes_elas'),
                        'topikes_arxes_limeniko' => $this->input->post('topikes_arxes_limeniko'),
                        'topikes_arxes_pyrosvestiki' => $this->input->post('topikes_arxes_pyrosvestiki'),
                        'anagnorisi' => $this->input->post('anagnorisi'),
                        'exoudeterosi' => $this->input->post('exoudeterosi'),
                        'perisillogi' => $this->input->post('perisillogi'),
                        'metafora' => $this->input->post('metafora'),
                        'katastrofi' => $this->input->post('katastrofi'),
                        'elegxos_estias' => $this->input->post('elegxos_estias'),
                        'paratiriseis' => $this->input->post('paratiriseis'),
                        'zimies' => $this->input->post('zimies'),
                        'epikefalis' => $this->input->post('epikefalis'),
                        'status_id' => 1,
                        'peristatiko_key_notes' => ''
                    );
                    $this->Usermodel->add_Instance($data);
                    redirect('User/ViewInstanceExplosiveCreationForm', 'refresh');
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_EKAB($topikes_arxes_ekav) {

        if ($topikes_arxes_ekav == "-1") {
            $this->form_validation->set_message('Select_EKAB', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΚΑΒ');
            return false;
        } else {
            return true;
        }
    }

    function Select_ELAS($topikes_arxes_elas) {

        if ($topikes_arxes_elas == "-1") {
            $this->form_validation->set_message('Select_ELAS', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΛΑΣ');
            return false;
        } else {
            return true;
        }
    }

    function Select_LIMENIKO($topikes_arxes_limeniko) {

        if ($topikes_arxes_limeniko == "-1") {
            $this->form_validation->set_message('Select_LIMENIKO', 'Επιλέξτε από το πεδίο   Ύπαρξη Λιμενικού');
            return false;
        } else {
            return true;
        }
    }

    function Select_PYRROSVESTIKI($topikes_arxes_pyrosvestiki) {

        if ($topikes_arxes_pyrosvestiki == "-1") {
            $this->form_validation->set_message('Select_PYRROSVESTIKI', 'Επιλέξτε από το πεδίο   Ύπαρξη Πυροσβεστική');
            return false;
        } else {
            return true;
        }
    }

    function Select_EPIKEFALIS($epikefalis) {

        if ($epikefalis == "-1") {
            $this->form_validation->set_message('Select_EPIKEFALIS', 'Επιλέξτε από το πεδίο   Επικεφαλής');
            return false;
        } else {
            return true;
        }
    }

    function Select_ARMODIOTITES($katanomi_armodiotiton_id) {

        if ($katanomi_armodiotiton_id == "-1") {
            $this->form_validation->set_message('Select_ARMODIOTITES', 'Επιλέξτε από το πεδίο   Κατανομή Αρμοδιοτήτων');
            return false;
        } else {
            return true;
        }
    }

    function Select_INFOINCIDENT($plirofories_sumvantos_id) {

        if ($plirofories_sumvantos_id == "-1") {
            $this->form_validation->set_message('Select_INFOINCIDENT', 'Επιλέξτε από το πεδίο   Πληροφορίες Συμβάντος');
            return false;
        } else {
            return true;
        }
    }

    function Select_INCIDENT_CATEGORY($katigoria_sumvantos_id) {

        if ($katigoria_sumvantos_id == "-1") {
            $this->form_validation->set_message('Select_INCIDENT_CATEGORY', 'Επιλέξτε από το πεδίο   Κατηγορία Συμβάντος');
            return false;
        } else {
            return true;
        }
    }

    function Select_EIDOS_INCIDENT($eidos_sumvantos_id) {

        if ($eidos_sumvantos_id == "-1") {
            $this->form_validation->set_message('Select_EIDOS_INCIDENT', 'Επιλέξτε από το πεδίο   Είδος Συμβάντος');
            return false;
        } else {
            return true;
        }
    }

    function Select_AMMO($eidos_puromaxikou_id) {

        if ($eidos_puromaxikou_id == "-1") {
            $this->form_validation->set_message('Select_AMMO', 'Επιλέξτε από το πεδίο   Είδος Πυρομαχικού');
            return false;
        } else {
            return true;
        }
    }

    function Select_PRIORITY($katigoria_proteraiotitas_id) {

        if ($katigoria_proteraiotitas_id == "-1") {
            $this->form_validation->set_message('Select_PRIORITY', 'Επιλέξτε από το πεδίο   Κατηγορία Προτεραιότητας');
            return false;
        } else {
            return true;
        }
    }

    function Select_THESI_INCIDENT($thesi_simvantos_id) {

        if ($thesi_simvantos_id == "-1") {
            $this->form_validation->set_message('Select_THESI_INCIDENT', 'Επιλέξτε από το πεδίο   Θέση Συμβάντος');
            return false;
        } else {
            return true;
        }
    }

    public function ViewInstanceKEYSubmit($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYSubmit();
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYSubmit($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYSubmit/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'pd_username' => 'Πυροτεχνουργός',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceOneKEYSubmit($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOneKEY($peristatiko_id);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktikaKEY($peristatiko_id);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismosKEY($peristatiko_id);

            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOneKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktikaKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceOneKEY/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;


            $this->load->view('User/ViewInstanceOneKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEY($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEY();
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEY($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEY/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'pd_username' => 'Πυροτεχνουργός',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceStartKEY($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $status_id = 1;
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewKEYStatistics($status_id);
            $limit = 10;

            $results = $this->Usermodel->searchViewKEYStatistics($status_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceStartKEY/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'pd_username' => 'Πυροτεχνουργός',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceStartKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceSaveKEY($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $status_id = 2;
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewKEYStatistics($status_id);
            $limit = 10;

            $results = $this->Usermodel->searchViewKEYStatistics($status_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceSaveKEY/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'pd_username' => 'Πυροτεχνουργός',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceSaveKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYKEY($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $status_id = 3;
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewKEYStatistics($status_id);
            $limit = 10;

            $results = $this->Usermodel->searchViewKEYStatistics($status_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYKEY/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'pd_username' => 'Πυροτεχνουργός',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceSubmitKEY($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $status_id = 4;
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewKEYStatistics($status_id);
            $limit = 10;

            $results = $this->Usermodel->searchViewKEYStatistics($status_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceSubmitKEY/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'pd_username' => 'Πυροτεχνουργός',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceSubmitKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceOneKEY($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOneKEY($peristatiko_id);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktikaKEY($peristatiko_id);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismosKEY($peristatiko_id);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotosKEY($peristatiko_id);

            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOneKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktikaKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];

//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceOneKEY/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;


            $this->load->view('User/ViewInstanceOneKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UpdateStatusKEY() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $peristatiko_id = stripslashes($_POST['peristatiko_id']);
            $status_id = stripslashes($_POST['status_id']);
            $peristatiko_key_notes = stripslashes($_POST['peristatiko_key_notes']);


            $this->form_validation->set_rules('status_id', 'Επιλέξτε από το πεδίο   Status', 'required|callback_Select_EditSTATUSKEY'); // Validating select option field.

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewInstanceOneKEY', $data);
            } else {

                $peristatiko_id = $this->input->post('peristatiko_id');
                $status_id = $this->input->post('status_id');
                $peristatiko_key_notes = $this->input->post('peristatiko_key_notes');


                $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                $error = $client->getError();
                if ($error) {
                    // Display the error
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    // At this point, you know the call that follows will fail
                }
                // Call the SOAP method
                $result = $client->call('UpdateStatusKEY', array('peristatiko_id' => $peristatiko_id, 'status_id' => $status_id, 'peristatiko_key_notes' => $peristatiko_key_notes));
                // Check for a fault
                if ($client->fault) {
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    print_r($result);
                } else {
                    // Check for errors
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                    } else {
                        // Display the result
                        $this->session->set_flashdata('success_msg', ''
                                . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                                . '</div>');
                        redirect('User/Home');
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_EditSTATUSKEY($status_id) {

        if ($status_id == "-1") {
            $this->form_validation->set_message('Select_EditSTATUSKEY', 'Επιλέξτε από το πεδίο   Status');
            return false;
        } else {
            return true;
        }
    }

    public function ViewInstanceKEYStatistics($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYStatistics();
            $limit = 10;
            $data['stats'] = $this->Usermodel->getViewInstanceKEYUserStatistics();
            $results = $this->Usermodel->searchViewInstanceKEYUserStatistics($sort_by, $sort_order, $limit, $offset);
            $data['stat'] = $results['rows'];

            $results = $this->Usermodel->searchViewInstanceKEYStatistics($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYStatistics/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'pd_username' => 'Πυροτεχνουργός',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstance($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstance($username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstance($username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstance/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            //$config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstance', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceStartStatus($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 1;
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceStatus($status_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceStatus($status_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceStartStatus/$sort_by/$sort_order");
            $config['total_rows'] = $results['num_rows'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceStartStatus', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UserStatisticsStart($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 1;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');

            $this->load->view('User/ViewStatisticsStart', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UserStatisticsSave($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 1;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');

            $this->load->view('User/ViewStatisticsSave', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UserStatisticsKEY($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 1;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');

            $this->load->view('User/ViewStatisticsKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UserStatisticsSubmit($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 1;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');

            $this->load->view('User/ViewStatisticsSubmit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceSaveStatus($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 2;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceStatus($status_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceStatus($status_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceSaveStatus/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceSaveStatus', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYStatus($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 3;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceStatus($status_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceStatus($status_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYStatus/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYStatus', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceSubmitStatus($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceStatus($status_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceStatus($status_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceSubmitStatus/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceSubmitStatus', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceACode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 1;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceACode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceACode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceBCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 2;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceBCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceBCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceCCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 3;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceCCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceCCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceDCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 4;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceDCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceDCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceECode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 5;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceECode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceECode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceFCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 6;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceFCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceFCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceHCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 7;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceHCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceHCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceGCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 8;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceGCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceGCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceICode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 9;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceICode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceICode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 10;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceLCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 11;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceLCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceLCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceMCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 12;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceMCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceMCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceNCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 13;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceNCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceNCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYACode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 1;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYACode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYACode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYBCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 2;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYBCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYBCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYCCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 3;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYCCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYCCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYDCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 4;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYDCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYDCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYECode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 5;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYECode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYECode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYFCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 6;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYFCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYFCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYHCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 7;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYHCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYHCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYGCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 8;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYGCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYGCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYICode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 9;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYICode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYICode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYKCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 10;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYKCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYKCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYLCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 11;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYLCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYLCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYMCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 12;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYMCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYMCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceKEYNCode($sort_by = 'peristatiko_id', $sort_order = 'desc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {

            $status_id = 4;
            $eidos_sumvantos_id = 13;

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username);
            $limit = 10;

            $results = $this->Usermodel->searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceKEYNCode/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης'
            );
            $data['fieldsStatus'] = array(
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewInstanceKEYNCode', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceExplosiveCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');

            $this->load->view('User/ViewInstanceExplosiveCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateInstanceExplosive() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('peristatiko_id', 'Επιλέξτε από το πεδίο   Περιστατικό ', 'required|callback_Select_Peristatiko'); // Validating select option field.
            $this->form_validation->set_rules('ekriktika_lot_id', 'Επιλέξτε από το πεδίο   Εκρηκτικά', 'required|callback_Select_EkriktikaLot'); // Validating select option field.
//$this->form_validation->set_rules('ekr_posotika', 'Ποσότητα', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewInstanceExplosiveCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {
//                    $data = array(
//                        'peristatiko_ekriktika_id' => NULL,
//                        'peristatiko_id' => $this->input->post('peristatiko_id'),
//                        'ekriktika_id' => $this->input->post('ekriktika_id'),
//                        'ekr_posotika' => $this->input->post('ekr_posotika')
//                    );


                    $peristatiko_id = $this->input->post('peristatiko_id');
                    $ekriktika_lot_id = $this->input->post('ekriktika_lot_id');
                    $ekr_posotika = $this->input->post('ekr_posotika');

                    $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        // At this point, you know the call that follows will fail
                    }
                    // Call the SOAP method
                    $result = $client->call('InstanceExplosive', array('peristatiko_id' => $peristatiko_id, 'ekriktika_lot_id' => $ekriktika_lot_id, 'ekr_posotika' => $ekr_posotika));
                    // Check for a fault
                    if ($client->fault) {
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        print_r($result);
                    } else {
                        // Check for errors
                        $error = $client->getError();
                        if ($error) {
                            // Display the error
                            $error = $this->session->set_flashdata('edit_msg', ''
                                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                    . '</div>');
                        } else {
                            // Display the result
                            $this->session->set_flashdata('success_msg', ''
                                    . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Παρακαλώ επιλέξτε τα <strong>εκρηκτικά</strong> που χρησιμοποιήσατε!Διαφορετικά πατήστε "ΠΑΡΑΛΕΙΨΗ" '
                                    . '</div>');
                            redirect('User/ViewInstanceExplosiveCreationForm', 'refresh');
                        }
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_Peristatiko($peristatiko_id) {

        if ($peristatiko_id == "-1") {
            $this->form_validation->set_message('Select_Peristatiko', 'Επιλέξτε από το πεδίο   Περιστατικό');
            return false;
        } else {
            return true;
        }
    }

    function Select_EkriktikaLot($ekriktika_lot_id) {

        if ($ekriktika_lot_id == "-1") {
            $this->form_validation->set_message('Select_EkriktikaLot', 'Επιλέξτε από το πεδίο   Εκρηκτικά');
            return false;
        } else {
            return true;
        }
    }

    public function ViewInstanceEquipmentCreationForm() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->model('Usermodel');

            $this->load->view('User/ViewInstanceEquipmentCreationForm', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateInstanceEquipment($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $this->form_validation->set_rules('peristatiko_id', 'Επιλέξτε από το πεδίο   Περιστατικό ', 'required|callback_Select_PeristatikoExo'); // Validating select option field.
            $this->form_validation->set_rules('exoplismos_id', 'Επιλέξτε από το πεδίο   Εξοπλισμός', 'required|callback_Select_Equipment'); // Validating select option field.
//$this->form_validation->set_rules('exo_posotika', 'Ποσότητα', 'trim|required|xss_clean');

            $peristatiko_id = $this->input->post('peristatiko_id');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewInstanceEquipmentCreationForm', $data);
            } else {
                if ($this->form_validation->run() == TRUE) {
//                    foreach ($this->input->post('exoplismos_id') as $exoplismos_id) {
//                        $data = array(
//                            'peristatiko_exoplismos_id' => NULL,
//                            'peristatiko_id' => $this->input->post('peristatiko_id'),
//                            'exoplismos_id' => $exoplismos_id
////                            'exo_posotika' => $this->input->post('exo_posotika')
//                        );
//                        $this->Usermodel->add_InstanceEquipment($data);
//                    }
                    $peristatiko_id = $this->input->post('peristatiko_id');
                    $exoplismos_id = $this->input->post('exoplismos_id');
                    $exo_posotika = $this->input->post('exo_posotika');
                    ;

                    $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        // At this point, you know the call that follows will fail
                    }
                    // Call the SOAP method
                    $result = $client->call('InstanceEquipment', array('peristatiko_id' => $peristatiko_id, 'exoplismos_id' => $exoplismos_id, 'exo_posotika' => $exo_posotika));
                    // Check for a fault
                    if ($client->fault) {
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                        print_r($result);
                    } else {
                        // Check for errors
                        $error = $client->getError();
                        if ($error) {
                            // Display the error
                            $error = $this->session->set_flashdata('edit_msg', ''
                                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                    . '</div>');
                        } else {
                            // Display the result
                            $this->session->set_flashdata('success_msg', ''
                                    . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                    . 'Παρακαλώ επιλέξτε τον <strong>εξοπλισμό</strong> που χρησιμοποιήσατε!Διαφορετικά πατήστε "ΠΑΡΑΛΕΙΨΗ" '
                                    . '</div>');
                            $this->load->model('Usermodel');
                            $username = $this->session->userdata('username');
                            $data['gens'] = $this->Usermodel->getViewInstanceOne($peristatiko_id, $username);
                            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktika($peristatiko_id, $username);
                            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismos($peristatiko_id, $username);
                            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotos($peristatiko_id, $username);

                            $limit = 100;

                            $results = $this->Usermodel->searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
                            $data['gen'] = $results['rows'];
                            $data['num_result'] = $results['num_rows'];

                            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
                            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
                            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

                            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
                            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
                            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

                            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
                            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
                            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];

                            redirect('User/ViewInstanceEquipmentCreationForm', 'refresh');
                            //$this->load->view('User/ViewInstanceEquipmentCreationForm', $data);
//                            $this->session->set_flashdata('success_msg', ''
//                                    . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
//                                    . 'Παρακαλώ επιλέξτε τον <strong>εξοπλισμό</strong> που χρησιμοποιήσατε!Διαφορετικά πατήστε "ΠΑΡΑΛΕΙΨΗ" '
//                                    . '</div>');
//                            redirect('User/Home', 'refresh');
                        }
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_PeristatikoExo($peristatiko_id) {

        if ($peristatiko_id == "-1") {
            $this->form_validation->set_message('Select_PeristatikoExo', 'Επιλέξτε από το πεδίο   Περιστατικό');
            return false;
        } else {
            return true;
        }
    }

    function Select_Equipment($exoplismos_id) {

        if ($exoplismos_id == "-1") {
            $this->form_validation->set_message('Select_Equipment', 'Επιλέξτε από το πεδίο   Εκρηκτικά');
            return false;
        } else {
            return true;
        }
    }

    public function ViewInstanceOne($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOne($peristatiko_id, $username);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktika($peristatiko_id, $username);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismos($peristatiko_id, $username);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotos($peristatiko_id, $username);

            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];

//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceOne/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;


            $this->load->view('User/ViewInstanceOne', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceOneEquipment($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOne($peristatiko_id, $username);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktika($peristatiko_id, $username);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismos($peristatiko_id, $username);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotos($peristatiko_id, $username);

            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];

//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceOneEquipment/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;


            $this->load->view('User/ViewInstanceOneEquipment', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceOneEquipmentDelete($peristatikoEquipment) {
        $this->load->model('Usermodel');
        $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
        $error = $client->getError();
        if ($error) {
            // Display the error
            $error = $this->session->set_flashdata('edit_msg', ''
                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                    . 'Η <strong>διαγραφή δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                    . '</div>');
            // At this point, you know the call that follows will fail
        }
        // Call the SOAP method
        $result = $client->call('DeleteEquipmentInstance', array('peristatikoEquipment' => $peristatikoEquipment));
        // Check for a fault
        if ($client->fault) {
            $error = $this->session->set_flashdata('edit_msg', ''
                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                    . 'Η <strong>διαγραφή δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                    . '</div>');
            print_r($result);
        } else {
            // Check for errors
            $error = $client->getError();
            if ($error) {
                // Display the error
                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
            } else {
                // Display the result
                $this->session->set_flashdata('delete_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        }
    }

//        $this->load->model('Usermodel');
//        $this->Usermodel->InstanceEquipmentDelete($peristatikoEquipment);
//        $this->session->set_flashdata('delete_msg', ''
//                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
//                . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
//                . '</div>');
//        redirect('User/Home');
//    }

    public function ViewInstanceOneExplosiveDelete($peristatikoExplosive) {

        $this->load->model('Usermodel');
        $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
        $error = $client->getError();
        if ($error) {
            // Display the error
            $error = $this->session->set_flashdata('edit_msg', ''
                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                    . 'Η <strong>διαγραφή δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                    . '</div>');
            // At this point, you know the call that follows will fail
        }
        // Call the SOAP method
        $result = $client->call('DeleteExplosiveInstance', array('peristatikoExplosive' => $peristatikoExplosive));
        // Check for a fault
        if ($client->fault) {
            $error = $this->session->set_flashdata('edit_msg', ''
                    . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                    . 'Η <strong>διαγραφή δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                    . '</div>');
            print_r($result);
        } else {
            // Check for errors
            $error = $client->getError();
            if ($error) {
                // Display the error
                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
            } else {
                // Display the result
                $this->session->set_flashdata('delete_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>διαγραφή</strong> πραγματοποιήθηκε με επιτυχία!'
                        . '</div>');

                redirect('User/Home');
            }
        }
    }

    public function ViewInstanceOneExplosive($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOne($peristatiko_id, $username);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktika($peristatiko_id, $username);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismos($peristatiko_id, $username);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotos($peristatiko_id, $username);

            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];

//pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewInstanceOneExplosive/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('peristatiko');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'document' => 'Σήμα Διάθεσης',
                'ps_date' => 'Ημερομηνία',
                'ps_topos' => 'Περιοχή Δράσης',
                'status_var' => 'Κατάσταση Αίτησης'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;


            $this->load->view('User/ViewInstanceOneExplosive', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewInstanceEdit($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getEditInstance($peristatiko_id);
//pagination

            $this->load->view('User/ViewInstanceEdit', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UpdateInstanceFinish() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';
//            $this->form_validation->set_rules('personal_details_id', 'Επιλέξτε από το πεδίο   Προσωπικές Πληροφορίες ', 'required|callback_Select_Instance'); // Validating select option field.
//            $this->form_validation->set_rules('katanomi_armodiotiton_id', 'Επιλέξτε από το πεδίο   Κατανομή Αρμοδιοτήτων', 'required|callback_Select_ARMODIOTITES'); // Validating select option field.
//            $this->form_validation->set_rules('katigoria_sumvantos_id', 'Επιλέξτε από το πεδίο   Κατηγορία Συμβάντος ', 'required|callback_Select_INCIDENT_CATEGORY'); // Validating select option field.
//            $this->form_validation->set_rules('eidos_sumvantos_id', 'Επιλέξτε από το πεδίο   Είδος Συμβάντος', 'required|callback_Select_EIDOS_INCIDENT'); // Validating select option field.
//            $this->form_validation->set_rules('eidos_puromaxikou_id', 'Επιλέξτε από το πεδίο   Είδος Πυρομαχικού', 'required|callback_Select_AMMO'); // Validating select option field.
//            $this->form_validation->set_rules('katigoria_proteraiotitas_id', 'Επιλέξτε από το πεδίο   Κατηγορία Προτεραιότητας ', 'required|callback_Select_PRIORITY'); // Validating select option field.
//            $this->form_validation->set_rules('thesi_simvantos_id', 'Επιλέξτε από το πεδίο   Θέση Συμβάντος ', 'required|callback_Select_THESI_INCIDENT'); // Validating select option field.

            $this->form_validation->set_rules('ps_date', 'Ημερομηνία', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_topos', 'Περιοχή Δράσης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_enarxis', 'Ώρα Έναρξης', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ps_ora_lixis', 'Ώρα Λήξης', 'trim|required|xss_clean');


            $this->form_validation->set_rules('ao_nsn', 'Αριθμός Ονομαστικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida', 'Μερίδα Πυρομαχικού', 'trim|required|xss_clean');
            $this->form_validation->set_rules('quantity', 'Ποσότητα Ανευρεθέντων Πυρομαχικών', 'trim|required|xss_clean');

            $this->form_validation->set_rules('perigrafi', 'Περιγραφή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sn', 'Σειριακός Αριθμός', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ao_nsn_prl', 'Αριθμός Ονομαστικού Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_prl', 'Μερίδα Πυροσωλήνα', 'trim|required|xss_clean');

            $this->form_validation->set_rules('perigrafi_prl', 'Περιγραφή Πυροσωλήνα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('ao_nsn_rock_mis_assistant', 'Αριθμός Ονομαστικού Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('merida_rock_mis_assistant', 'Μερίδα Κινητήρα', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perigrafi_rock_mis_assistant', 'Περιγραφή Κινητήρα', 'trim|required|xss_clean');


            $this->form_validation->set_rules('egatastasis_ktiria', 'Εγκαταστάσεις', 'trim|required|xss_clean');
            $this->form_validation->set_rules('kairos', 'Καιρός', 'trim|required|xss_clean');
//$this->form_validation->set_rules('topikes_arxes_ekav', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΚΑΒ', 'required|callback_Select_EKAB'); // Validating select option field.
//$this->form_validation->set_rules('topikes_arxes_elas', 'Επιλέξτε από το πεδίο   Ύπαρξη ΕΛΑΣ', 'required|callback_Select_ELAS'); // Validating select option field.
//$this->form_validation->set_rules('topikes_arxes_limeniko', 'Επιλέξτε από το πεδίο   Ύπαρξη Λιμενικού', 'required|callback_Select_LIMENIKO'); // Validating select option field.
//$this->form_validation->set_rules('topikes_arxes_pyrosvestiki', 'Επιλέξτε από το πεδίο   Ύπαρξη Πυροσβεστικής', 'required|callback_Select_PYRROSVESTIKI'); // Validating select option field.


            $this->form_validation->set_rules('anagnorisi', 'Αναγνώριση', 'trim|required|xss_clean');
            $this->form_validation->set_rules('exoudeterosi', 'Εξουδετέρωση', 'trim|required|xss_clean');
            $this->form_validation->set_rules('perisillogi', 'Περισυλλογή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('metafora', 'Μεταφορά', 'trim|required|xss_clean');
            $this->form_validation->set_rules('katastrofi', 'Καταστροφή', 'trim|required|xss_clean');
            $this->form_validation->set_rules('elegxos_estias', 'Έλεγχος Εστίας', 'trim|required|xss_clean');

            $this->form_validation->set_rules('paratiriseis', 'Παρατηρήσεις', 'trim|required|xss_clean');
            $this->form_validation->set_rules('zimies', 'Ζημίες', 'trim|required|xss_clean');

//$this->form_validation->set_rules('epikefalis', 'Επιλέξτε από το πεδίο   Επικεφαλής', 'required|callback_Select_EPIKEFALIS'); // Validating select option field.




            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;

                $error = $this->session->set_flashdata('edit_msg', ''
                        . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                        . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                        . '</div>');
                $data['edit'] = null;

                $this->load->view('User/ViewInstanceEdit', $data);
            } else {


                // Call the SOAP method
                $peristatiko_id = $this->input->post('peristatiko_id');
                $personal_details_id = $this->input->post('personal_details_id');
                $katanomi_armodiotiton_id = $this->input->post('katanomi_armodiotiton_id');
                $katigoria_sumvantos_id = $this->input->post('katigoria_sumvantos_id');
                $eidos_sumvantos_id = $this->input->post('eidos_sumvantos_id');
                $eidos_puromaxikou_id = $this->input->post('eidos_puromaxikou_id');
                $katigoria_proteraiotitas_id = $this->input->post('katigoria_proteraiotitas_id');
                $thesi_simvantos_id = $this->input->post('thesi_simvantos_id');
                $document = $this->input->post('document');
                $ps_date = $this->input->post('ps_date');
                $ps_topos = $this->input->post('ps_topos');
                $ps_ora_enarxis = $this->input->post('ps_ora_enarxis');
                $ps_ora_lixis = $this->input->post('ps_ora_lixis');
                $ao_nsn = $this->input->post('ao_nsn');
                $merida = $this->input->post('merida');
                $quantity = $this->input->post('quantity');
                $perigrafi = $this->input->post('perigrafi');
                $sn = $this->input->post('sn');
                $ao_nsn_prl = $this->input->post('ao_nsn_prl');
                $merida_prl = $this->input->post('merida_prl');
                $perigrafi_prl = $this->input->post('perigrafi_prl');
                $ao_nsn_rock_mis_assistant = $this->input->post('ao_nsn_rock_mis_assistant');
                $merida_rock_mis_assistant = $this->input->post('merida_rock_mis_assistant');
                $perigrafi_rock_mis_assistant = $this->input->post('perigrafi_rock_mis_assistant');
                $egatastasis_ktiria = $this->input->post('egatastasis_ktiria');
                $kairos = $this->input->post('kairos');
                $topikes_arxes_ekav = $this->input->post('topikes_arxes_ekav');
                $topikes_arxes_elas = $this->input->post('topikes_arxes_elas');
                $topikes_arxes_limeniko = $this->input->post('topikes_arxes_limeniko');
                $topikes_arxes_pyrosvestiki = $this->input->post('topikes_arxes_pyrosvestiki');
                $anagnorisi = $this->input->post('anagnorisi');
                $exoudeterosi = $this->input->post('exoudeterosi');
                $perisillogi = $this->input->post('perisillogi');
                $metafora = $this->input->post('metafora');
                $katastrofi = $this->input->post('katastrofi');
                $elegxos_estias = $this->input->post('elegxos_estias');
                $paratiriseis = $this->input->post('paratiriseis');
                $zimies = $this->input->post('zimies');
                $epikefalis = $this->input->post('epikefalis');
                $status_id = $this->input->post('status_id');

                $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                $error = $client->getError();
                if ($error) {
                    // Display the error
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    // At this point, you know the call that follows will fail
                }
                // Call the SOAP method
                $result = $client->call('EditInstance', array(
                    'peristatiko_id' => $peristatiko_id,
                    'ps_date' => $ps_date,
                    'ps_topos' => $ps_topos,
                    'ps_ora_enarxis' => $ps_ora_enarxis,
                    'ps_ora_lixis' => $ps_ora_lixis,
                    'ao_nsn' => $ao_nsn,
                    'merida' => $merida,
                    'quantity' => $quantity,
                    'perigrafi' => $perigrafi,
                    'sn' => $sn,
                    'ao_nsn_prl' => $ao_nsn_prl,
                    'merida_prl' => $merida_prl,
                    'perigrafi_prl' => $perigrafi_prl,
                    'ao_nsn_rock_mis_assistant' => $ao_nsn_rock_mis_assistant,
                    'merida_rock_mis_assistant' => $merida_rock_mis_assistant,
                    'perigrafi_rock_mis_assistant' => $perigrafi_rock_mis_assistant,
                    'egatastasis_ktiria' => $egatastasis_ktiria,
                    'kairos' => $kairos,
                    'topikes_arxes_ekav' => $topikes_arxes_ekav,
                    'topikes_arxes_elas' => $topikes_arxes_elas,
                    'topikes_arxes_limeniko' => $topikes_arxes_limeniko,
                    'topikes_arxes_pyrosvestiki' => $topikes_arxes_pyrosvestiki,
                    'anagnorisi' => $anagnorisi,
                    'exoudeterosi' => $exoudeterosi,
                    'perisillogi' => $perisillogi,
                    'metafora' => $metafora,
                    'katastrofi' => $katastrofi,
                    'elegxos_estias' => $elegxos_estias,
                    'paratiriseis' => $paratiriseis,
                    'zimies' => $zimies,
                    'epikefalis' => $epikefalis,
                    'status_id' => $status_id
                ));
                // Check for a fault
                if ($client->fault) {
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    print_r($result);
                } else {
                    // Check for errors
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>επεξεργασία δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                    } else {

                        // Display the result
                        $this->session->set_flashdata('success_msg', ''
                                . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Παρακαλώ επιλέξτε τα <strong>εκρηκτικά</strong> που χρησιμοποιήσατε!Διαφορετικά πατήστε "ΠΑΡΑΛΕΙΨΗ" '
                                . '</div>');
                        redirect('User/ViewInstanceExplosiveCreationForm', 'refresh');
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UpdateStatus() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $user = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            $this->load->library('form_validation');
            $error = '';

            $peristatiko_id = stripslashes($_POST['peristatiko_id']);
            $status_id = stripslashes($_POST['status_id']);
            $peristatiko_key_notes = stripslashes($_POST['peristatiko_key_notes']);


            $this->form_validation->set_rules('status_id', 'Επιλέξτε από το πεδίο   Status', 'required|callback_Select_EditSTATUS'); // Validating select option field.

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/ViewInstanceOne', $data);
            } else {

                $peristatiko_id = $this->input->post('peristatiko_id');
                $status_id = $this->input->post('status_id');
                $peristatiko_key_notes = $this->input->post('peristatiko_key_notes');


                $this->load->library('nusoap');
                    $client = new nusoap_client('http://localhost/ato/server.php');
                    
                $error = $client->getError();
                if ($error) {
                    // Display the error
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    // At this point, you know the call that follows will fail
                }
                // Call the SOAP method
                $result = $client->call('UpdateStatus', array('peristatiko_id' => $peristatiko_id, 'status_id' => $status_id, 'peristatiko_key_notes' => $peristatiko_key_notes));
                // Check for a fault
                if ($client->fault) {
                    $error = $this->session->set_flashdata('edit_msg', ''
                            . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                            . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                            . '</div>');
                    print_r($result);
                } else {
                    // Check for errors
                    $error = $client->getError();
                    if ($error) {
                        // Display the error
                        $error = $this->session->set_flashdata('edit_msg', ''
                                . '<div class="alert alert-danger" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση δεν</strong>  πραγματοποιήθηκε με επιτυχία! Προσπαθήστε ξανά!'
                                . '</div>');
                    } else {
                        // Display the result
                        $this->session->set_flashdata('success_msg', ''
                                . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>καταχώρηση</strong> πραγματοποιήθηκε με επιτυχία!'
                                . '</div>');
                        redirect('User/Home');
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_EditSTATUS($status_id) {

        if ($status_id == "-1") {
            $this->form_validation->set_message('Select_EditSTATUS', 'Επιλέξτε από το πεδίο   Status');
            return false;
        } else {
            return true;
        }
    }

    public function Uploadphotos() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['username'] = $this->session->userdata('username');
            $this->load->view('User/Upload_form', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function do_upload() {

        if ($this->session->userdata('userIsLoggedIn')) {

            $this->load->library('form_validation');
            $this->load->model('upload_model');
            $this->load->model('Usermodel');

            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
            $this->form_validation->set_rules('peristatiko_id', 'Επιλέξτε από το πεδίο   Περιστατικό ', 'required|callback_Select_PeristatikoPhoto'); // Validating select option field.
            $user = $this->session->userdata('username');

            $this->load->library('form_validation');
            $error = '';

            $peristatiko_id = stripslashes($_POST['peristatiko_id']);
            $this->form_validation->set_rules('peristatiko_id', 'Επιλέξτε από το πεδίο   Περιστατικο', 'required|callback_Select_PeristatikoPhoto'); // Validating select option field.

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/Upload_form', $data);
            } else {

                $peristatiko_id = $this->input->post('peristatiko_id');
                if ($this->input->post('upload')) {
                    $config['upload_path'] = './Downloads/Images/real/';
                    $config['charset'] = "UTF-8";
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '10240';
                    $config['max_width'] = '10240';
                    $config['max_height'] = '7680';
                    $config['file_name'] = time();
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload()) {
                        $data['error'] = $this->upload->display_errors();
                        $this->load->view('User/Upload_form', $data);
                    } else {
                        $data = $this->upload->data();
                        $this->thumb($data);
//                        $file = array(
//                            'img_name' => $data['raw_name'],
//                            'peristatiko_id' => $peristatiko_id,
//                            'thumb_name' => $data['raw_name'] . '_thumb',
//                            'ext' => $data['file_ext'],
//                            'upload_date' => time()
//                        );
                        $file = array(
                            'img_name' => time(),
                            'peristatiko_id' => $peristatiko_id,
                            'thumb_name' => time() . '_thumb',
                            'ext' => $data['file_ext'],
                            'upload_date' => time()
                        );

                        $this->upload_model->add_image($file);
                        $data = array('upload_data' => $this->upload->data());
                        $this->session->set_flashdata('success_msg', ''
                                . '<div class="alert alert-success" style="font-size: 24px;" style="padding-left: 40%; width: 70%;">'
                                . 'Η <strong>προσθήκη φωτογραφιών</strong> πραγματοποιήθηκε με επιτυχία!'
                                . '</div>');
                        redirect('User/Home');
                    }
                }
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function thumb($data) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $data['full_path'];
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 275;
        $config['height'] = 250;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }

    function Select_PeristatikoPhoto($peristatiko_id) {

        if ($peristatiko_id == "-1") {
            $this->form_validation->set_message('Select_PeristatikoPhoto', 'Επιλέξτε από το πεδίο   Περιστατικό');
            return false;
        } else {
            return true;
        }
    }

    public function Photos() {
        $data['username'] = $this->session->userdata('username');
        $this->load->view('User/public_all_photos', $data);
    }

    public function CreateExplosiveReport($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            $data['username'] = $this->session->userdata('username');

            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOne($peristatiko_id, $username);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktika($peristatiko_id, $username);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismos($peristatiko_id, $username);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotos($peristatiko_id, $username);

            $data['per'] = $this->Usermodel->getViewPeristatiko($peristatiko_id, $username);



            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];


            $this->load->view('pdf/explosiveReport', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateStatisticReport($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            $data['username'] = $this->session->userdata('username');

            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOne($peristatiko_id, $username);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktika($peristatiko_id, $username);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismos($peristatiko_id, $username);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotos($peristatiko_id, $username);

            $data['per'] = $this->Usermodel->getViewPeristatiko($peristatiko_id, $username);



            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];


            $this->load->view('pdf/StatisticReport', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewAllUsers($sort_by = 'personal_details_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');

            $this->load->model('Usermodel');

            //pass messages
            $data['gens'] = $this->Usermodel->getViewAllUsers();
            $limit = 50;
            $results = $this->Usermodel->searchViewAllUsers($sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];
            //pagination
            $this->load->library('pagination');
            $config = array();
            $config['base_url'] = site_url("User/ViewAllUsers/$sort_by/$sort_order");
            $config['total_rows'] = $data['num_result'];
            $config['per_page'] = $limit;
            $config['first_link'] = '&laquo; Αρχική';
            $config['last_link'] = 'Τελευταία &raquo;';
            $config['total_rows'] = $this->db->count_all('personal_details');
            $config['uri_segment'] = 5;
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['fields'] = array(
                'pd_vathmos' => 'Βαθμός',
                'pd_onoma' => 'Όνομα',
                'pd_eponimo' => 'Επώνυμο',
                'pd_am' => 'ΑΜ',
                'monada_name' => 'Μονάδα',
                'eod' => 'Απόφοιτος EOD',
                'pd_username' => 'Username',
                'choosenWord' => 'Λεκτικό Χρήστη'
            );
            $data['sort_by'] = $sort_by;
            $data['sort_order'] = $sort_order;
            $this->load->view('User/ViewAllUsers', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function ViewPersonalDetailsTotal($personal_details_id, $sort_by = 'personal_details_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            $this->load->model('Usermodel');

//pass messages
            $data['edit'] = $this->Usermodel->getPersonalDetailsTotal($personal_details_id);
//pagination

            $this->load->view('User/ViewPersonalDetailsTotal', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateStatisticReportKEY($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            $data['username'] = $this->session->userdata('username');

            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOneKEY($peristatiko_id);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktikaKEY($peristatiko_id);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismosKEY($peristatiko_id);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotosKEY($peristatiko_id);

            $data['per'] = $this->Usermodel->getViewPeristatikoKEY($peristatiko_id);



            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOneKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktikaKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];


            $this->load->view('pdf/StatisticReportKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function CreateExplosiveReportKEY($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            $data['username'] = $this->session->userdata('username');

            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            $data['peristatiko'] = $peristatiko_id;

            $this->load->model('Usermodel');
            $username = $this->session->userdata('username');
//pass messages
            $data['gens'] = $this->Usermodel->getViewInstanceOneKEY($peristatiko_id);
            $data['gensEkriktika'] = $this->Usermodel->getViewInstanceOneEkriktikaKEY($peristatiko_id);
            $data['gensExoplismos'] = $this->Usermodel->getViewInstanceOneExoplismosKEY($peristatiko_id);
            $data['gensPhotos'] = $this->Usermodel->getViewInstanceOnePhotosKEY($peristatiko_id);

            $data['per'] = $this->Usermodel->getViewPeristatikoKEY($peristatiko_id);



            $limit = 100;

            $results = $this->Usermodel->searchViewInstanceOneKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['gen'] = $results['rows'];
            $data['num_result'] = $results['num_rows'];

            $resultsEkriktika = $this->Usermodel->searchViewInstanceOneEkriktikaKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
            $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

            $resultsExoplismos = $this->Usermodel->searchViewInstanceOneExoplismosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
            $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];

            $resultsPhotos = $this->Usermodel->searchViewInstanceOnePhotosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset);
            $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
            $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];


            $this->load->view('pdf/explosiveReportKEY', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function PersonalStatistics($personal_details_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            $data['username'] = $this->session->userdata('username');

            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            $data['personal_details'] = $personal_details_id;

            $this->load->model('Usermodel');
            $this->load->view('pdf/PersonalStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function TotalStatistics($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            $this->load->model('Usermodel');

            $data['gens'] = $this->Usermodel->getUserTotalStatistics();
            $this->load->view('pdf/TotalStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function Statistics() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['username'] = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['uid'] = $this->session->userdata('uid');


            //user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            //load User home page

            $this->load->view('User/Statistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SearchStatistics($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->library('form_validation');
            $error = '';
            //$this->form_validation->set_rules('text_search', 'Λέξεις προς Αναζήτηση Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_before', 'Ημερομηνία Έναρξης Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_after', 'Ημερομηνία Λήξης Περιστατικού ', 'trim|required|xss_clean');


//            $anagnorisi = $this->input->post('anagnorisi');
//            $exoudeterosi = $this->input->post('exoudeterosi');
//            $katastrofi = $this->input->post('katastrofi');
//            $area = $this->input->post('area');
//            $description = $this->input->post('description');
            $date_before = $this->input->post('date_before');
            $date_after = $this->input->post('date_after');


            $this->load->model('Usermodel');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/Statistics', $data);
            } else {

                $data['gens'] = $this->Usermodel->getStatistics($date_before, $date_after);
                $limit = 100;
                $this->load->model('Usermodel');
                $results = $this->Usermodel->SearchInstancesStatistics($date_before, $date_after, $sort_by, $sort_order, $limit, $offset);
                $data['gen'] = $results['rows'];
                $data['num_result'] = $results['num_rows'];
//pagination
                $this->load->library('pagination');
                $config = array();
                $config['base_url'] = site_url("User/SearchStatistics/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_result'];
                $config['per_page'] = $limit;
                $config['first_link'] = '&laquo; Αρχική';
                $config['last_link'] = 'Τελευταία &raquo;';
                $config['total_rows'] = $this->db->count_all('peristatiko');
                $config['uri_segment'] = 5;
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                $data['fields'] = array(
                    'peristatiko_id' => 'Α/Α',
                    'ps_date' => 'Ημερομηνία',
                    'ps_topos' => 'Περιοχή',
                    'perigrafi' => 'Περιγραφή'
                );
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;


                $data['date_before'] = $date_before;
                $data['date_after'] = $date_after;

                $this->load->view('User/SearchStatisticsResults', $data);
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function date_valid($date) {
        $parts = explode("/", $date);
        if (count($parts) == 3) {
            if (checkdate($parts[1], $parts[0], $parts[2])) {
                return TRUE;
            }
        }
        $this->form_validation->set_message('date_valid', 'Η ημερομηνία θα πρέπει να είναι της μορφης yyyy-mm-dd');
        return false;
    }

    public function TotalSearchStatistics($date_before, $date_after, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');

            $this->load->model('Usermodel');


            $data['date_before'] = $date_before;
            $data['date_after'] = $date_after;

            $data['gens'] = $this->Usermodel->getTotalSearchStatistics($date_before, $date_after);
            $this->load->view('pdf/TotalSearchStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UnitStatistics() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['username'] = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['uid'] = $this->session->userdata('uid');


            //user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            //load User home page

            $this->load->view('User/UnitStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SearchUnitStatistics($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->library('form_validation');
            $error = '';

            //$this->form_validation->set_rules('text_search', 'Λέξεις προς Αναζήτηση Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('monada_id', 'Επιλέξτε τη Μονάδα ', 'required|callback_Select_Unit'); // Validating select option field.
            $this->form_validation->set_rules('date_before', 'Ημερομηνία Έναρξης Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_after', 'Ημερομηνία Λήξης Περιστατικού ', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/UnitStatistics', $data);
            } else {
                $monada_id = $this->input->post('monada_id');
                $date_before = $this->input->post('date_before');
                $date_after = $this->input->post('date_after');
                $this->load->model('Usermodel');

                $data['gens'] = $this->Usermodel->getUnitStatistics($monada_id, $date_before, $date_after);
                $limit = 100;
                $this->load->model('Usermodel');
                $results = $this->Usermodel->SearchInstancesUnitStatistics($monada_id, $date_before, $date_after, $sort_by, $sort_order, $limit, $offset);
                $data['gen'] = $results['rows'];
                $data['num_result'] = $results['num_rows'];
//pagination

                $this->load->library('pagination');
                $config = array();
                $config['base_url'] = site_url("User/SearchUnitStatistics/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_result'];
                $config['per_page'] = $limit;
                $config['first_link'] = '&laquo; Αρχική';
                $config['last_link'] = 'Τελευταία &raquo;';
                $config['total_rows'] = $this->db->count_all('peristatiko');
                $config['uri_segment'] = 5;
                $this->pagination->initialize($config);
                $data['monada_id'] = $monada_id;
                $data['date_before'] = $date_before;
                $data['date_after'] = $date_after;
                $data['pagination'] = $this->pagination->create_links();
                $data['fields'] = array(
                    'peristatiko_id' => 'Α/Α',
                    'ps_date' => 'Ημερομηνία',
                    'ps_topos' => 'Περιοχή',
                    'perigrafi' => 'Περιγραφή',
                    'pd_vathmos' => 'Βαθμός',
                    'pd_eponimo' => 'Επώνυμο',
                    'pd_onoma' => 'Όνομα',
                    'pd_am' => 'ΑΜ'
                );
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;
                $this->load->view('User/SearchUnitStatisticsResults', $data);
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_Unit($monada_id) {
        if ($monada_id == "-1") {
            $this->form_validation->set_message('Select_Unit', 'Επιλέξτε από το πεδίο   Μονάδα/Σχηματισμός');
            return false;
        } else {
            return true;
        }
    }

    public function TotalUnitStatistics($monada_id, $date_before, $date_after, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');

            $this->load->model('Usermodel');
            $data['monada_id'] = $monada_id;
            $data['date_before'] = $date_before;
            $data['date_after'] = $date_after;
            $data['gens'] = $this->Usermodel->getUnitTotalStatistics($monada_id, $date_before, $date_after);
            $this->load->view('pdf/TotalUnitStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function UserStatistics() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['username'] = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['uid'] = $this->session->userdata('uid');


            //user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            //load User home page

            $this->load->view('User/UserStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SearchUserStatistics($sort_by = 'personal_details_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->library('form_validation');
            $error = '';

            //$this->form_validation->set_rules('text_search', 'Λέξεις προς Αναζήτηση Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('personal_details_id', 'Επιλέξτε έναν πυροτεχνουργό ', 'required|callback_Select_User'); // Validating select option field.
            $this->form_validation->set_rules('date_before', 'Ημερομηνία Έναρξης Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_after', 'Ημερομηνία Λήξης Περιστατικού ', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/UserStatistics', $data);
            } else {
                $personal_details_id = $this->input->post('personal_details_id');
                $date_before = $this->input->post('date_before');
                $date_after = $this->input->post('date_after');
                $this->load->model('Usermodel');

                $data['gens'] = $this->Usermodel->getUserStatistics($personal_details_id, $date_before, $date_after);
                $limit = 100;
                $this->load->model('Usermodel');
                $results = $this->Usermodel->SearchInstancesUserStatistics($personal_details_id, $date_before, $date_after, $sort_by, $sort_order, $limit, $offset);
                $data['gen'] = $results['rows'];
                $data['num_result'] = $results['num_rows'];
//pagination

                $this->load->library('pagination');
                $config = array();
                $config['base_url'] = site_url("User/SearchUserStatistics/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_result'];
                $config['per_page'] = $limit;
                $config['first_link'] = '&laquo; Αρχική';
                $config['last_link'] = 'Τελευταία &raquo;';
                $config['total_rows'] = $this->db->count_all('peristatiko');
                $config['uri_segment'] = 5;
                $this->pagination->initialize($config);
                $data['personal_details_id'] = $personal_details_id;
                $data['date_before'] = $date_before;
                $data['date_after'] = $date_after;
                $data['pagination'] = $this->pagination->create_links();
                $data['fields'] = array(
                    'peristatiko_id' => 'Α/Α',
                    'ps_date' => 'Ημερομηνία',
                    'ps_topos' => 'Περιοχή',
                    'perigrafi' => 'Περιγραφή',
                    'pd_vathmos' => 'Βαθμός',
                    'pd_eponimo' => 'Επώνυμο',
                    'pd_onoma' => 'Όνομα',
                    'pd_am' => 'ΑΜ'
                );
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;
                $this->load->view('User/SearchUserStatisticsResults', $data);
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_User($personal_details_id) {
        if ($personal_details_id == "-1") {
            $this->form_validation->set_message('Select_User', 'Επιλέξτε από τη λίστα έναν πυροτεχνουργό');
            return false;
        } else {
            return true;
        }
    }

    public function TotalUserStatistics($personal_details_id, $date_before, $date_after, $sort_by = 'personal_details_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');

            $this->load->model('Usermodel');
            $data['personal_details_id'] = $personal_details_id;
            $data['date_before'] = $date_before;
            $data['date_after'] = $date_after;
            $data['gens'] = $this->Usermodel->getUTotalStatistics($personal_details_id, $date_before, $date_after);
            $this->load->view('pdf/TotalUserStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function OverUnitStatistics() {
        if ($this->session->userdata('userIsLoggedIn')) {

            $data['username'] = $this->session->userdata('username');
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['uid'] = $this->session->userdata('uid');


            //user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');


            //load User home page

            $this->load->view('User/OverUnitStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    public function SearchOverUnitStatistics($sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
//user information
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');


            $this->load->library('form_validation');
            $error = '';

            //$this->form_validation->set_rules('text_search', 'Λέξεις προς Αναζήτηση Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sximatismos_id', 'Επιλέξτε τoν Σχηματισμό ', 'required|callback_Select_OverUnit'); // Validating select option field.
            $this->form_validation->set_rules('date_before', 'Ημερομηνία Έναρξης Περιστατικού ', 'trim|required|xss_clean');
            $this->form_validation->set_rules('date_after', 'Ημερομηνία Λήξης Περιστατικού ', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $error;
                $this->load->view('User/OverUnitStatistics', $data);
            } else {
                $sximatismos_id = $this->input->post('sximatismos_id');
                $date_before = $this->input->post('date_before');
                $date_after = $this->input->post('date_after');
                $this->load->model('Usermodel');

                $data['gens'] = $this->Usermodel->getOverUnitStatistics($sximatismos_id, $date_before, $date_after);
                $limit = 100;
                $this->load->model('Usermodel');
                $results = $this->Usermodel->SearchInstancesOverUnitStatistics($sximatismos_id, $date_before, $date_after, $sort_by, $sort_order, $limit, $offset);
                $data['gen'] = $results['rows'];
                $data['num_result'] = $results['num_rows'];
//pagination

                $this->load->library('pagination');
                $config = array();
                $config['base_url'] = site_url("User/SearchOverUnitStatistics/$sort_by/$sort_order");
                $config['total_rows'] = $data['num_result'];
                $config['per_page'] = $limit;
                $config['first_link'] = '&laquo; Αρχική';
                $config['last_link'] = 'Τελευταία &raquo;';
                $config['total_rows'] = $this->db->count_all('peristatiko');
                $config['uri_segment'] = 5;
                $this->pagination->initialize($config);
                $data['sximatismos_id'] = $sximatismos_id;
                $data['date_before'] = $date_before;
                $data['date_after'] = $date_after;
                $data['pagination'] = $this->pagination->create_links();
                $data['fields'] = array(
                    'peristatiko_id' => 'Α/Α',
                    'ps_date' => 'Ημερομηνία',
                    'ps_topos' => 'Περιοχή',
                    'perigrafi' => 'Περιγραφή',
                    'pd_vathmos' => 'Βαθμός',
                    'pd_eponimo' => 'Επώνυμο',
                    'pd_onoma' => 'Όνομα',
                    'pd_am' => 'ΑΜ'
                );
                $data['sort_by'] = $sort_by;
                $data['sort_order'] = $sort_order;
                $this->load->view('User/SearchOverUnitStatisticsResults', $data);
            }
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

    function Select_OverUnit($sximatismos_id) {
        if ($sximatismos_id == "-1") {
            $this->form_validation->set_message('Select_OverUnit', 'Επιλέξτε από το πεδίο   Σχηματισμός');
            return false;
        } else {
            return true;
        }
    }

    public function TotalOverUnitStatistics($sximatismos_id, $date_before, $date_after, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');
            $data['username'] = $this->session->userdata('username');
            $data['uid'] = $this->session->userdata('uid');
            //pass messages
            $data['messageText'] = $this->session->userdata('messageText');
            $this->session->unset_userdata('messageText');
            $data['messageType'] = $this->session->userdata('messageType');
            $this->session->unset_userdata('messageType');

            $this->load->model('Usermodel');
            $data['sximatismos_id'] = $sximatismos_id;
            $data['date_before'] = $date_before;
            $data['date_after'] = $date_after;
            $data['gens'] = $this->Usermodel->getOverUnitTotalStatistics($sximatismos_id, $date_before, $date_after);
            $this->load->view('pdf/TotalOverUnitStatistics', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

}
