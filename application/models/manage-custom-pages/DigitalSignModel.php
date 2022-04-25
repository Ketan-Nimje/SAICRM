<?php
/* 
 * Created by Ishwar 27-Mar-2022
 */
 
class DigitalSignModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Run custom query
     */
    function query($sql) {
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     * Run add query
     */
    function add($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * Run delete query
     */
    function update($table, $con, $data) {
        $this->db->where($con);        
        return $this->db->update($table, $data);
    }
}
