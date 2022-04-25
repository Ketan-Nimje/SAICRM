<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gstkey extends CI_Controller {

    private $tbl = "si_gstkey";
    private $controll = "Gstkey";

    public function __construct() {
        parent::__construct();
        $this->Validation();
    }

    public function Validation() {
        if ($this->session->userdata('id') == null) {
            redirect(base_url());
        }	
    }

    public function index() {
        //$data['group'] = $this->Data_model->Custome_query("select * from of_group where status !='B'");        
        $this->load->view('Admin/' . $this->controll);
    }

    public function addData() {
        extract($_REQUEST);
		
		if(!isset($_REQUEST) || empty($_REQUEST)){
				 redirect(base_url() . 'Admin/' . $this->controll . '');
			}
			
        
        $data = array(
            'gstkey' => $gstkey,
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );        
        if(isset($hid) && $hid != "")
        {
            $con = array($this->tbl.'_id' => $hid);            
            $id = $this->Data_model->Update_data($this->tbl, $con, $data);
            $sessdata =array('error' => '<strong>Success!</strong> Update Gst Key.', 'errorcls' => 'alert-success');
        }  
        else
        {
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('gstkey', 'Gstkey', 'callback_customNumericdash|required|is_unique[si_gstkey.gstkey]');
			if ($this->form_validation->run() == FALSE)
			{
				$sessdata =array('error' => '<strong>Error!</strong> GST key Must Be Unique.', 'errorcls' => 'alert-danger'); 
				$this->session->set_flashdata($sessdata);	  
				redirect(base_url() . 'Admin/' . $this->controll . '');
			}
			
            $id = $this->Data_model->Insert_data_id($this->tbl, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New GST Key.', 'errorcls' => 'alert-success'];
        }
        $this->session->set_flashdata($sessdata);
        redirect(base_url() . 'Admin/' . $this->controll . '');
    }
	
	public function customNumericdash($str){
				if ( !preg_match('/^[0-9 \-]+$/i',$str) )
				{
					return false;
				}
				else{
					return true;
					}
				
		}
    
	public function GetData() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'gstkey',
        );

        $sql = "select * from " . $this->tbl . " where status!='B'";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR gstkey LIKE '" . $requestData['search']['value'] . "%' )";
        }
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;


        foreach ($query as $dt) {
            $nestedData = array();
            $edit = "<a class='edit' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'>Edit <span class='fa-stack'><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span></button></a>";
            $delete = "<a class='delete' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' ><button class='btn btn-xs btn-danger'>Delete <span class='fa-stack'> <i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";
            //1 : updatation 2 : installtion 3 : lan 4 : conversion
           
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['gstkey'];
            $nestedData[] =  $edit . "&nbsp" . $delete;
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
