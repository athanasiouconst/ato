<?php

Class Recoverymodel extends CI_Model {
    #Authenticates the administrator account

    public function user_exists($username, $pd_am, $choosenWord) {
        $result = $this->db->query("SELECT * FROM personal_details WHERE pd_username='" . $username . "' AND pd_am='" . $pd_am . "'  AND choosenWord='" . $choosenWord . "'");
        return $result->num_rows() == 1;
    }

    public function recovering($username, $pd_am,$choosenWord,$new_password) {
        $this->db->query("UPDATE personal_details SET pd_password='" . $new_password . "' WHERE pd_username='" . $username . "' AND pd_am='" . $pd_am . "' AND choosenWord='" . $choosenWord . "'");
        return $new_password;
    }
    public function searchPersonal($username, $pd_am, $choosenWord) {
        $result = $this->db->query("SELECT * FROM personal_details WHERE pd_username='" . $username . "' AND pd_am='" . $pd_am . "'  AND choosenWord='" . $choosenWord . "'");
        return $result->num_rows() == 1;
    }
}
