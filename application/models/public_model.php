<?php

Class Public_model extends CI_Model {
    #Authenticates the administrator account
    
    public function getViewInstanceOne($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
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

    function searchViewInstanceOne($peristatiko_id, $username, $sort_by, $sort_order, $limit, $offset) {
        //results
        $sort_order == ($sort_order == 'asc') ? 'desc' : 'asc';
        $sort_colums = array('peristatiko.peristatiko_id', 'personal_details_id');
        $sort_by = (in_array($sort_by, $sort_colums)) ? $sort_by : 'peristatiko.peristatiko_id';

        $query = $this->db->select('*')
                ->from('peristatiko')
                ->join('personal_details', 'personal_details.personal_details_id = peristatiko.personal_details_id', 'left outer')
                ->join('status', 'status.status_id = peristatiko.status_id', 'left outer')
                ->join('katanomi_armodiotiton', 'katanomi_armodiotiton.katanomi_armodiotiton_id = peristatiko.katanomi_armodiotiton_id', 'left outer')
                ->join('katigoria_sumbantos', 'katigoria_sumbantos.katigoria_sumvantos_id = peristatiko.katigoria_sumvantos_id', 'left outer')
                ->join('eidos_sumvantos', 'eidos_sumvantos.eidos_sumvantos_id = peristatiko.eidos_sumvantos_id', 'left outer')
                ->join('eidos_puromaxikou', 'eidos_puromaxikou.eidos_puromaxikou_id = peristatiko.eidos_puromaxikou_id', 'left outer')
                ->join('katigoria_proteraiotitas', 'katigoria_proteraiotitas.katigoria_proteraiotitas_id = peristatiko.katigoria_proteraiotitas_id', 'left outer')
                ->join('thesi_sumvantos', 'thesi_sumvantos.thesi_simvantos_id = peristatiko.thesi_simvantos_id', 'left outer')
                ->join('peristatiko_ekriktika', 'peristatiko_ekriktika.peristatiko_id = peristatiko.peristatiko_id', 'left outer')
                ->join('ekriktika_lot', 'peristatiko_ekriktika.ekriktika_lot_id = ekriktika_lot.ekriktika_lot_id', 'left outer')
                ->join('ekriktika', 'ekriktika.ekriktika_id = ekriktika_lot.ekriktika_id', 'left outer')
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

    public function getViewInstanceOneEkriktika($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
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
                ->join('ekriktika', 'ekriktika.ekriktika_id = ekriktika_lot.ekriktika_id', 'left outer')
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

    public function getViewInstanceOneExoplismos($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                //. "WHERE personal_details.pd_username='" . $username . "' "
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

    public function getViewInstanceOnePhotos($username, $peristatiko_id) {
        $query = $this->db->query("SELECT * FROM peristatiko "
                . "LEFT JOIN personal_details ON peristatiko.personal_details_id=personal_details.personal_details_id "
                . "LEFT JOIN uploads ON peristatiko.peristatiko_id=uploads.peristatiko_id "
               // . "WHERE personal_details.pd_username='" . $username . "' "
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

}
