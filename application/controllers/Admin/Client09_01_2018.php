<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Client extends CI_Controller {
    public $tbl = "si_clients";
    public $controll = "Client";
	private $clientdetailtbl="si_clients_details";
	
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
		if(empty($si_product_id) || $si_product_id[0]==0){
				
				$sessdata =array('error' => '<strong>Error!</strong> Product Not Selected.', 'errorcls' => 'alert-danger');
				$this->session->set_flashdata($sessdata);
				redirect(base_url() . 'Admin/' . $this->controll . '');
			}

        $data = array(            
            'contact_person'=>$contact_person,
            'firm_name'=>$firm_name,
            'address'=>$address,
            'address1'=>$address1,
            'area'=>$area,
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
         $p_items = array(            
            'si_clients_id'=>$hid,
            'si_product_id'=>$si_product_id[$i],
            'si_conversion_product_id'=>$si_conversion_product_id[$i],
            'laptop'=>$laptop[$i],
            'category_id'=>$category_id[$i],
            'reg_type'=>$reg_type[$i],
            'si_for_year_id'=>$si_for_year_id[$i],
            'serial_no'=>$serial_no[$i],
            'activation_code'=>$activation_code[$i],  
			'lan_type'=>$s_pc[$i],
            'total_lan'=>$total_lan[$i],
			'si_gstkey_id'=>$gstkeyid,
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );  
            
        endif;   
        }  
		
		if(!empty($p_items))
        {		
			$p_id = $this->Data_model->Insert_data_id('si_clients_details', $p_items);
                for ($j = 0; $j < count($si_for_year_id); $j++) {
                $product = array(
                'si_clients_details_id'=>$p_id,    
                'purchase_year'=>$si_for_year_id[$j],
                'purchase_date'=> date('Y-m-d H:s:i',strtotime($purchase_date[$j])),
                'renewal_date'=> date('Y-m-d H:s:i',strtotime($last_renewal_date[$j])),
                'created_at' => date('Y-m-d H:s:i'),
                'updated_at' => date('Y-m-d H:s:i')
                    );
                }
                if(!empty($product))
                {       
                    $purchase_id = $this->Data_model->Insert_data_id('si_product_purchase', $product);
                }            
        }
        $this->session->set_flashdata($sessdata);
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

	
    public function get_client_product_by_id(){
         extract($_REQUEST);
         $data['product_detail'] = $this->Data_model->Custome_query("select * from si_clients_details where si_clients_id = ".$si_clients_id." and status like 'A'");
          echo json_encode($data);
    }
	
	
	
	public function get_client_all_product(){
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
            7 => 'cd.total_lan',
			8 => 'cd.reg_type',
            9 => 'cd.status',
          
        );

        $sql = "select cd.si_clients_details_id as si_clients_details_id,fy.yearname as foryear, p.p_name as productname, pp.purchase_year as purchyear,pp.purchase_date as purchasedate,pp.renewal_date as renewdate,cd.activation_code as activationcode,cd.serial_no as serialno,cd.total_lan as lantotal,cd.reg_type as regtype,cd.status as status
				 from " . $this->clientdetailtbl . " as cd 
				inner join si_product as p on p.si_product_id=cd.si_product_id
				left join si_product_purchase as pp on pp.si_clients_details_id=cd.si_clients_details_id
				left join si_for_year as fy on pp.purchase_year=fy.si_for_year_id
				where cd.si_clients_id='".$id."' and cd.status!='B'";
	
		
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( cd." . $this->clientdetailtbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
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
            if ($dt['status'] == "A"):
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            endif;
            $edit = "<a class='edit small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-plus fa-stack-1x fa-inverse'></i></span></button></a>";
              
           
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['productname'];
			$nestedData[] = $dt['foryear'];
            $nestedData[] = $dt['activationcode'];
			$nestedData[] = $dt['serialno'];
			$nestedData[] = date('d-m-Y',strtotime($dt['purchasedate']));
			$nestedData[] = date('d-m-Y',strtotime($dt['renewdate']));
			$nestedData[] = $dt['lantotal'];
			$nestedData[] = $dt['regtype']=="O"?$dt['regtype']="Online":$dt['regtype']="H Lock";
			$nestedData[] = $sts . "&nbsp";
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
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            endif;
            $edit = "<a class='edit small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-plus fa-stack-1x fa-inverse'></i></span></button></a>";
            $delete = "<a class='delete small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";           
           
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