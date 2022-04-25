<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HelpDesk extends CI_Controller {

    public $tbl = "si_helpdesk";
    public $controll = "HelpDesk";

    public function __construct() {
        parent::__construct();
        $this->Validation();
    }

    public function Validation() {
        if ($this->session->userdata('id') == "" || $this->session->userdata('role')!="SA") {
            redirect(base_url());
        }
    }

    public function index() {
        $data['helpdesk'] = $this->Data_model->Custome_query("select * from si_helpdesk where status like 'A'"); 
        $this->load->view('Admin/' . $this->controll,$data);
    }

    public function addData() {
        extract($_REQUEST);

        if(!isset($_REQUEST) OR empty($_REQUEST))
            redirect(base_url() . 'Admin/' . $this->controll . '');
        $data = [
            'l_name' => $l_name,
            'productid' => $productid,
            'updated_at' => date('Y-m-d H:s:i')
        ];        
        if(isset($hid) && $hid !="")
        {
            $data['up_file'] = $up_file;
            $con = [$this->tbl.'_id' => $hid];            
            $id = $this->Data_model->Update_data($this->tbl, $con, $data);
             $sessdata = ['error' => '<strong>Success!</strong> Update Helpdesk.', 'errorcls' => 'alert-success'];
        }  
        else
        {
        if(isset($checkradio) && $checkradio!="" && $checkradio!="0")
        {

//----------------------------
        $fileuploaded='';  
        if ($_FILES['up_file']['name'] != "") {

            $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
            $config['upload_path'] = str_replace("saicrm","assets/softwares",FCPATH);
            $config['allowed_types'] = '*';
            $config['max_size'] = '20480';
            $config['file_name'] = substr(str_shuffle($str_result),0,18).mt_rand(99999,99999999);

            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('up_file')) {
                $error = array('error' => $this->upload->display_errors());
                echo "<pre>"; print_r($error); die;
            } else {
                $nk = $this->upload->data();
                $fileuploaded = SITE_SOFTWARES_DIR.$nk['file_name'];
            }
        }

        $data['up_file'] = $fileuploaded;
        $data['created_at'] = date('Y-m-d H:s:i');
        $id = $this->Data_model->Insert_data_id($this->tbl, $data);
        $sessdata = ['error' => '<strong>Success!</strong> Add New Helpdesk.', 'errorcls' => 'alert-success'];

        //echo "<pre>"; print_r($filen);die;

//----------------------------------
        }
        else
        {
            $data['up_file'] = $up_file;
            $data['created_at'] = date('Y-m-d H:s:i');
            $id = $this->Data_model->Insert_data_id($this->tbl, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New Helpdesk.', 'errorcls' => 'alert-success'];
        }
        }
        $this->session->set_flashdata($sessdata);
        redirect(base_url() . 'Admin/' . $this->controll . '');
    }


    public function GetData() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'l_name',
            2 => 'up_file',
            3 => $this->tbl . '_id',
        );

        $sql = "select * from " . $this->tbl . " where status!='B'";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR l_name LIKE '" . $requestData['search']['value'] . "%' )";
        }
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;


        foreach ($query as $dt) {
            $nestedData = array();
            if ($dt['status'] == "A"):
                $sts = "<a class='status' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $sts = "<a class='status' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            endif;
            $edit = "<a class='edit' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span></button></a>";
            $delete = "<a class='delete' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";
            
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['l_name'];
            $nestedData[] = "<a href='".$dt['up_file']."'>".$dt['up_file']."</a>";
            $nestedData[] = $sts . "&nbsp" . $edit . "&nbsp" . $delete;
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
