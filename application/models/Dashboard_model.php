<?php
/* 
 * Created by Ishwar 1-Sep-2021
 */
 
class Dashboard_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get product count by status
     */
    function get_records($table, $where = array(), $limit = 0)
    {
        $this->db->order_by('create_date', 'desc');
        $this->db->where($where);
        if ($limit > 0) $this->db->limit($limit);
        return $this->db->get($table)->result_array();
    }

    /*
     * Get product count by status
     */
    function get_records_count($table, $where = array())
    {
        $this->db->where($where);
        $this->db->from($table);
        return $this->db->count_all_results();
    }
        
    /*
     * Get all dashboard
     */
    function get_all_records($table)
    {
        $this->db->order_by('id', 'desc');
        return $this->db->get($table)->result_array();
    }

    /**
     * Run update query
     */
    function update($table, $con, $data) {
        $data['modify_date'] = date('Y-m-d H:i:s');
        $this->db->where($con);        
        return $this->db->update($table, $data);
    }
}
