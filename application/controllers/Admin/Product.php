<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public $tbl = "si_product";
    public $controll = "Product";

    public function __construct() {
        parent::__construct();
        $this->Validation();
       // $this->ip_address();
    }
    function ip_address() 
    {        
        if (!in_array($_SERVER['REMOTE_ADDR'], config_item('proxy_ips')))
        { 
             redirect(base_url() . 'Dashboard');
        }        
    }

    public function Validation() {
        if ($this->session->userdata('id') == "" || $this->session->userdata('role')!="SA") {
            redirect(base_url());
        }
    }

    public function index() {
        $data['product'] = $this->Data_model->Custome_query("select * from si_product where status like 'A'"); 
        $this->load->view('Admin/' . $this->controll,$data);
    }

    public function addData() {
        extract($_REQUEST);
        if(!isset($_REQUEST) OR empty($_REQUEST))
            redirect(base_url() . 'Admin/' . $this->controll . '');
        $data = array(
            'p_name' => $p_name,
            'category_id' =>$category_id,
            'purchase_amount' =>$purchase_amount,
			'purchase_amount2' =>$purchase_amount2,
			//'purchase_amount3' =>$purchase_amount3,
			//'purchase_amount4' =>$purchase_amount4,
            'sale_amount' =>$sale_amount,
			'sale_amount2' =>$sale_amount2,
			//'sale_amount3' =>$sale_amount3,
			//'sale_amount4' =>$sale_amount4,
            'is_conversion_id'=> isset($conversion_id) ? $conversion_id : 0 ,
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );        
        if(isset($hid) && $hid != "")
        {
            $con = [$this->tbl.'_id' => $hid];            
            $id = $this->Data_model->Update_data($this->tbl, $con, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Update Product.', 'errorcls' => 'alert-success'];
        }  
        else
        {
            $id = $this->Data_model->Insert_data_id($this->tbl, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New Product.', 'errorcls' => 'alert-success'];
        }
        $this->session->set_flashdata($sessdata);
        redirect(base_url() . 'Admin/' . $this->controll . '');
    }

    public function GetData() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'name',
            2 =>'sale_amount',
            3 =>'purchase_amount',
            4 => $this->tbl . '_id',
        );

        $sql = "select * from " . $this->tbl . " where status!='B'";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p_name LIKE '" . $requestData['search']['value'] . "%' )";
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
            //1 : updatation 2 : installtion 3 : lan 4 : conversion
            if($dt['category_id']==1)
            $c_name='installation';
            elseif($dt['category_id']==2)
            $c_name='updatation';
            elseif($dt['category_id']==3)
            $c_name='lan';
            elseif($dt['category_id']==4)
            $c_name='conversion';
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['p_name'];            
            $nestedData[] = $c_name;
            $nestedData[] = $dt['sale_amount'];
            $nestedData[] = $dt['purchase_amount'];
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
