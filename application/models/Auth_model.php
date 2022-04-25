<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function login($data) {

        $this->db->from(SI_ADMIN);
        $this->db->where_in('status', ['A', 'D']);
        $this->db->where("(email='" . $data['username'] . "' OR username='" . $data['username'] . "')");
        $this->db->order_by(SI_ADMIN . '_id', 'desc');
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return false;
        } else {
            //Compare the password attempt with the password we have stored.
            $result = $query->row_array();
            if ($data['password'] == $result['password']) {
                return $result = $query->row_array();
            }
        }
    }

}

?>