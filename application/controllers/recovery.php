<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Recovery extends CI_Controller {

    public function index() {
        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            //user information
            $data['uid'] = $this->session->userdata('uid');
            $data['username'] = $this->session->userdata('username');
            $this->load->view('User/Home', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('Recover', $data);
        }
    }

    public function Recoverpassword() {
        $this->load->model('recoverymodel');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('pd_am', 'Αριθμός Μητρώου', 'trim|required|xss_clean');
        $this->form_validation->set_rules('choosenWord', 'Λεκτικό Χρήστη', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $data['is_authenticated'] = FALSE;
            $data['error'] = '<h2>Λανθασμένη εισαγωγή στοιχείων! <br>Προσπαθήστε ξανά! </h2>';
            $this->load->view('Recover', $data);
        } else {

            $data['is_authenticated'] = FALSE;
            $new_password = $this->input->post('new_password');
            $username = $this->input->post('username');
            $pd_am = $this->input->post('pd_am');
            $choosenWord = $this->input->post('choosenWord');

            $result = $this->recoverymodel->searchPersonal($username, $pd_am, $choosenWord);
            if ($result == TRUE) {
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
                $result = $client->call('RecoverPassword', array(
                    'pd_username' => $username,
                    'pd_am' => $pd_am,
                    'pd_password' => $new_password,
                    'choosenWord' => $choosenWord
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
                        $data['new_password'] = $new_password;
                        $this->load->view('Recovered', $data);
                    }
                }
            } else {
                $data['is_authenticated'] = FALSE;
                $data['error'] = '<h2>Λανθασμένη εισαγωγή στοιχείων! <br>Προσπαθήστε ξανά! </h2>';
                $this->load->view('Recover', $data);
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */