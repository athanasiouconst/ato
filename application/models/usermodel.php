<?php

Class Usermodel extends CI_Model {
    #Authenticates the administrator account

    public function Login($username, $password) {
        $result = $this->db->query("SELECT * FROM personal_details WHERE pd_username='" . $username . "' AND pd_password='" . $password . "'");
        return $result->num_rows() == 1;
    }

    public function GetId($username) {
        $query = $this->db->query("SELECT personal_details_id FROM personal_details WHERE pd_username='" . $username . "'");
        return $query->row()->id;
    }

    public function getViewPersonalDetails($user) {
        $query = $this->db->query("SELECT * FROM personal_details WHERE pd_username='" . $user . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'personal_details_id' => $row->personal_details_id,
                'pd_vathmos' => $row->pd_vathmos,
                'pd_oplo_soma' => $row->pd_oplo_soma,
                'pd_onoma' => $row->pd_onoma,
                'pd_eponimo' => $row->pd_eponimo,
                'monada_id' => $row->monada_id,
                'pd_am' => $row->pd_am,
                'monada_id' => $row->monada_id,
                'roles_id' => $row->roles_id,
                'pd_username' => $row->pd_username,
                'pd_password' => $row->pd_password
            ));
        }
        return $results;
    }

    function searchViewPersonalDetails($user, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('personal_details_id', 'pd_vathmos', 'pd_oplo_soma'
            , 'pd_onoma', 'pd_eponimo', 'pd_am', 'monada_id', 'roles_id', 'monada_name', 'r_name', 'r_description',
            'pd_username', 'pd_password');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'personal_details_id';

        $query = $this->db->select('*')
                ->from('personal_details')
                ->join('roles', 'roles.roles_id = personal_details.roles_id', 'left outer')
                ->join('monada', 'monada.monada_id = personal_details.monada_id', 'left outer')
                ->limit($limit, $offset)
                ->where('pd_username', $user)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query

        $query = $this->db->count_all('personal_details');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_PersonalDetails($data) {

        $this->db->insert('personal_details', $data);
        return;
    }

    public function PersonalDetailsEditForm($user) {
        $query = $this->db->query("SELECT * FROM personal_details  "
                . " JOIN roles ON personal_details.roles_id=roles.roles_id"
                . " JOIN monada ON personal_details.monada_id=monada.monada_id"
                . " WHERE pd_username='" . $user . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'personal_details_id' => $row->personal_details_id,
                'pd_vathmos' => $row->pd_vathmos,
                'pd_oplo_soma' => $row->pd_oplo_soma,
                'pd_onoma' => $row->pd_onoma,
                'pd_eponimo' => $row->pd_eponimo,
                'pd_am' => $row->pd_am,
                'monada_id' => $row->monada_id,
                'monada_name' => $row->monada_name,
                'eod' => $row->eod,
                'roles_id' => $row->roles_id,
                'r_name' => $row->r_name,
                'pd_username' => $row->pd_username,
                'pd_password' => $row->pd_password,
                'choosenWord' => $row->choosenWord
            ));
        }
        return $results;
    }

    //Update news
    public function editPersonalDetails($personal_details_id, $data) {

        $this->db->where('personal_details_id', $personal_details_id);
        $this->db->update('personal_details', $data);
    }

    public function getViewRoles() {
        $query = $this->db->query("SELECT * FROM roles ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'roles_id' => $row->roles_id,
                'r_name' => $row->r_name,
                'r_description' => $row->r_description
            ));
        }
        return $results;
    }

    function searchViewRoles($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('roles_id', 'r_name', 'r_description');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'roles_id';

        $query = $this->db->select('*')
                ->from('roles')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('roles');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Roles($data) {

        $this->db->insert('roles', $data);
        return;
    }

    public function getEditRoles($roles_id) {
        $query = $this->db->query("SELECT * FROM roles WHERE roles_id='" . $roles_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'roles_id' => $row->roles_id,
                'r_name' => $row->r_name,
                'r_description' => $row->r_description
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Roles($roles_id, $data) {

        $this->db->where('roles_id', $roles_id);
        $this->db->update('roles', $data);
    }

    //Delete
    function RolesDelete($roles_id) {
        $this->db->where('roles_id', $roles_id);
        $this->db->delete('roles');
    }

    public function getViewStatus() {
        $query = $this->db->query("SELECT * FROM status ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'status_id' => $row->status_id,
                'status_var' => $row->status_var
            ));
        }
        return $results;
    }

    function searchViewStatus($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('status_id', 'status_var');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'status_id';

        $query = $this->db->select('*')
                ->from('status')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('status');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getEditStatus($status_id) {
        $query = $this->db->query("SELECT * FROM status WHERE status_id='" . $status_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'status_id' => $row->status_id,
                'status_var' => $row->status_var
            ));
        }
        return $results;
    }

    function add_Status($data) {

        $this->db->insert('status', $data);
        return;
    }

    //Update 
    public function edit_Status($status_id, $data) {

        $this->db->where('status_id', $status_id);
        $this->db->update('status', $data);
    }

    //Delete
    function StatusDelete($status_id) {
        $this->db->where('status_id', $status_id);
        $this->db->delete('status');
    }

    public function getViewAmmo() {
        $query = $this->db->query("SELECT * FROM eidos_puromaxikou ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'eidos_puromaxikou_id' => $row->eidos_puromaxikou_id,
                'ep_eidos' => $row->ep_eidos,
                'ep_value' => $row->ep_value,
                'ep_perigrafi' => $row->ep_perigrafi
            ));
        }
        return $results;
    }

    function searchViewAmmo($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('eidos_puromaxikou_id', 'ep_eidos', 'ep_value', 'ep_perigrafi');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'eidos_puromaxikou_id';

        $query = $this->db->select('*')
                ->from('eidos_puromaxikou')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('eidos_puromaxikou');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Ammo($data) {

        $this->db->insert('eidos_puromaxikou', $data);
        return;
    }

    public function getEditAmmo($eidos_puromaxikou_id) {
        $query = $this->db->query("SELECT * FROM eidos_puromaxikou WHERE eidos_puromaxikou_id='" . $eidos_puromaxikou_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'eidos_puromaxikou_id' => $row->eidos_puromaxikou_id,
                'ep_eidos' => $row->ep_eidos,
                'ep_value' => $row->ep_value,
                'ep_perigrafi' => $row->ep_perigrafi
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Ammo($eidos_puromaxikou_id, $data) {

        $this->db->where('eidos_puromaxikou_id', $eidos_puromaxikou_id);
        $this->db->update('eidos_puromaxikou', $data);
    }

    //Delete
    function AmmoDelete($eidos_puromaxikou_id) {
        $this->db->where('eidos_puromaxikou_id', $eidos_puromaxikou_id);
        $this->db->delete('eidos_puromaxikou');
    }

    public function getViewEvent() {
        $query = $this->db->query("SELECT * FROM eidos_sumvantos ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'eidos_sumvantos_id' => $row->eidos_sumvantos_id,
                'es_code' => $row->es_code,
                'es_perigrafi' => $row->es_perigrafi,
                'es_notes' => $row->es_notes
            ));
        }
        return $results;
    }

    function searchViewEvent($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('eidos_sumvantos_id', 'es_code', 'es_perigrafi', 'es_notes');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'eidos_sumvantos_id';

        $query = $this->db->select('*')
                ->from('eidos_sumvantos')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('eidos_sumvantos');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Event($data) {

        $this->db->insert('eidos_sumvantos', $data);
        return;
    }

    public function getEditEvent($eidos_sumvantos_id) {
        $query = $this->db->query("SELECT * FROM eidos_sumvantos WHERE eidos_sumvantos_id='" . $eidos_sumvantos_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'eidos_sumvantos_id' => $row->eidos_sumvantos_id,
                'es_code' => $row->es_code,
                'es_perigrafi' => $row->es_perigrafi,
                'es_notes' => $row->es_notes
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Event($eidos_sumvantos_id, $data) {

        $this->db->where('eidos_sumvantos_id', $eidos_sumvantos_id);
        $this->db->update('eidos_sumvantos', $data);
    }

    //Delete
    function EventDelete($eidos_sumvantos_id) {
        $this->db->where('eidos_sumvantos_id', $eidos_sumvantos_id);
        $this->db->delete('eidos_sumvantos');
    }

    public function getViewCompetence() {
        $query = $this->db->query("SELECT * FROM katanomi_armodiotiton ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'katanomi_armodiotiton_id' => $row->katanomi_armodiotiton_id,
                'ka_armodiotites' => $row->ka_armodiotites,
                'ka_perigrafi_armodiotiton' => $row->ka_perigrafi_armodiotiton
            ));
        }
        return $results;
    }

    function searchViewCompetence($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('katanomi_armodiotiton_id', 'ka_armodiotites', 'ka_perigrafi_armodiotiton');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'katanomi_armodiotiton_id';

        $query = $this->db->select('*')
                ->from('katanomi_armodiotiton')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('katanomi_armodiotiton');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Competence($data) {

        $this->db->insert('katanomi_armodiotiton', $data);
        return;
    }

    public function getEditCompetence($katanomi_armodiotiton_id) {
        $query = $this->db->query("SELECT * FROM katanomi_armodiotiton WHERE katanomi_armodiotiton_id='" . $katanomi_armodiotiton_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'katanomi_armodiotiton_id' => $row->katanomi_armodiotiton_id,
                'ka_armodiotites' => $row->ka_armodiotites,
                'ka_perigrafi_armodiotiton' => $row->ka_perigrafi_armodiotiton
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Competence($katanomi_armodiotiton_id, $data) {

        $this->db->where('katanomi_armodiotiton_id', $katanomi_armodiotiton_id);
        $this->db->update('katanomi_armodiotiton', $data);
    }

    //Delete
    function CompetenceDelete($katanomi_armodiotiton_id) {
        $this->db->where('katanomi_armodiotiton_id', $katanomi_armodiotiton_id);
        $this->db->delete('katanomi_armodiotiton');
    }

    public function getViewPriority() {
        $query = $this->db->query("SELECT * FROM katigoria_proteraiotitas ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'katigoria_proteraiotitas_id' => $row->katigoria_proteraiotitas_id,
                'kp_code' => $row->kp_code,
                'kp_perigrafi' => $row->kp_perigrafi
            ));
        }
        return $results;
    }

    function searchViewPriority($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('katigoria_proteraiotitas_id', 'kp_code', 'kp_perigrafi');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'katigoria_proteraiotitas_id';

        $query = $this->db->select('*')
                ->from('katigoria_proteraiotitas')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('katigoria_proteraiotitas');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Priority($data) {

        $this->db->insert('katigoria_proteraiotitas', $data);
        return;
    }

    public function getEditPriority($katigoria_proteraiotitas_id) {
        $query = $this->db->query("SELECT * FROM katigoria_proteraiotitas WHERE katigoria_proteraiotitas_id='" . $katigoria_proteraiotitas_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'katigoria_proteraiotitas_id' => $row->katigoria_proteraiotitas_id,
                'kp_code' => $row->kp_code,
                'kp_perigrafi' => $row->kp_perigrafi
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Priority($katigoria_proteraiotitas_id, $data) {

        $this->db->where('katigoria_proteraiotitas_id', $katigoria_proteraiotitas_id);
        $this->db->update('katigoria_proteraiotitas', $data);
    }

    //Delete
    function PriorityDelete($katigoria_proteraiotitas_id) {
        $this->db->where('katigoria_proteraiotitas_id', $katigoria_proteraiotitas_id);
        $this->db->delete('katigoria_proteraiotitas');
    }

    public function getViewIncident() {
        $query = $this->db->query("SELECT * FROM katigoria_sumbantos ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'katigoria_sumvantos_id' => $row->katigoria_sumvantos_id,
                'ks_epipedo' => $row->ks_epipedo,
                'ks_perigrafi' => $row->ks_perigrafi
            ));
        }
        return $results;
    }

    function searchViewIncident($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('katigoria_sumvantos_id', 'ks_epipedo', 'ks_perigrafi');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'katigoria_sumvantos_id';

        $query = $this->db->select('*')
                ->from('katigoria_sumbantos')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('katigoria_sumbantos');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Incident($data) {

        $this->db->insert('katigoria_sumbantos', $data);
        return;
    }

    public function getEditIncident($katigoria_sumvantos_id) {
        $query = $this->db->query("SELECT * FROM katigoria_sumbantos WHERE katigoria_sumvantos_id='" . $katigoria_sumvantos_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'katigoria_sumvantos_id' => $row->katigoria_sumvantos_id,
                'ks_epipedo' => $row->ks_epipedo,
                'ks_perigrafi' => $row->ks_perigrafi
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Incident($katigoria_sumvantos_id, $data) {

        $this->db->where('katigoria_sumvantos_id', $katigoria_sumvantos_id);
        $this->db->update('katigoria_sumbantos', $data);
    }

    //Delete
    function IncidentDelete($katigoria_sumvantos_id) {
        $this->db->where('katigoria_sumvantos_id', $katigoria_sumvantos_id);
        $this->db->delete('katigoria_sumbantos');
    }

    public function getViewIncidentPosition() {
        $query = $this->db->query("SELECT * FROM thesi_sumvantos ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'thesi_simvantos_id' => $row->thesi_simvantos_id,
                'ts_thesi' => $row->ts_thesi,
                'ts_value' => $row->ts_value,
                'ts_perigrafi' => $row->ts_perigrafi
            ));
        }
        return $results;
    }

    function searchViewIncidentPosition($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('thesi_simvantos_id', 'ts_thesi', 'ts_value', 'ts_perigrafi');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'thesi_simvantos_id';

        $query = $this->db->select('*')
                ->from('thesi_sumvantos')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('thesi_sumvantos');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_IncidentPosition($data) {

        $this->db->insert('thesi_sumvantos', $data);
        return;
    }

    public function getEditIncidentPosition($thesi_simvantos_id) {
        $query = $this->db->query("SELECT * FROM thesi_sumvantos WHERE thesi_simvantos_id='" . $thesi_simvantos_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'thesi_simvantos_id' => $row->thesi_simvantos_id,
                'ts_thesi' => $row->ts_thesi,
                'ts_value' => $row->ts_value,
                'ts_perigrafi' => $row->ts_perigrafi
            ));
        }
        return $results;
    }

    //Update 
    public function edit_IncidentPosition($thesi_simvantos_id, $data) {

        $this->db->where('thesi_simvantos_id', $thesi_simvantos_id);
        $this->db->update('thesi_sumvantos', $data);
    }

    //Delete
    function IncidentPositionDelete($thesi_simvantos_id) {
        $this->db->where('thesi_simvantos_id', $thesi_simvantos_id);
        $this->db->delete('thesi_sumvantos');
    }

    public function getViewExplosive() {
        $query = $this->db->query("SELECT * FROM ekriktika ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'ekriktika_id' => $row->ekriktika_id,
                'ek_eidos' => $row->ek_eidos,
                'ek_paratiriseis' => $row->ek_paratiriseis
            ));
        }
        return $results;
    }

    public function getViewExplosiveLot() {
        $query = $this->db->query("SELECT * FROM ekriktika_lot  "
                . " LEFT JOIN ekriktika ON ekriktika.ekriktika_id=ekriktika_lot.ekriktika_id "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'ekriktika_id' => $row->ekriktika_id,
                'ek_eidos' => $row->ek_eidos,
                'lot' => $row->lot
            ));
        }
        return $results;
    }

    function searchViewExplosive($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('ekriktika_id', 'ek_eidos', 'ek_paratiriseis');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'ekriktika_id';

        $query = $this->db->select('*')
                ->from('ekriktika')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('ekriktika');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function searchViewExplosiveLot($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('ekriktika.ekriktika_id', 'ek_eidos', 'lot');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'ekriktika.ekriktika_id';

        $query = $this->db->select('*')
                ->from('ekriktika')
                ->join('ekriktika_lot', 'ekriktika.ekriktika_id = ekriktika_lot.ekriktika_id', 'left outer')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('ekriktika');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Explosive($data) {

        $this->db->insert('ekriktika', $data);
        return;
    }

    function add_ExplosiveLot($data) {

        $this->db->insert('ekriktika_lot', $data);
        return;
    }

    public function getEditExplosive($ekriktika_id) {
        $query = $this->db->query("SELECT * FROM ekriktika WHERE ekriktika_id='" . $ekriktika_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'ekriktika_id' => $row->ekriktika_id,
                'ek_eidos' => $row->ek_eidos,
                'ek_paratiriseis' => $row->ek_paratiriseis
            ));
        }
        return $results;
    }

    public function getEditExplosiveELot($ekriktika_id) {
        $query = $this->db->query("SELECT * FROM ekriktika "
                . " LEFT JOIN ekriktika_lot ON ekriktika.ekriktika_id=ekriktika_lot.ekriktika_id "
                . "WHERE ekriktika_lot.ekriktika_id='" . $ekriktika_id . "' "
                . " GROUP BY ekriktika.ekriktika_id");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'ekriktika_lot_id' => $row->ekriktika_lot_id,
                'ekriktika_id' => $row->ekriktika_id,
                'ek_eidos' => $row->ek_eidos,
                'lot' => $row->lot
            ));
        }
        return $results;
    }

    public function getEditExplosiveLot($ekriktika_id) {
        $query = $this->db->query("SELECT * FROM ekriktika "
                . " LEFT JOIN ekriktika_lot ON ekriktika.ekriktika_id=ekriktika_lot.ekriktika_id "
                . "WHERE ekriktika_lot.ekriktika_id='" . $ekriktika_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'ekriktika_lot_id' => $row->ekriktika_lot_id,
                'ekriktika_id' => $row->ekriktika_id,
                'ek_eidos' => $row->ek_eidos,
                'lot' => $row->lot
            ));
        }
        return $results;
    }

    public function getEditExplosiveLotExplosiveEdit($ek_eidos) {
        $query = $this->db->query("SELECT * FROM ekriktika "
                . "WHERE ekriktika.ekriktika_id='" . $ek_eidos . "' "
                . " ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'ekriktika_id' => $row->ekriktika_id,
                'ek_eidos' => $row->ek_eidos
            ));
        }
        return $results;
    }

    public function getEditExplosiveLotEdit($ekriktika_lot_id) {
        $query = $this->db->query("SELECT * FROM ekriktika_lot "
                . "WHERE ekriktika_lot.ekriktika_lot_id='" . $ekriktika_lot_id . "' "
                . " ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'ekriktika_lot_id' => $row->ekriktika_lot_id,
                'lot' => $row->lot
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Explosive($ekriktika_id, $data) {

        $this->db->where('ekriktika_id', $ekriktika_id);
        $this->db->update('ekriktika', $data);
    }

    //Delete
    function ExplosiveDelete($ekriktika_id) {
        $this->db->where('ekriktika_id', $ekriktika_id);
        $this->db->delete('ekriktika');
    }

    //Update 
    public function edit_ExplosiveLot($ekriktika_lot_id, $data) {

        $this->db->where('ekriktika_lot_id', $ekriktika_lot_id);
        $this->db->update('ekriktika_lot', $data);
    }

//Delete
    function ExplosiveLotDelete($ekriktika_lot_id) {
        $this->db->where('ekriktika_lot_id', $ekriktika_lot_id);
        $this->db->delete('ekriktika_lot');
    }

    public function getViewEquipment() {
        $query = $this->db->query("SELECT * FROM exoplismos ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'exoplismos_id' => $row->exoplismos_id,
                'ex_eidos' => $row->ex_eidos,
                'ex_paratiriseis' => $row->ex_paratiriseis
            ));
        }
        return $results;
    }

    function searchViewEquipment($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('exoplismos_id', 'ex_eidos', 'ex_paratiriseis');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'exoplismos_id';

        $query = $this->db->select('*')
                ->from('exoplismos')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('exoplismos');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Equipment($data) {

        $this->db->insert('exoplismos', $data);
        return;
    }

    public function getViewMonada() {
        $query = $this->db->query("SELECT * FROM monada ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'monada_id' => $row->monada_id,
                'monada_name' => $row->monada_name,
                'monada_area' => $row->monada_area
            ));
        }
        return $results;
    }

    function searchViewMonada($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('monada_id', 'monada_name', 'monada_area');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'monada_id';

        $query = $this->db->select('*')
                ->from('monada')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('monada');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_Monada($data) {

        $this->db->insert('monada', $data);
        return;
    }

    public function getEditMonada($monada_id) {
        $query = $this->db->query("SELECT * FROM monada WHERE monada_id='" . $monada_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'monada_id' => $row->monada_id,
                'monada_name' => $row->monada_name,
                'monada_area' => $row->monada_area
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Monada($monada_id, $data) {

        $this->db->where('monada_id', $monada_id);
        $this->db->update('monada', $data);
    }

    //Delete
    function MonadaDelete($monada_id) {
        $this->db->where('monada_id', $monada_id);
        $this->db->delete('monada');
    }

    public function getViewOverMonada() {
        $query = $this->db->query("SELECT * FROM sximatismos "
                . "LEFT JOIN monada ON sximatismos.monada_id=monada.monada_id "
                . " WHERE sximatismos.monada_id=monada.monada_id");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'sximatismos_id' => $row->sximatismos_id,
                'sximatismos_name' => $row->sximatismos_name,
                'sximatismos_area' => $row->sximatismos_area,
                'monada_name' => $row->monada_name,
                'monada_area' => $row->monada_area
            ));
        }
        return $results;
    }

    function searchViewOverMonada($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('sximatismos_id', 'sximatismos_name', 'sximatismos_area');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'sximatismos_id';

        $query = $this->db->select('*')
                ->from('sximatismos')
                ->join('monada', 'sximatismos.monada_id = monada.monada_id', 'left outer')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query

        $query = $this->db->count_all('sximatismos');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function add_OverMonada($data) {

        $this->db->insert('sximatismos', $data);
        return;
    }

    public function getEditOverMonada($sximatismos_id) {
        $query = $this->db->query("SELECT * FROM sximatismos "
                . " LEFT JOIN monada ON sximatismos.monada_id=monada.monada_id"
                . " WHERE sximatismos_id='" . $sximatismos_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'sximatismos_id' => $row->sximatismos_id,
                'sximatismos_name' => $row->sximatismos_name,
                'sximatismos_area' => $row->sximatismos_area,
                'monada_id' => $row->monada_id,
                'monada_name' => $row->monada_name,
                'monada_area' => $row->monada_area
            ));
        }
        return $results;
    }

    //Update 
    public function edit_OverMonada($sximatismos_id, $data) {

        $this->db->where('sximatismos_id', $sximatismos_id);
        $this->db->update('sximatismos', $data);
    }

    //Delete
    function OverMonadaDelete($sximatismos_id) {
        $this->db->where('sximatismos_id', $sximatismos_id);
        $this->db->delete('sximatismos');
    }

    public function getEditEquipment($exoplismos_id) {
        $query = $this->db->query("SELECT * FROM exoplismos WHERE exoplismos_id='" . $exoplismos_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'exoplismos_id' => $row->exoplismos_id,
                'ex_eidos' => $row->ex_eidos,
                'ex_paratiriseis' => $row->ex_paratiriseis
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Equipment($exoplismos_id, $data) {

        $this->db->where('exoplismos_id', $exoplismos_id);
        $this->db->update('exoplismos', $data);
    }

    //Delete
    function EquipmentDelete($exoplismos_id) {
        $this->db->where('exoplismos_id', $exoplismos_id);
        $this->db->delete('exoplismos');
    }

    public function getViewInstanceKEY() {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                //. "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id WHERE personal_details.pd_username='" . $username . "' "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceKEY($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->limit($limit, $offset)
                ->where('peristatiko.status_id', 3)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstanceKEYSubmit() {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                //. "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id WHERE personal_details.pd_username='" . $username . "' "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceKEYSubmit($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->limit($limit, $offset)
                ->where('peristatiko.status_id', 4)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstanceKEYStatistics() {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                //. "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id WHERE personal_details.pd_username='" . $username . "' "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceKEYStatistics($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewKEYStatistics($status_id) {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                //. "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id WHERE personal_details.pd_username='" . $username . "' "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewKEYStatistics($status_id, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->where('peristatiko.status_id', $status_id)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstanceKEYUserStatistics() {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                //. "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id WHERE personal_details.pd_username='" . $username . "' "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceKEYUserStatistics($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function searchViewInstance($username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->limit($limit, $offset)
                ->where('pd_username', $username)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstance($username) {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id WHERE personal_details.pd_username='" . $username . "' "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceStatus($status_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->limit($limit, $offset)
                ->where('pd_username', $username)
                ->where('peristatiko.status_id', $status_id)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstanceStatus($status_id, $username) {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " WHERE personal_details.pd_username='" . $username . "' "
                . " AND peristatiko.status_id='" . $status_id . "'  "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('eidos_sumvantos', 'eidos_sumvantos.eidos_sumvantos_id = peristatiko.eidos_sumvantos_id', 'left outer')
                ->limit($limit, $offset)
                ->where('pd_username', $username)
                ->where('peristatiko.status_id', $status_id)
                ->where('peristatiko.eidos_sumvantos_id', $eidos_sumvantos_id)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstanceCodeStatus($status_id, $eidos_sumvantos_id, $username) {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " WHERE personal_details.pd_username='" . $username . "' "
                . " AND peristatiko.eidos_sumvantos_id='" . $eidos_sumvantos_id . "' "
                . " AND peristatiko.status_id='" . $status_id . "'  "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'asc' : 'desc';
        $sort_colums = array('peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('eidos_sumvantos', 'eidos_sumvantos.eidos_sumvantos_id = peristatiko.eidos_sumvantos_id', 'left outer')
                ->limit($limit, $offset)
                ->where('peristatiko.status_id', $status_id)
                ->where('peristatiko.eidos_sumvantos_id', $eidos_sumvantos_id)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstanceKEYCodeStatus($status_id, $eidos_sumvantos_id, $username) {
        $query = $this->db->query("SELECT * FROM peristatiko  "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " WHERE "
                . " peristatiko.eidos_sumvantos_id='" . $eidos_sumvantos_id . "' "
                . " AND peristatiko.status_id='" . $status_id . "'  "
                . "ORDER BY peristatiko.peristatiko_id ASC ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function add_TempInstance($data) {

        $this->db->insert('peristatiko', $data);
        return $data;
    }

    function add_Instance($data) {

        $this->db->insert('peristatiko', $data);
        return $data;
    }

    function add_InstanceExplosive($data) {

        $this->db->insert('peristatiko_ekriktika', $data);
        return;
    }

    function add_InstanceEquipment($data) {

        $this->db->insert('peristatiko_exoplismos', $data);
        return;
    }

    public function getViewInstanceOne($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . "WHERE personal_details.pd_username='" . $username . "' "
                . "AND "
                . "peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    public function getViewPeristatiko($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . "WHERE personal_details.pd_username='" . $username . "' "
                . "AND "
                . "peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    public function getViewPeristatikoKEY($peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . "WHERE "
                . "peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('monada', 'personal_details.monada_id = monada.monada_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('katanomi_armodiotiton', 'katanomi_armodiotiton.katanomi_armodiotiton_id = peristatiko.katanomi_armodiotiton_id', 'left outer')
                ->join('katigoria_sumbantos', 'katigoria_sumbantos.katigoria_sumvantos_id = peristatiko.katigoria_sumvantos_id', 'left outer')
                ->join('eidos_sumvantos', 'eidos_sumvantos.eidos_sumvantos_id = peristatiko.eidos_sumvantos_id', 'left outer')
                ->join('eidos_puromaxikou', 'eidos_puromaxikou.eidos_puromaxikou_id = peristatiko.eidos_puromaxikou_id', 'left outer')
                ->join('katigoria_proteraiotitas', 'katigoria_proteraiotitas.katigoria_proteraiotitas_id = peristatiko.katigoria_proteraiotitas_id', 'left outer')
                ->join('thesi_sumvantos', 'thesi_sumvantos.thesi_simvantos_id = peristatiko.thesi_simvantos_id', 'left outer')
                ->join('peristatiko_ekriktika', 'peristatiko_ekriktika.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('ekriktika_lot', 'peristatiko_ekriktika.ekriktika_lot_id = ekriktika_lot.ekriktika_lot_id', 'left outer')
                ->join('ekriktika', 'ekriktika_lot.ekriktika_id = ekriktika.ekriktika_id', 'left outer')
                ->join('peristatiko_exoplismos', 'peristatiko_exoplismos.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('exoplismos', 'peristatiko_exoplismos.exoplismos_id = exoplismos.exoplismos_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                ->where('personal_details.pd_username', $username)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order)
                ->group_by('peristatiko.peristatiko_id');
        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    //Delete
    function InstanceDelete($peristatiko_id) {
        $this->db->where('peristatiko_id', $peristatiko_id);
        $this->db->delete('peristatiko');
    }

    //Delete
    function InstanceEquipmentDelete($peristatikoEquipment) {
        $this->db->where('peristatiko_exoplismos_id', $peristatikoEquipment);
        $this->db->delete('peristatiko_exoplismos');
    }

//Delete
    function InstanceExplosiveDelete($peristatikoExplosive) {
        $this->db->where('peristatiko_ekriktika_id', $peristatikoExplosive);
        $this->db->delete('peristatiko_ekriktika');
    }

    public function getViewInstanceOneEkriktika($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . "WHERE personal_details.pd_username='" . $username . "' "
                . "AND "
                . "peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOneEkriktika($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('peristatiko_ekriktika', 'peristatiko_ekriktika.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('ekriktika_lot', 'peristatiko_ekriktika.ekriktika_lot_id = ekriktika_lot.ekriktika_lot_id', 'left outer')
                ->join('ekriktika', 'ekriktika_lot.ekriktika_id = ekriktika.ekriktika_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                ->where('personal_details.pd_username', $username)
                ->limit($limit, $offset);
        //->order_by($sort_by, $sort_order);
        $ret['rowsEkriktika'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rowsEkriktika'] = $tmp;
        return $ret;
    }

    public function getViewInstanceOneExoplismos($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . "WHERE personal_details.pd_username='" . $username . "' "
                . "AND "
                . "peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOneExoplismos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('peristatiko_exoplismos', 'peristatiko_exoplismos.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('exoplismos', 'peristatiko_exoplismos.exoplismos_id = exoplismos.exoplismos_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                ->where('personal_details.pd_username', $username)
                ->limit($limit, $offset);
        //->order_by($sort_by, $sort_order);
        $ret['rowsExoplismos'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rowsExoplismos'] = $tmp;
        return $ret;
    }

    public function getViewInstanceOnePhotos($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . "LEFT JOIN uploads ON peristatiko.peristatiko_id=uploads.peristatiko_id "
                . "WHERE personal_details.pd_username='" . $username . "' "
                . "AND "
                . "peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOnePhotos($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('uploads', 'uploads.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                ->where('personal_details.pd_username', $username)
                ->limit($limit, $offset);
        //->order_by($sort_by, $sort_order);
        $ret['rowsPhotos'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rowsPhotos'] = $tmp;
        return $ret;
    }

    public function UpdateStatus($peristatiko_id, $data) {

        $this->db->where('peristatiko_id', $peristatiko_id);
        $this->db->update('peristatiko', $data);
    }

    public function getViewInstanceOneKEY($peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                //. "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
                //. "AND "
                . "WHERE peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id
                    //'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOneKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('monada', 'personal_details.monada_id = monada.monada_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('katanomi_armodiotiton', 'katanomi_armodiotiton.katanomi_armodiotiton_id = peristatiko.katanomi_armodiotiton_id', 'left outer')
                ->join('katigoria_sumbantos', 'katigoria_sumbantos.katigoria_sumvantos_id = peristatiko.katigoria_sumvantos_id', 'left outer')
                ->join('eidos_sumvantos', 'eidos_sumvantos.eidos_sumvantos_id = peristatiko.eidos_sumvantos_id', 'left outer')
                ->join('eidos_puromaxikou', 'eidos_puromaxikou.eidos_puromaxikou_id = peristatiko.eidos_puromaxikou_id', 'left outer')
                ->join('katigoria_proteraiotitas', 'katigoria_proteraiotitas.katigoria_proteraiotitas_id = peristatiko.katigoria_proteraiotitas_id', 'left outer')
                ->join('thesi_sumvantos', 'thesi_sumvantos.thesi_simvantos_id = peristatiko.thesi_simvantos_id', 'left outer')
                ->join('peristatiko_ekriktika', 'peristatiko_ekriktika.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('ekriktika_lot', 'peristatiko_ekriktika.ekriktika_lot_id = ekriktika_lot.ekriktika_lot_id', 'left outer')
                ->join('ekriktika', 'ekriktika_lot.ekriktika_id = ekriktika.ekriktika_id', 'left outer')
                ->join('peristatiko_exoplismos', 'peristatiko_exoplismos.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('exoplismos', 'peristatiko_exoplismos.exoplismos_id = exoplismos.exoplismos_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                //->where('personal_details.pd_username', $username)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order)
                ->group_by('peristatiko.peristatiko_id');
        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewInstanceOneEkriktikaKEY($peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
                //. "AND "
                . "WHERE peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOneEkriktikaKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('peristatiko_ekriktika', 'peristatiko_ekriktika.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('ekriktika_lot', 'peristatiko_ekriktika.ekriktika_lot_id = ekriktika_lot.ekriktika_lot_id', 'left outer')
                ->join('ekriktika', 'ekriktika_lot.ekriktika_id = ekriktika.ekriktika_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                //->where('personal_details.pd_username', $username)
                ->limit($limit, $offset);
        //->order_by($sort_by, $sort_order);
        $ret['rowsEkriktika'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rowsEkriktika'] = $tmp;
        return $ret;
    }

    public function getViewInstanceOneExoplismosKEY($peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
                //. "AND "
                . "WHERE peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOneExoplismosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('peristatiko_exoplismos', 'peristatiko_exoplismos.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('exoplismos', 'peristatiko_exoplismos.exoplismos_id = exoplismos.exoplismos_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                //->where('personal_details.pd_username', $username)
                ->limit($limit, $offset);
        //->order_by($sort_by, $sort_order);
        $ret['rowsExoplismos'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rowsExoplismos'] = $tmp;
        return $ret;
    }

    public function getViewInstanceOnePhotosKEY($peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
                //. "AND "
                . "WHERE peristatiko.peristatiko_id=  '" . $peristatiko_id . "'");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchViewInstanceOnePhotosKEY($peristatiko_id, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('uploads', 'uploads.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->where('peristatiko.peristatiko_id', $peristatiko_id)
                //->where('personal_details.pd_username', $username)
                ->limit($limit, $offset);
        //->order_by($sort_by, $sort_order);
        $ret['rowsPhotos'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rowsPhotos'] = $tmp;
        return $ret;
    }

    public function UpdateStatusKEY($peristatiko_id, $data) {

        $this->db->where('peristatiko_id', $peristatiko_id);
        $this->db->update('peristatiko', $data);
    }

    public function UpdateStatusInstance($peristatiko_id, $data) {

        $this->db->where('peristatiko_id', $peristatiko_id);
        $this->db->update('peristatiko', $data);
    }

    public function getEditInstance($peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " LEFT JOIN personal_details on peristatiko.personal_details_id=personal_details.personal_details_id"
                . " LEFT JOIN status on peristatiko.status_id=status.status_id"
                . " LEFT JOIN katanomi_armodiotiton on peristatiko.katanomi_armodiotiton_id=katanomi_armodiotiton.katanomi_armodiotiton_id"
                . " LEFT JOIN katigoria_sumbantos on peristatiko.katigoria_sumvantos_id=katigoria_sumbantos.katigoria_sumvantos_id"
                . " LEFT JOIN eidos_sumvantos on peristatiko.eidos_sumvantos_id=eidos_sumvantos.eidos_sumvantos_id"
                . " LEFT JOIN eidos_puromaxikou on peristatiko.eidos_puromaxikou_id=eidos_puromaxikou.eidos_puromaxikou_id"
                . " LEFT JOIN katigoria_proteraiotitas on peristatiko.katigoria_proteraiotitas_id=katigoria_proteraiotitas.katigoria_proteraiotitas_id"
                . " LEFT JOIN thesi_sumvantos on peristatiko.thesi_simvantos_id=thesi_sumvantos.thesi_simvantos_id"
                . " WHERE peristatiko.peristatiko_id='" . $peristatiko_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'pd_username' => $row->pd_username,
                'personal_details_id' => $row->personal_details_id,
                'ka_armodiotites' => $row->ka_armodiotites,
                'ks_epipedo' => $row->ks_epipedo,
                'es_code' => $row->es_code,
                'ep_eidos' => $row->ep_eidos,
                'kp_code' => $row->kp_code,
                'ts_thesi' => $row->ts_thesi,
                'document' => $row->document,
                'ps_date' => $row->ps_date,
                'ps_topos' => $row->ps_topos,
                'ps_ora_enarxis' => $row->ps_ora_enarxis,
                'ps_ora_lixis' => $row->ps_ora_lixis,
                'ao_nsn' => $row->ao_nsn,
                'merida' => $row->merida,
                'quantity' => $row->quantity,
                'perigrafi' => $row->perigrafi,
                'sn' => $row->sn,
                'ao_nsn_prl' => $row->ao_nsn_prl,
                'merida_prl' => $row->merida_prl,
                'perigrafi_prl' => $row->perigrafi_prl,
                'ao_nsn_rock_mis_assistant' => $row->ao_nsn_rock_mis_assistant,
                'merida_rock_mis_assistant' => $row->merida_rock_mis_assistant,
                'perigrafi_rock_mis_assistant' => $row->perigrafi_rock_mis_assistant,
                'egatastasis_ktiria' => $row->egatastasis_ktiria,
                'kairos' => $row->kairos,
                'topikes_arxes_ekav' => $row->topikes_arxes_ekav,
                'topikes_arxes_elas' => $row->topikes_arxes_elas,
                'topikes_arxes_limeniko' => $row->topikes_arxes_limeniko,
                'topikes_arxes_pyrosvestiki' => $row->topikes_arxes_pyrosvestiki,
                'anagnorisi' => $row->anagnorisi,
                'exoudeterosi' => $row->exoudeterosi,
                'perisillogi' => $row->perisillogi,
                'metafora' => $row->metafora,
                'katastrofi' => $row->katastrofi,
                'elegxos_estias' => $row->elegxos_estias,
                'paratiriseis' => $row->paratiriseis,
                'zimies' => $row->zimies,
                'epikefalis' => $row->epikefalis,
                'status_id' => $row->status_id,
                'status_var' => $row->status_var
            ));
        }
        return $results;
    }

    //Update 
    public function edit_Instance($peristatiko_id, $data) {

        $this->db->where('peristatiko_id', $peristatiko_id);
        $this->db->update('peristatiko', $data);
    }

    public function getPeristatiko() {
        $query = $this->db->query("SELECT * FROM peristatiko ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'peristatiko_id' => $row->peristatiko_id
            ));
        }
        return $results;
    }

    function searchPeristatiko($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko_id', 'peristatiko_id', 'peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query

        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getViewAllUsers() {
        $query = $this->db->query("SELECT * FROM personal_details "
                . " LEFT JOIN monada ON personal_details.monada_id=monada.monada_id");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'personal_details_id' => $row->personal_details_id,
                'pd_vathmos' => $row->pd_vathmos,
                'pd_oplo_soma' => $row->pd_oplo_soma,
                'pd_onoma' => $row->pd_onoma,
                'pd_eponimo' => $row->pd_eponimo,
                'pd_am' => $row->pd_am,
                'monada_id' => $row->monada_id,
                'monada_name' => $row->monada_name,
                'roles_id' => $row->roles_id,
                'pd_username' => $row->pd_username,
                'pd_password' => $row->pd_password,
                'choosenWord' => $row->choosenWord
            ));
        }
        return $results;
    }

    function searchViewAllUsers($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'desc') ? 'desc' : 'asc';
        $sort_colums = array('personal_details_id', 'pd_vathmos', 'pd_oplo_soma', 'pd_onoma', 'pd_eponimo',
            'pd_am', 'monada_name', 'roles_id', 'pd_username', 'choosenWord');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'roles_id';

        $query = $this->db->select('*')
                ->join('monada', 'monada.monada_id = personal_details.monada_id', 'left outer')
                ->from('personal_details')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query



        $query = $this->db->count_all('personal_details');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getPersonalDetailsTotal($personal_details_id) {
        $query = $this->db->query("SELECT * FROM personal_details "
                . " LEFT JOIN monada ON monada.monada_id=personal_details.monada_id"
                . " WHERE personal_details_id='" . $personal_details_id . "' ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'personal_details_id' => $row->personal_details_id,
                'pd_vathmos' => $row->pd_vathmos,
                'pd_oplo_soma' => $row->pd_oplo_soma,
                'pd_onoma' => $row->pd_onoma,
                'pd_eponimo' => $row->pd_eponimo,
                'pd_am' => $row->pd_am,
                'monada_id' => $row->monada_id,
                'monada_name' => $row->monada_name,
                'eod' => $row->eod,
                'roles_id' => $row->roles_id,
                'pd_username' => $row->pd_username,
                'pd_password' => $row->pd_password,
                'choosenWord' => $row->choosenWord
            ));
        }
        return $results;
    }

    public function getUserTotalStatistics() {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
                //. "AND "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    function searchUserTotalStatistics($sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('monada', 'personal_details.monada_id = monada.monada_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('katanomi_armodiotiton', 'katanomi_armodiotiton.katanomi_armodiotiton_id = peristatiko.katanomi_armodiotiton_id', 'left outer')
                ->join('katigoria_sumbantos', 'katigoria_sumbantos.katigoria_sumvantos_id = peristatiko.katigoria_sumvantos_id', 'left outer')
                ->join('eidos_sumvantos', 'eidos_sumvantos.eidos_sumvantos_id = peristatiko.eidos_sumvantos_id', 'left outer')
                ->join('eidos_puromaxikou', 'eidos_puromaxikou.eidos_puromaxikou_id = peristatiko.eidos_puromaxikou_id', 'left outer')
                ->join('katigoria_proteraiotitas', 'katigoria_proteraiotitas.katigoria_proteraiotitas_id = peristatiko.katigoria_proteraiotitas_id', 'left outer')
                ->join('thesi_sumvantos', 'thesi_sumvantos.thesi_simvantos_id = peristatiko.thesi_simvantos_id', 'left outer')
                ->join('peristatiko_ekriktika', 'peristatiko_ekriktika.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('ekriktika_lot', 'peristatiko_ekriktika.ekriktika_lot_id = ekriktika_lot.ekriktika_lot_id', 'left outer')
                ->join('ekriktika', 'ekriktika_lot.ekriktika_id = ekriktika.ekriktika_id', 'left outer')
                ->join('peristatiko_exoplismos', 'peristatiko_exoplismos.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('exoplismos', 'peristatiko_exoplismos.exoplismos_id = exoplismos.exoplismos_id', 'left outer')
                //->where('personal_details.pd_username', $username)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order)
                ->group_by('peristatiko.peristatiko_id');
        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    function SearchStatistics($text_search, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');

        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getStatistics($date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " WHERE peristatiko.ps_date between '" . $date_before . "' AND '" . $date_after . "' "
                . " ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id
            ));
        }
        return $results;
    }

    function SearchInstancesStatistics($date_before, $date_after, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->where('ps_date >=', $date_before)
                ->where('ps_date <=', $date_after)
                ->where('status_id', 4)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');
        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getUnitStatistics($monada_id, $date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " LEFT JOIN monada ON personal_details.monada_id = monada.monada_id "
                . " WHERE personal_details.monada_id ='" . $monada_id . "'   "
                . " OR (ps_date between '" . $date_before . "'AND '" . $date_after . "' ) "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id
            ));
        }
        return $results;
    }

    function SearchInstancesUnitStatistics($monada_id, $date_before, $date_after, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('monada', 'personal_details.monada_id = monada.monada_id', 'left outer')
                ->where('personal_details.monada_id', $monada_id)
                ->where('ps_date >=', $date_before)
                ->where('ps_date <=', $date_after)
                ->where('status_id', 4)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');
        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getUnitTotalStatistics($monada_id, $date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " LEFT JOIN monada ON personal_details.monada_id = monada.monada_id "
                . " WHERE personal_details.monada_id ='" . $monada_id . "'   "
                . " OR (ps_date between '" . $date_before . "'AND '" . $date_after . "' ) "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    public function getUserStatistics($personal_details_id, $date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " LEFT JOIN monada ON personal_details.monada_id = monada.monada_id "
                . " WHERE personal_details.personal_details_id ='" . $personal_details_id . "'   "
                . " OR (ps_date between '" . $date_before . "'AND '" . $date_after . "' ) "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id
            ));
        }
        return $results;
    }

    function SearchInstancesUserStatistics($personal_details_id, $date_before, $date_after, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('monada', 'personal_details.monada_id = monada.monada_id', 'left outer')
                ->where('personal_details.personal_details_id', $personal_details_id)
                ->where('ps_date >=', $date_before)
                ->where('ps_date <=', $date_after)
                ->where('status_id', 4)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');
        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

    public function getUTotalStatistics($personal_details_id, $date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " LEFT JOIN monada ON personal_details.monada_id = monada.monada_id "
                . " WHERE personal_details.personal_details_id ='" . $personal_details_id . "'   "
                . " OR (ps_date between '" . $date_before . "'AND '" . $date_after . "' ) "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    public function getTotalSearchStatistics($date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " WHERE (ps_date between '" . $date_before . "'AND '" . $date_after . "') "
                . " ");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    public function getOverUnitTotalStatistics($sximatismos_id, $date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " LEFT JOIN monada ON personal_details.monada_id = monada.monada_id "
                . " LEFT JOIN sximatismos ON sximatismos.monada_id = monada.monada_id "
                . " WHERE sximatismos.sximatismos_id ='" . $sximatismos_id . "'   "
                . " OR (ps_date between '" . $date_before . "'AND '" . $date_after . "' ) "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'personal_details_id' => $row->personal_details_id
            ));
        }
        return $results;
    }

    public function getOverUnitStatistics($sximatismos_id, $date_before, $date_after) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . " LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . " LEFT JOIN monada ON personal_details.monada_id = monada.monada_id "
                . " LEFT JOIN sximatismos ON sximatismos.monada_id = monada.monada_id "
                . " WHERE sximatismos.sximatismos_id ='" . $sximatismos_id . "'   "
                . " OR (ps_date between '" . $date_before . "'AND '" . $date_after . "' ) "
                . "");
        $results = array();
        foreach ($query->result() as $row) {
            array_push($results, array(
                'peristatiko_id' => $row->peristatiko_id,
                'sximatismos_id' => $row->sximatismos_id
            ));
        }
        return $results;
    }

    function SearchInstancesOverUnitStatistics($sximatismos_id, $date_before, $date_after, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('monada', 'personal_details.monada_id = monada.monada_id', 'left outer')
                ->join('sximatismos', 'sximatismos.monada_id = monada.monada_id', 'left outer')
                ->where('sximatismos.sximatismos_id', $sximatismos_id)
                ->where('ps_date >=', $date_before)
                ->where('ps_date <=', $date_after)
                ->where('status_id', 4)
                ->limit($limit, $offset)
                ->order_by($sort_by, $sort_order);

        $ret['rows'] = $query->get()->result();
        //count query
        $query = $this->db->count_all('peristatiko');
        $tmp = $query;
        $ret['num_rows'] = $tmp;
        return $ret;
    }

}
