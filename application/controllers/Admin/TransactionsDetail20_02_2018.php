<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionsDetail extends CI_Controller {

    private $tbl = "si_transactions_detail";
    private $controll = "TransactionsDetail";

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
        //$data['group'] = $this->Data_model->Custome_query("select * from of_group where status !='B'");       
        $data['client'] = $this->Data_model->Custome_query("SELECT si_clients_id,contact_person FROM si_clients where status= 'A' ");
        $data['for_year'] = $this->Data_model->Custome_query("SELECT si_for_year_id,yearname FROM si_for_year where status= 'A'");
        $this->load->view('Admin/' . $this->controll,$data);
    }
    public function add_payment_view()
    {
        extract($_REQUEST);
        $tbl='si_clients';
        $con = array($tbl . '_id' => $id);
        $data['contact'] = $this->Data_model->Get_data_one($tbl, $con);
        $data['product'] =$this->Data_model->Custome_query("SELECT cp.si_clients_details_id,p.p_name FROM `si_clients_details` as cp inner join si_product as p on p.si_product_id=cp.si_product_id WHERE cp.`si_clients_id` =".$id);
        // $this->Data_model->Custome_query("select dc.si_product_id,dp.p_name from si_clients_details dc inner join si_product dp on dc.si_product_id=dp.si_product_id where dc.si_clients_id=" . $id . " AND dc.status like 'A'"); 
        $data['for_year'] = $this->Data_model->Custome_query("select * from si_for_year where status like 'A'");
        //echo "<pre>";
        //print_r($data);die;
         $this->load->view('Admin/add_payment_view',$data);
    }
    public function addData() {
        extract($_REQUEST);
		if(!isset($isbill))
            $isbill=0;
        if(!isset($_REQUEST) || empty($_REQUEST)){
				 redirect(base_url() . 'Admin/' . $this->controll . '');
			}
            $data['client'] = $this->Data_model->Custome_query("SELECT p.p_name FROM si_clients_details as s inner join si_product as p on p.si_product_id=s.si_product_id WHERE s.si_clients_details_id=".$si_clients_details_id);
            $p_name=$data['client'][0]['p_name'];
        $data = array(            
            'si_clients_id' =>$si_clients_id,
            'si_clients_details_id'=>$si_clients_details_id,
            'amount' =>$amount,
            'for_year'=>$for_year,
            'p_name'=>$p_name,
            'payment_type' =>$payment_type,
            'is_bill'=>$isbill,
            'billnumber'=>$billnumber,
            'billremarks'=>$billremarks,
            'status'=>'A',
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );        
        if(isset($hid) && $hid != "")
        {
            $con = array($this->tbl.'_id' => $hid);            
            $id = $this->Data_model->Update_data($this->tbl, $con, $data);
             $sessdata =array('error' => '<strong>Success!</strong> Update TransactionsDetail.', 'errorcls' => 'alert-success');
        }  
        else
        {
            $id = $this->Data_model->Insert_data_id($this->tbl, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New TransactionsDetail.', 'errorcls' => 'alert-success'];
        }
        $this->session->set_userdata($sessdata);
        redirect(base_url() . 'Admin/' . $this->controll . '');
    }
    public function get_product(){
       extract($_REQUEST);
       $data['product'] = $this->Data_model->Custome_query("SELECT cp.si_clients_details_id,p.p_name FROM `si_clients_details` as cp inner join si_product as p on p.si_product_id=cp.si_product_id WHERE cp.`si_clients_id` =".$si_clients_id);             
       
       echo json_encode($data);
    }

    public function GetData() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'cd.contact_person', 
            2 => 'p.p_name',
            3 => 'for_year',
            4 => 'amount',
            5 => 'payment_type',                        
            6 => 'billremarks',            
            7 => 'created_at',
        );

        //$sql = "select * from " . $this->tbl . " where status!='B'";
        $sql = "SELECT cd.contact_person,cp.si_product_id,p.p_name,td.* FROM " . $this->tbl . " as td 
inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
inner join si_product as p on p.si_product_id=cp.si_product_id where td.status!='B'";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.contact_person LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR td.amount LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR td.for_year LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR td.payment_type LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR td.billremarks LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR td.created_at LIKE '" . $requestData['search']['value'] . "%' )";
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
            $nestedData[] = $dt['contact_person'];
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['for_year'];
            $nestedData[] = $dt['amount'];
            $nestedData[] = $dt['payment_type'];
            $nestedData[] = $dt['billremarks'];
            $nestedData[] = $dt['created_at'];
            $nestedData[] =  $sts . "&nbsp" . $edit . "&nbsp" . $delete;
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
    public function get_all_product()
    {
     extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'cd.si_clients_details_id',
            1 => 'p.p_name',
            2 => 'pp.purchase_year',
            3 => 'pp.purchase_date',
            4 => 'pp.renewal_date',
            5 => 'cd.activation_code',
            6 => 'cd.serial_no',
            7 => 'cd.lan_type',
            8 => 'cd.total_lan',
            9 => 'cd.reg_type',
            10 => 'cd.status',
        );

        $sql = "select cd.si_clients_details_id as si_clients_details_id,fy.yearname as foryear, p.p_name as productname, pp.purchase_year as purchyear,pp.purchase_date as purchasedate,pp.renewal_date as renewdate,cd.activation_code as activationcode,cd.serial_no as serialno,cd.lan_type as lantype,cd.total_lan as lantotal,cd.reg_type as regtype,cd.status as status,cd.attach_file
                 from si_clients_details as cd 
                inner join si_product as p on p.si_product_id=cd.si_product_id
                left join si_product_purchase as pp on pp.si_clients_details_id=cd.si_clients_details_id
                left join si_for_year as fy on pp.purchase_year=fy.si_for_year_id
                where cd.si_clients_id='" . $id . "' and cd.status!='B'";


        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( cd.si_clients_details_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR fy.yearname LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR pp.renewal_date LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR pp.purchase_date LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.activation_code LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.serial_no LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.reg_type LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.total_lan LIKE '" . $requestData['search']['value'] . "%' ) ";
        }

        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
        foreach ($query as $dt) {
            $nestedData = array();
            
            //$view = "<a class='edit small-btn' data-id='" . $dt['si_clients_details_id'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-eye fa-stack-1x fa-inverse'></i></span></button></a>";
             $view = "<a class='edit small-btn' data-id='" . $dt['si_clients_details_id'] . "' data-status='" . $dt['status'] . "' title='View Product'><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-eye fa-stack-1x fa-inverse'></i></span></button></a>";
            $st = $dt['attach_file'] != "" ? "Y" : "N";

            $file = $dt['attach_file'] != "" ? "<a href='" . base_url('assetss/upload/files/') . $dt['attach_file'] . "' download>Download File</a>" : "Not Yet Attached!";
            
            if ($dt['lantype'] == 0) {
                $lantype = "Decl Without Srv";
                $file = "-";
                $attach = "";
            } else if ($dt['lantype'] == 1) {
                $lantype = "Decl With Srv";
                $attach = "<a class='attach small-btn' data-id='" . $dt['si_clients_details_id'] . "' data-status='" . $st . "'><button class='btn btn-xs btn-primary'><span class='fa-stack'><i class='fa fa-files-o fa-stack-1x fa-inverse'></i></span></button></a>";
            } else if ($dt['lantype'] == 2) {
                $lantype = "Lan";
                $attach = "<a class='attach small-btn' data-id='" . $dt['si_clients_details_id'] . "' data-status='" . $st . "'><button class='btn btn-xs btn-primary'><span class='fa-stack'><i class='fa fa-files-o fa-stack-1x fa-inverse'></i></span></button></a>";
                
            }
//            echo $file;
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['productname'];
            $nestedData[] = $dt['foryear'];
            $nestedData[] = $dt['activationcode'];
            $nestedData[] = $dt['serialno'];
            $nestedData[] = date('d-m-Y', strtotime($dt['purchasedate']));
            $nestedData[] = date('d-m-Y', strtotime($dt['renewdate']));
            $nestedData[] = $lantype;
            $nestedData[] = $dt['lantotal'];
            $nestedData[] = $dt['regtype'] == "O" ? $dt['regtype'] = "Online" : $dt['regtype'] = "H Lock";
            $nestedData[] = $file;
            $nestedData[] = $view;
            $nestedData["DT_RowId"] = "Rows_id".$dt['si_clients_details_id'];
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
    public function get_product_all_purchese() {
        extract($_REQUEST);

        $sql = "select cd.si_clients_details_id as si_clients_details_id,cd.for_year as foryear, cd.p_name as productname,cd.created_at as renewdate,cd.amount,cd.payment_type,cd.billremarks
                 from si_transactions_detail as cd 
                 where cd.si_clients_id='" . $s_id . "' and cd.si_clients_details_id='" . $id . "' and cd.status!='B'";


        $query = $this->Data_model->Custome_query($sql);


        if (count($query) > 0) {
            $tbl = "<tr id='dynOrderRow' data-id='" . $id . "'><td colspan='28'><table id='editable' class='table table-bordered cursor-auto noselect selectlast-two'><tr><th>#</th><th>Product Name</th><th>Purchase Year</th><th>Purchase date</th><th>Amount</th><th>Payment Type</th><th>Remarks</th></tr>";
            $i = 1;
            foreach ($query as $dt) {

                $tbl .= "<tr data-id='" . $i . "' class='dynrow'>"
                        . "<td>" . $i . "</td>"
                        . "<td>" . $dt['productname'] . "</td>"
                        . "<td>" . $dt['foryear'] . "</td>"                        
                        . "<td>" . $dt['renewdate'] . "</td>"              
                        . "<td>" . $dt['amount'] . "</td>"              
                        . "<td>" . $dt['payment_type'] . "</td>"              
                        . "<td>" . $dt['billremarks'] . "</td>"              

                        . "</tr>";
                $i++;
            }
            $tbl .="</table></td></tr>";
            echo $tbl;
            die;
        } else {
            echo $tbl = '';
        }
    }
}
