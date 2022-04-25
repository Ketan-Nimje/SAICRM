<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GstReport extends CI_Controller {

    public $tbl = "si_clients_details";
    public $controll = "GstReport";
    

    public function __construct() {
        parent::__construct();
        $this->Data_model->Validation();
    }

     public function index() {
         $data['product'] = $this->Data_model->Custome_query("select p_name from si_product where status like 'A' ");       
        $this->load->view('Admin/'.$this->controll,$data);
        }
    
    public function GetData() { 
        $requestData = $_REQUEST;
    
        $columns = array(
            0 => 's.si_clients_id',
            1 => 'c.contact_person',
            2 => 'c.registed_mobile',
            3 => 'c.register_email',
           );
       $sql = "SELECT  s.si_clients_id clid, s.si_product_id,c.contact_person,c.registed_mobile,c.register_email,s.GST_update_date  FROM ".$this->tbl." as s 
                    INNER JOIN si_clients as c on s.si_clients_id=c.si_clients_id  WHERE s.is_GST_new='Y' ";
    
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (  c.contact_person LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR c.register_email LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR c.registed_mobile LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR DATE_FORMAT(s.GST_update_date, '%d-%m-%Y')  LIKE '". $requestData['search']['value'] . "%' )";         
        } 
        $query = $this->Data_model->Custome_query($sql);
    
        $totalFiltered = count($query);
        if ($requestData['length'] != '-1')
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length        
        else
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;

        foreach ($query as $dt) {
            $nestedData = array();

            $nestedData[] = $cnt++;
            $nestedData[] = "<a href='".base_url('Admin/TransactionsDetail/add_payment_view?id='.$dt['clid'].'')."'>".$dt['contact_person']."</a>";            
            $nestedData[] = $dt['registed_mobile'];
            $nestedData[] = $dt['register_email'];
            if($dt['GST_update_date']!=NULL) {
            $nestedData[] = date('d-M-Y h:i A',strtotime($dt['GST_update_date']));
            } else {  $nestedData[] = NULL;  }
           
             $data[] = $nestedData;
        }
          
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
             echo json_encode($json_data);
    }
    
    
    public function getClientReport() {
        $requestData = $_REQUEST;
    
        $columns = array(
            0 => 's.si_clients_id',
            1 => 'c.contact_person',
            2 => 'c.registed_mobile',
            3 => 'c.register_email',
            4 => 'c.created_at',
           );
       $sql = "SELECT  s.si_clients_id clid,c.contact_person,c.registed_mobile,c.register_email,c.created_at  FROM si_transactions_detail as s 
                    INNER JOIN si_clients as c on s.si_clients_id=c.si_clients_id  WHERE s.p_name='".$requestData['p_name']."' ";
    
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (  c.contact_person LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR c.register_email LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR c.registed_mobile LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR DATE_FORMAT(c.created_at, '%d-%m-%Y')  LIKE '". $requestData['search']['value'] . "%' )";         
        } 
        $query = $this->Data_model->Custome_query($sql);
    
        $totalFiltered = count($query);
        if ($requestData['length'] != '-1')
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  
        else
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;

        foreach ($query as $dt) {
            $nestedData = array();

            $nestedData[] = $cnt++;
            $nestedData[] = "<a href='".base_url('Admin/TransactionsDetail/add_payment_view?id='.$dt['clid'].'')."'>".$dt['contact_person']."</a>";            
            $nestedData[] = $dt['registed_mobile'];
            $nestedData[] = $dt['register_email'];
            $nestedData[] = date('d-M-Y',strtotime($dt['created_at']));
        
           
             $data[] = $nestedData;
        }
          
        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
             echo json_encode($json_data);
    }
    
    
    

     
    
    
















}
