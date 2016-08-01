<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller {

    public function index() {

        $this->load->view('Home');
    }

    public function ViewInstanceOne($peristatiko_id, $sort_by = 'peristatiko_id', $sort_order = 'asc', $offset = 0) {

        $data['peristatiko'] = $peristatiko_id;

        $this->load->model('public_model');
        $username = $this->session->userdata('username');
        //pass messages
        $data['gens'] = $this->public_model->getViewInstanceOne($peristatiko_id, $username);
        $data['gensEkriktika'] = $this->public_model->getViewInstanceOneEkriktika($peristatiko_id, $username);
        $data['gensExoplismos'] = $this->public_model->getViewInstanceOneExoplismos($peristatiko_id, $username);
        $data['gensPhotos'] = $this->public_model->getViewInstanceOnePhotos($peristatiko_id, $username);

        $limit = 10;

        $results = $this->public_model->searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
        $data['gen'] = $results['rows'];
        $data['num_result'] = $results['num_rows'];

        $resultsEkriktika = $this->public_model->searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
        $data['genEkriktika'] = $resultsEkriktika['rowsEkriktika'];
        $data['num_resultEkriktika'] = $resultsEkriktika['num_rowsEkriktika'];

        $resultsExoplismos = $this->public_model->searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
        $data['genExoplismos'] = $resultsExoplismos['rowsExoplismos'];
        $data['num_resultExoplismos'] = $resultsExoplismos['num_rowsExoplismos'];


        $resultsPhotos = $this->public_model->searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset);
        $data['genPhotos'] = $resultsPhotos['rowsPhotos'];
        $data['num_resultPhotos'] = $resultsPhotos['num_rowsPhotos'];

        //pagination
        $this->load->library('pagination');
        $config = array();
        $config['base_url'] = site_url("Home/ViewInstanceOne/$sort_by/$sort_order");
        $config['total_rows'] = $data['num_result'];
        $config['per_page'] = $limit;
        $config['first_link'] = '&laquo; First';
        $config['last_link'] = 'Last &raquo;';
        $config['total_rows'] = $this->db->count_all('peristatiko');
        $config['uri_segment'] = 5;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['fields'] = array(
            'peristatiko_id' => 'Περιστατικό',
            'ps_date' => 'Ημερομηνία',
            'ps_topos' => 'Περιοχή Δράσης',
            'ps_ora_enarxis' => 'Ώρα Έναρξης',
            'ps_ora_lixis' => 'Ώρα Λήξης',
            'anagnorisi' => 'Αναγνώριση',
            'status_var' => 'Κατάσταση Αίτησης'
        );
        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;
        $this->load->view('public/ViewInstanceOne', $data);
    }

    public function Photos() {

        $this->load->view('Include/public_all_photos');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */