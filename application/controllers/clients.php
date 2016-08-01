<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Clients extends CI_Controller {

    public function index() {

        $data = $this->load->library('nusoap');
        $this->load->view('clients', $data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */