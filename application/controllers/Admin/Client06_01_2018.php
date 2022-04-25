<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Client extends CI_Controller {
    public $tbl = "si_clients";
    public $controll = "Client";

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
        $data['product'] = $this->Data_model->Custome_query("select * from si_product where status like 'A'");
        $data['for_year'] = $this->Data_model->Custome_query("select * from si_for_year where status like 'A'");
        $data['gstkey'] = $this->Data_model->Custome_query("select * from si_gstkey where status like 'A'");        
         $data['states'] = $this->Data_model->Custome_query("select * from si_state where status like 'A'");        
        $this->load->view('Admin/' . $this->controll,$data);
    }
    public function addData() {
        extract($_REQUEST);
        if(!isset($_REQUEST) || empty($_REQUEST)){
                 redirect(base_url() . 'Admin/' . $this->controll . '');
            }

        $data = array(            
            'contact_person'=>$contact_person,
            'firm_name'=>$firm_name,
            'address'=>$address,
            'si_state_id'=>$si_state_id,
            'city'=>$city,
            'pincode'=>$pincode,
            'registed_mobile'=>$registed_mobile,
            'register_email'=>$register_email,  
            'mobile1'=>$mobile1,
            'mobile2'=>$mobile2,
            'mobile3'=>$mobile3,
            'phone1'=>$phone1,
            'phone2'=>$phone2,
            'gstin_no'=>$gstin_no,
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );        
        if(isset($hid) && $hid != "")
        {
            $con = array($this->tbl.'_id' => $hid);            
            $clients_id = $this->Data_model->Update_data($this->tbl, $con, $data);
            $sessdata =array('error' => '<strong>Success!</strong> Update Client.', 'errorcls' => 'alert-success');
        }  
        else
        {
            $clients_id = $this->Data_model->Insert_data_id($this->tbl, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New Client.', 'errorcls' => 'alert-success'];
        }
		
		if($hid=="" || $hid==0){
				$hid=$clients_id;
			}
		 $p_items = [];
		
         for ($i = 0; $i < count($si_product_id); $i++) {
		 if(!empty($si_gstkey_id[$i])){
						$gstkeyid=$this->add_gst_id($si_gstkey_id[$i]);
					}
			else{
					$gstkeyid=0;
				}
                if($category_id[$i]==1):
         $p_items[] = array(            
            'si_clients_id'=>$hid,
            'si_product_id'=>$si_product_id[$i],
            'si_conversion_product_id'=>$si_conversion_product_id[$i],
            'laptop'=>$laptop[$i],
            'category_id'=>$category_id[$i],
            'reg_type'=>$reg_type[$i],
            'si_for_year_id'=>$si_for_year_id[$i],
            'serial_no'=>$serial_no[$i],  
            'total_lan'=>$total_lan[$i],
			'si_gstkey_id'=>$gstkeyid,
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );  
        endif;   
        }  
		
		if(!empty($p_items))
        {		
			$this->add_client_detail($p_items);
        }
        $this->session->set_userdata($sessdata);
        redirect(base_url() . 'Admin/' . $this->controll . '');
    }
	
	public function add_gst_id($gstkey){
				$gstdata=[];
				$gstdata=array(
					"gstkey"=>$gstkey,
					"status"=>"U"
				);
				$gstinsertid=$this->Data_model->Insert_data_id('si_gstkey',$gstdata);
				return $gstinsertid;
		}
	
    public function add_client_detail($p_items){

        /*if(isset($hpid) && $hpid != "")
        {
            $con = array($this->tbl.'_id' => $hpid);            
            $id = $this->Data_model->Update_batch('si_clients_details', $con, $p_items);
            //$sessdata =array('error' => '<strong>Success!</strong> Update Client Detail.', 'errorcls' => 'alert-success');
        }  
        else
        {*/	
			$id = $this->Data_model->Insert_batch('si_clients_details', $p_items);
            //$this->Data_model->Insert_data_id('si_clients_details', $data);
            //$sessdata = ['error' => '<strong>Success!</strong> Add Client Detail.', 'errorcls' => 'alert-success'];
        /*}*/
    }
	
	
    public function get_client_product_by_id(){
         extract($_REQUEST);
         $data['product_detail'] = $this->Data_model->Custome_query("select * from si_clients_details where si_clients_id = ".$si_clients_id." and status like 'A'");
          echo json_encode($data);
    }
	public function GetData() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'contact_person',
            2 => 'firm_name',
            3 => 'address',
            4 => 'city',
            5 => 'pincode',
            6 => 'registed_mobile',
            7 => 'register_email',
            8 => 'status',
            9 => 'created_at',
            10 => $this->tbl . '_id',
        );

        $sql = "select * from " . $this->tbl . " where status!='B'";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR contact_person LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR firm_name LIKE '" . $requestData['search']['value'] . "%' ";
            //$sql .= " OR address LIKE '" . $requestData['search']['value'] . "%' )";
            $sql .= " OR city LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR pincode LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR registed_mobile LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR register_email LIKE '" . $requestData['search']['value'] . "%' ) ";
            //$sql .= " OR created_at LIKE '" . $requestData['search']['value'] . "%' )";            
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
            $edit = "<a class='edit' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-plus fa-stack-1x fa-inverse'></i></span></button></a>";
            $delete = "<a class='delete' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";           
           
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['contact_person'];
            $nestedData[] = $dt['firm_name'];
            //$nestedData[] = $dt['address'];
            //$nestedData[] = $dt['city'];
            //$nestedData[] = $dt['pincode'];
            $nestedData[] = $dt['registed_mobile'];
            $nestedData[] = $dt['register_email'];
            //$nestedData[] = $dt['created_at'];
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
    public function get_client_edit_data()
    {
        extract($_POST);
        $con = array($tbl . '_id' => $id);
        $data['contact'] = $this->Data_model->Get_data_one($tbl, $con);
        $data['product'] = $this->Data_model->Custome_query("select dc.si_product_id,dp.p_name from si_clients_details dc inner join si_product dp on dc.si_product_id=dp.si_product_id where dc.si_clients_id=".$id." AND dc.status like 'A'");
        
        echo json_encode($data);
    }
    public function get_conversion_data()
    {
        extract($_POST);
        if(isset($all_p) && $all_p=="All")       
            $data['product'] = $this->Data_model->Custome_query("SELECT * FROM `si_product` WHERE status like 'A'");
        else
            $data['product'] = $this->Data_model->Custome_query("SELECT * FROM `si_product` WHERE `is_conversion_id` = 1 AND status like 'A'");
        
        echo json_encode($data);
    }
}
?>