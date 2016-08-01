<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pdf extends CI_Controller {

    public function index() {

        if ($this->session->userdata('userIsLoggedIn')) {
            $data['is_authenticated'] = $this->session->userdata('userIsLoggedIn');

            //user information
            $data['uid'] = $this->session->userdata('uid');
            $data['username'] = $this->session->userdata('username');
            $this->load->view('pdf/explosiveReport', $data);
        } else {
            $data['is_authenticated'] = FALSE;
            $this->load->view('User/Login', $data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */