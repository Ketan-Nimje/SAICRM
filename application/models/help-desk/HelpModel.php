<?php
/* 
 * Created by Ishwar 27-Mar-2022
 */
 
class HelpModel extends CI_Model
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
        $data['created_at'] = date('Y-m-d');
        $data['updated_at'] = date('Y-m-d');
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * Run delete query
     */
    function update($table, $con, $data) {
        $data['updated_at'] = date('Y-m-d');
        $this->db->where($con);        
        return $this->db->update($table, $data);
    }
}
