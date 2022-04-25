<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionsDetail extends CI_Controller {

    private $tbl = "si_transactions_detail";
    private $controll = "TransactionsDetail";

    public function __construct() {
        parent::__construct();
        $this->Validation();
        //$this->ip_address();
    }
    function ip_address() 
    {        
        if (!in_array($_SERVER['REMOTE_ADDR'], config_item('proxy_ips')))
        { 
             redirect(base_url() . 'Dashboard');
        }        
    }

    public function Validation() {
      /*   if ($this->session->userdata('id') == "" ||$this->session->userdata('role')!="TL"|| $this->session->userdata('role')!="SA") {
            redirect(base_url());
        }*/
         if ($this->session->userdata('id') == "" ) {
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
		
		$data=[];

        $tbl='si_clients';
		
        if(isset($id)){
			
        $id=intval($id);
		
        $con = array($tbl . '_id' => $id);
        $data['contact'] = $this->Data_model->Get_data_one($tbl, $con);
		
		//echo "<pre>"; print_r($data['contact']['si_state_id']); die;
		
        $Convertion="SELECT si_conversion_product_id as p_id FROM `si_clients_details` WHERE si_clients_id = ".$id;
        $convertionquery = $this->Data_model->Custome_query($Convertion);
        if(count($convertionquery)==0) {  redirect(base_url()); }

        /*if($convertionquery[0]['p_id']!= 0)
            $c_pid="inner join si_product as p on p.si_product_id=cp.si_conversion_product_id";
        else*/
            $c_pid="inner join si_product as p on p.si_product_id=cp.si_product_id";
			
		$sql = "SELECT cp.si_clients_details_id,p.p_name, p.si_product_id as product_id, p.sale_amount, p.purchase_amount FROM si_clients_details as cp ".$c_pid." WHERE cp.si_clients_id=".$id." and cp.status!='B' and cp.status!='P'";
        
        /*if($convertionquery[0]['p_id']!= 0)            
        {
            $sql = "SELECT cp.si_clients_details_id,p.p_name, p.si_product_id as product_id, p.sale_amount, p.purchase_amount FROM si_clients_details as cp inner join si_product as p on p.si_product_id=cp.si_conversion_product_id WHERE cp.si_clients_id=".$id." and cp.status!='B' and cp.status!='P'";
        }*/
        $data['product'] =$this->Data_model->Custome_query($sql);
        }
       
        $data['states'] = $this->Data_model->Custome_query("select * from si_state where status like 'A'");
        $data['for_year'] = $this->Data_model->Custome_query("select * from si_for_year where status like 'A'");
        $data['admin'] = $this->Data_model->Custome_query("select name from si_admin where status='A'");
        $this->load->view('Admin/add_payment_view',$data);
        
    }
	
	
    public function addData() {  extract($_REQUEST);
        if(!isset($_REQUEST) || empty($_REQUEST)){
                 redirect(base_url() . 'Admin/' . $this->controll . '');
        }
		
		if(isset($_FILES['declaration_attachment_file']) && $_FILES['declaration_attachment_file']['name']!='') {
			$rd = $this->rd(12);
			$NameOrigonal = str_replace(" ", "-", $_FILES['declaration_attachment_file']['name']);
        	$imgx = explode(".", $NameOrigonal);
        	$imageName = str_replace($imgx[0], $rd , $NameOrigonal);
			$UploadPath = FCPATH . 'assetss/Declaration_files/';
			$config['upload_path'] = $UploadPath;
            $config['allowed_types'] = 'pdf|jpg|png|jpeg';
			$config['overwrite'] = TRUE;
			$config['max_size']     = '5050';
			$config['file_name'] = "SD".$imageName;
			$this->load->library('upload', $config);
            $this->upload->do_upload('declaration_attachment_file');
            $filename = $this->upload->data();
		}
		$declaration_attachment_file_name = isset($filename['file_name']) ? $filename['file_name'] : NULL;
		
			
       if ($category_id[0] == 1):
       if (empty($si_clients_details_id) || $si_clients_details_id[0] == 0) {
            $sessdata = array('error' => '<strong>Error!</strong> Product Not Selected.', 'errorcls' => 'alert-danger');
            $this->session->set_flashdata($sessdata);
            redirect(base_url() . 'Admin/' . $this->controll . '');
        }

        $data = array(
            'contact_person' => $contact_person,
            'firm_name' => $firm_name,
            'address' => $address,
            'address1' => $address1,
            'area' => $area,
            'si_state_id' => $si_state_id,
            'city' => $city,
            'pincode' => $pincode,
            'registed_mobile' => $registed_mobile,
            'register_email' => $register_email,
            'mobile1' => $mobile1,
            'mobile2' => $mobile2,
            'mobile3' => $mobile3,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'gstin_no' => $gstin_no,
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );
        if (isset($si_clients_id) && $si_clients_id != "") {
            $con = array('si_clients_id' => $si_clients_id);
            $clients_id = $this->Data_model->Update_data('si_clients', $con, $data);
            $sessdata = array('error' => '<strong>Success!</strong> Update Client.', 'errorcls' => 'alert-success');
        } else {
            $clients_id = $this->Data_model->Insert_data_id('si_clients', $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New Client.', 'errorcls' => 'alert-success'];
        }

        if ($si_clients_id == "" || $si_clients_id == 0) {
            $si_clients_id = $clients_id;
        }     

        $p_items = [];

        for ($i = 0; $i < count($si_clients_details_id); $i++) {
            if (!empty($si_gstkey_id[$i])) {
                $gstkeyid = $this->add_gst_id($si_gstkey_id[$i]);
            } else {
                $gstkeyid = 0;
            }

            if ($category_id[$i] == 1):
                $p_items = array(
                    'si_clients_id' => $si_clients_id,
                    'si_product_id' => $si_clients_details_id,
                    'si_conversion_product_id' => $si_conversion_product_id[$i],
                    'laptop' => $laptop[$i],
                    'category_id' => $category_id[$i],
                    'reg_type' => $reg_type[$i],
                    'si_for_year_id' => $si_for_year_id[$i],
                    'serial_no' => $serial_no[$i],
                    'activation_code' => $activation_code[$i],
                    'lan_type' => $s_pc[$i],
                    'total_lan' => $total_lan[$i],
                    'si_gstkey_id' => $gstkeyid,
                    'referby' => $referby,
					'ul_declaration_file' => $declaration_attachment_file_name,
                    'created_at' => date('Y-m-d H:s:i'),
                    'updated_at' => date('Y-m-d H:s:i')
                );
            endif;
        }

        if (!empty($p_items)) {
            $p_id = $this->Data_model->Insert_data_id('si_clients_details', $p_items);
			
            for ($j = 0; $j < count($si_for_year_id); $j++) {
                $product = array(
                    'si_clients_details_id' => $p_id,
                    'purchase_year' => $si_for_year_id[$j],
                    'purchase_date' => date('Y-m-d H:s:i', strtotime($purchase_date[$j])),
                    'renewal_date' => date('Y-m-d H:s:i', strtotime($last_renewal_date[$j])),
                    'created_at' => date('Y-m-d H:s:i'),
                    'updated_at' => date('Y-m-d H:s:i')
                );
            }
            if (!empty($product)) {
                $purchase_id = $this->Data_model->Insert_data_id('si_product_purchase', $product);
            }
        } 
        $si_clients_details_id=$p_id;
        endif;
        if ($category_id[0] == 2 || $category_id[0] == 4):
        for ($j = 0; $j < count($si_for_year_id); $j++) {
                $product = array(
                    'si_clients_details_id' => $si_clients_details_id,
                    'purchase_year' => $si_for_year_id[$j],
                    'purchase_date' => date('Y-m-d H:s:i', strtotime($purchase_date[$j])),
                    'renewal_date' => date('Y-m-d H:s:i', strtotime($last_renewal_date[$j])),
                    'created_at' => date('Y-m-d H:s:i'),
                    'updated_at' => date('Y-m-d H:s:i')
                );
            }
			
            if (!empty($product)) {
                $purchase_id = $this->Data_model->Insert_data_id('si_product_purchase', $product);
            }  
        endif; 
		

		
        for ($i = 0; $i < count($si_clients_details_id); $i++) {
            if($category_id[$i]==3)
                $final_lan=$old_lan+$total_lan[$i];
            else
                $final_lan=$total_lan[$i];
            if(!isset($gstkeyid))
                $gstkeyid='';
            if($category_id[$i]==4){
            $pupdate_items = array(                       
                    'si_product_id' => $si_conversion_product_id[$i],
                    'si_conversion_product_id' => $si_clients_details_id,                    
                    'p_email'=>$regemail,
                    'laptop' => $laptop[$i],
                    'category_id' => $category_id[$i],
                    'reg_type' => $reg_type[$i],
                    'si_for_year_id' => $si_for_year_id[$i],
                    'serial_no' => $serial_no[$i],
                    'activation_code' => $activation_code[$i],
                    'lan_type' => $s_pc[$i],
                    'total_lan' => $final_lan,
                    'si_gstkey_id' => $gstkeyid,
					'ul_declaration_file' => $declaration_attachment_file_name,
                    //'created_at' => date('Y-m-d H:s:i'),
                    'updated_at' => date('Y-m-d H:s:i')
                );
            }else{
                $pupdate_items = array(                       
                    'si_conversion_product_id' => $si_conversion_product_id[$i],
                    'p_email'=>$regemail,
                    'laptop' => $laptop[$i],
                    'category_id' => $category_id[$i],
                    'reg_type' => $reg_type[$i],
                    'si_for_year_id' => $si_for_year_id[$i],
                    'serial_no' => $serial_no[$i],
                    'activation_code' => $activation_code[$i],
                    'lan_type' => $s_pc[$i],
                    'total_lan' => $final_lan,
                    'si_gstkey_id' => $gstkeyid,
                    'ul_declaration_file' => $declaration_attachment_file_name,
                    //'created_at' => date('Y-m-d H:s:i'),
                    'updated_at' => date('Y-m-d H:s:i')
                );
            }   
        $con = array('si_clients_id' => $si_clients_id,
                    'si_clients_details_id' => $si_clients_details_id);
        }
       
        $this->Data_model->Update_data('si_clients_details', $con, $pupdate_items);
        if(!isset($isbill))
            $isbill=0;
        if(!isset($paymentdue))
            $paymentdue=0;
            if(!empty($payment_type))
            $paydet=implode(",",$payment_type);
            else
            $paydet='';
            $data['client'] = $this->Data_model->Custome_query("SELECT p.p_name FROM si_clients_details as s inner join si_product as p on p.si_product_id=s.si_product_id WHERE s.si_clients_details_id=".$si_clients_details_id);
            $data['year'] = $this->Data_model->Custome_query("SELECT yearname FROM si_for_year where si_for_year_id=".$si_for_year_id[0]);

            $for_year=$data['year'][0]['yearname'];
            $p_name=$data['client'][0]['p_name'];
        $data = array(            
            'si_clients_id' =>$si_clients_id,
            'si_clients_details_id'=>$si_clients_details_id,
            'amount' =>$amount,
            'costamount'=>(int)$costamount,
            'taxamount'=>(int)$tax,
			'tax_purchase'=>(int)$tax_purchase,
            'total_lan_cost_amount'=>(int)$total_lan_cost_amount[0],
            'lan_amount'=>(int)$total_lan_amout[0],
            'bank_amount'=>(int)$bank_amount,
            'cash_amount'=>(int)$cash_amount,
            'online_amount'=>(int)$online_amount,            
            'online_transaction'=>$online_transaction,
            'for_year'=>$for_year,
            'category_id'=>$category_id[0],
            'old_lan'=>(int)$old_lan,
            'new_lan'=>(int)$total_lan[0],
            'paymentdue'=>(int)$paymentdue,         
            'deposit_bank'=> isset($deposit_bank) ? $deposit_bank : NULL ,
            'p_name'=>$p_name,
            'payment_type' =>$paydet,
            'bank_name' =>$bank_name,
            'cheque' =>  isset($cheque) ? $cheque : NULL ,
            'is_bill'=> isset($isbill) ? $isbill : 0 ,
            'in_offer' => isset($offre_cash) ? $offre_cash : 0,
            'billnumber'=> isset($billnumber) ? $billnumber : NULL ,
            'billremarks'=> isset($billremarks) ? $billremarks : NULL ,
            'transaction_date'=>date('Y-m-d H:s:i', strtotime($transaction_date)),
            'status'=>'A',
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i'),
			'sale_grand_total_amount'=>(int)$sale_grand_total_amount,
            'purchase_grand_total_amount'=>(int)$purchase_grand_total_amount,   
			'in_scheme'=> isset($in_scheme) ? $in_scheme : 0 ,
            'in_scheme_comment'=>  isset($in_scheme_comment) ? $in_scheme_comment : NULL ,
        );        
		
		
        if(isset($hid) && $hid != "")
        {
            $con = array($this->tbl.'_id' => $hid);            
            $id = $this->Data_model->Update_data($this->tbl, $con, $data);
            $sessdata =array('error' => '<strong>Success!</strong> Update TransactionsDetail.', 'errorcls' => 'alert-success');
        }     
        else
        {
			
		
		/*$data['declaration_attachment_file'] = isset($filename['file_name']) ? $filename['file_name'] : NULL;
			$declaration_attachment_file_name = $data['declaration_attachment_file'];*/
		$data['declaration_attachment_file'] = $declaration_attachment_file_name;
		    $id = $this->Data_model->Insert_data_id($this->tbl, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New TransactionsDetail.', 'errorcls' => 'alert-success'];
        }
		
		
		/**----------------Lan Entry in Table---------------------**/
		$ff = 0; $lan_ids = [];
		if($old_lan >0 && $s_pc[0]==2 && $category_id[0]==3) { $ff = (int)$old_lan; }
		
		if($lan_new_count_name > 0) {
			
			for($i=1; $i<=$lan_new_count_name; $i++){
				$lanData = 
				array(
				'lan_number'=>$i + $ff ,
				'sale_lan_amount'=>  ${'input_lan_sale_amt' . $i},
				'purchase_lan_amount'=>  ${'input_lan_purchase_amt' . $i},
				'lan_type'=> $s_pc[0],
				'si_transactions_detail_id'=>$id,
				'si_clients_details_id'=>$si_clients_details_id,
				'si_clients_id'=>$si_clients_id,
				'for_year'=>$for_year,
				'p_name'=>$p_name,
				'category_id'=> $category_id[0],
				'si_product_id'=>$lan_product_id_value,
				'si_for_year_id'=> $si_for_year_id[0],
				'serial_no'=> $serial_no[0],
				'created_at' => date('Y-m-d H:s:i'),
				);
			$si_lan_managed_id = $this->Data_model->Insert_data_id("si_lan_managed", $lanData);
			$lan_ids[] = $si_lan_managed_id;
			}
		}
		
		if(count($lan_ids) >0 ) { $lan_ids_list = implode(',',$lan_ids); }
		
		
		
		$reportData = 
				array(
				'lan_count_number_new'=>$lan_new_count_name,
				'lan_count_number_old'=> (int)$old_lan ,
				'sale_lan_amount'=>  $total_lan_amout[0],
				'purchase_lan_amount'=>  $total_lan_cost_amount[0],
				'lan_type'=> $s_pc[0],
				'si_transactions_detail_id'=>$id,
				'si_clients_details_id'=>$si_clients_details_id,
				'si_clients_id'=>$si_clients_id,
				'for_year'=>$for_year,
				'p_name'=>$p_name,
				'category_id'=> $category_id[0],
				'si_product_id'=>$lan_product_id_value,
				'si_for_year_id'=> $si_for_year_id[0],
				'serial_no'=> $serial_no[0],
				'created_at' => date('Y-m-d H:s:i'),
				'conversion_product_id'=> isset($si_conversion_product_id[0]) ? $si_conversion_product_id[0] : 0 ,
				'laptop'=>$laptop[0],
				'reg_type'=>$reg_type[0],
				'activation_code'=>$activation_code[0],
				'purchase_date'=> date('Y-m-d H:s:i', strtotime($purchase_date[0])) ,
				'last_renewal_date'=> date('Y-m-d H:s:i', strtotime($last_renewal_date[0])) ,
				'regemail'=>  isset($regemail) ? $regemail : NULL,
				'is_bill'=> isset($isbill) ? $isbill : 0,
				'billnumber'=> isset($billnumber) ? $billnumber : NULL,
				'in_scheme'=> isset($in_scheme) ? $in_scheme : 0,
				'in_scheme_comment'=> isset($in_scheme_comment) ? $in_scheme_comment : NULL,
				'product_amount_sale'=>  isset($amount) ? $amount : 0,
				'product_amount_purchase'=>  isset($costamount) ? $costamount : 0,
				'tax_amount_sale'=> isset($tax) ? $tax : 0,
				'tax_amount_purchase'=>  isset($tax_purchase) ? $tax_purchase : 0,
				'grand_total_amount_sale'=>  isset($sale_grand_total_amount) ? $sale_grand_total_amount : 0,
				'grand_total_amount_purchase'=>  isset($purchase_grand_total_amount) ? $purchase_grand_total_amount : 0,
				'is_payment_pending'=>  isset($paymentdue) ? (int)$paymentdue : 0,
				'deposit_bank_name'=> isset($deposit_bank) ? $deposit_bank : NULL,
				'transaction_date'=> date('Y-m-d H:s:i', strtotime($transaction_date)),
				'billremarks'=> isset($billremarks) ? $billremarks : NULL,
				'payment_type'=> isset($paydet) ? $paydet : NULL,
				't_bank_name'=> isset($bank_name) ? $bank_name : NULL,
				't_cheque_number'=> isset($cheque) ? $cheque : NULL,
				't_bank_amount'=> isset($bank_amount) ? $bank_amount : 0,
				't_online_amount'=> isset($online_amount) ? $online_amount : 0,
				't_online_transaction_comment'=> isset($online_transaction) ? $online_transaction : NULL,
				't_cash_amount'=> isset($cash_amount) ? $cash_amount : 0,
				'client_name'=> isset($contact_person) ? $contact_person : NULL,
				'client_firm_name'=>  isset($firm_name) ? $firm_name : NULL,
				'client_mobileno'=> isset($registed_mobile) ? $registed_mobile : NULL,
				'referby'=>  isset($referby) ? $referby : NULL,
				'lan_ids_list'=> isset($lan_ids_list) ? $lan_ids_list : NULL,
				'declaration_attachment_file'=> isset($declaration_attachment_file_name) ? $declaration_attachment_file_name : NULL,
				
				);
		
		$this->Data_model->Insert_data_id("si_new_sale_purchase_report", $reportData);

		/**----------------Lan Entry in Table---------------------**/
		
        //$val->mobile='7984030274';
		$registed_mobile= isset($registed_mobile) ? $registed_mobile : '7984030274';
        $valmobile=$registed_mobile;
        $message_id='';
        $msg="Dear Customer Your ".$p_name." of rs ".$amount.". is renew by ".$transaction_date." Next Premium falls due on ".date('d-m-Y', strtotime($last_renewal_date[0]));
        //$apiUrl = 'sms.qry.in/smsapi.aspx?username=saisoftsdemo&password=sai*1234&sender=VERCOD&to=' . $valmobile . '&message=' . urlencode($msg) . '&route=route3';
        //$message_id=$this->CallAPI('GET', $apiUrl);
        log_message('custom', "\n------------ Message $firm_name-----------\n".json_encode(array('msg_id'=>$message_id,'mobile'=>$valmobile,"msg"=>$msg)));
        log_message('custom', "\n------------ TransactionsDetail $firm_name-----------\n".json_encode($_REQUEST));
        //$this->Data_model->userErrorHandler('E_NOTICE','Trans','test_log.txt',102,'re2,re2,re3');
        //$this->Data_model->userErrorHandler('TRNS_NOTICE','Trans :'.json_encode($data),'TransactionsDetail.php',168,$this->tbl);
        $this->session->set_flashdata($sessdata);
        redirect(base_url('Client'));
    }

    function CallAPI($method, $url, $data = false) {
       $curl = curl_init();
       switch ($method) {
           case "POST":
               curl_setopt($curl, CURLOPT_POST, 1);
               if ($data)
                   curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
               break;
           case "PUT":
               curl_setopt($curl, CURLOPT_PUT, 1);
               break;
           default:
               if ($data)
                   $url = sprintf("%s?%s", $url, http_build_query($data));
       }
       curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
       curl_setopt($curl, CURLOPT_USERPWD, "username:password");
       curl_setopt($curl, CURLOPT_URL, $url);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
       curl_setopt($curl, CURLOPT_HTTPHEADER, array("Expect: "));
       $result = curl_exec($curl);
       curl_close($curl);
//        print_r($result); die;
       return $result;
   }
   public function AddTransDet(){
     extract($_REQUEST);
      //$data['client'] = $this->Data_model->Custome_query("SELECT p.p_name,S.category_id,S.total_lan FROM si_clients_details as s inner join si_product as p on p.si_product_id=s.si_product_id WHERE s.si_clients_details_id=".$si_clients_details_id);
      $data['client'] = $this->Data_model->Custome_query("SELECT p.p_name,s.category_id,s.total_lan FROM si_clients_details as s inner join si_product as p on p.si_product_id=s.si_product_id WHERE s.si_clients_details_id=".$si_clients_details_id);
            $data['year'] = $this->Data_model->Custome_query("SELECT yearname FROM si_for_year where si_for_year_id=".$si_for_year_id[0]);

            $for_year=$data['year'][0]['yearname'];
            $p_name=$data['client'][0]['p_name'];
            $category_id[0]=$data['client'][0]['category_id'];
            $total_lan[0]=$data['client'][0]['total_lan'];
            $old_lan=$data['client'][0]['total_lan'];
             if(!isset($isbill))
            $isbill=0;
            if(!isset($paymentdue))
            $paymentdue=0;
            if(!empty($payment_type))
            $paydet=implode(",",$payment_type);
            else
            $paydet='';
     $data = array(            
            'si_clients_id' =>$si_clients_id,
            'si_clients_details_id'=>$si_clients_details_id,
            'amount' =>$amount,
            'costamount'=>(int)$costamount,
            'total_lan_cost_amount'=>(int)$total_lan_cost_amount[0], 
            'lan_amount'=>$total_lan_amout[0],
            'bank_amount'=>(int)$bank_amount,
            'cash_amount'=>(int)$cash_amount,
            'online_amount'=>(int)$online_amount,            
            'online_transaction'=>$online_transaction,
            'for_year'=>$for_year,
            'category_id'=>$category_id[0],
            'old_lan'=>(int)$old_lan,
            'new_lan'=>(int)$total_lan[0],
            'paymentdue'=>(int)$paymentdue,
            'deposit_bank'=>$deposit_bank,
            'p_name'=>$p_name,
            'payment_type' =>$paydet,
            'bank_name' =>$bank_name,
            'cheque' =>$cheque,
            'is_bill'=>$isbill,
            'billnumber'=>$billnumber,
            'billremarks'=>$billremarks,
            'transaction_date'=>date('Y-m-d H:s:i', strtotime($transaction_date)),
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
        log_message('custom', "\n------------ TransactionsDetail $si_clients_id-----------\n".json_encode($data));
        $this->session->set_flashdata($sessdata);
        redirect(base_url('Client') );
   }
    public function get_product(){ extract($_REQUEST);
       $data['product'] = $this->Data_model->Custome_query("SELECT cp.si_clients_details_id,p.p_name FROM `si_clients_details` as cp inner join si_product as p on p.si_product_id=cp.si_product_id WHERE cp.`si_clients_id` =".$si_clients_id);             
       
       echo json_encode($data);
    }
    public function add_gst_id($gstkey) {
        $gstdata = [];
        $gstdata = array(
            "gstkey" => $gstkey,
            "status" => "U"
        );
        $gstinsertid = $this->Data_model->Insert_data_id('si_gstkey', $gstdata);
        return $gstinsertid;
    }
    public function GetData() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'cd.contact_person', 
            2 => 'p.p_name',
            3 => 'serial_no',
            4 => 'category_id',
            5 => 'for_year',
            6 => 'amount',
            7 => 'costamount',
            8 => 'taxamount',
            9 => 'new_lan',
            10 => 'total_lan_cost_amount',
            11 => 'billnumber',
            12 => 'payment_type',                        
            13 => 'billremarks',            
            14 => 'transaction_date',
        );

        //$sql = "select * from " . $this->tbl . " where status!='B'";
        $sql = "SELECT cd.contact_person,cp.serial_no,cp.si_product_id,p.p_name,td.* FROM " . $this->tbl . " as td 
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
            $sql .= " OR cp.serial_no LIKE '" . $requestData['search']['value'] . "%' ";
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
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            endif;
            $edit = "<a class='edit small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span></button></a>";
            $delete = "<a class='delete small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";
           if($dt['category_id']==0)
                    $fre_value='selected';
                else if($dt['category_id']==1)
                    $fre_value ="Installation";
                else if($dt['category_id']==2)
                    $fre_value ="Updatation";
                else if($dt['category_id']==3)
                    $fre_value ="Lan";
                else if($dt['category_id']==4)
                    $fre_value ="Conversion";
                else
                    $fre_value ="not geting";
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['contact_person'];
            $nestedData[] = $dt['p_name'];

            if(strlen($dt['serial_no'])>14) {
            $nestedData[] =  chunk_split($dt['serial_no'], 14, "\n"); }
            else {  $nestedData[] = $dt['serial_no'];  }

            $nestedData[] = $fre_value;
            $nestedData[] = $dt['for_year'];
            $nestedData[] = $dt['amount'];
            $nestedData[] = $dt['costamount'];
            $nestedData[] = $dt['taxamount'];
            $nestedData[] = $dt['new_lan'];
            $nestedData[] = $dt['total_lan_cost_amount'];
            $nestedData[] = $dt['billnumber'];
            $nestedData[] = $dt['payment_type'];
            $nestedData[] = $dt['billremarks'];
            if($dt['transaction_date']==NULL) { $nestedData[] = '';} else {
            $nestedData[] = date('d-m-Y',strtotime($dt['transaction_date']));}
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
        /*$Convertion="SELECT si_conversion_product_id as p_id FROM `si_clients_details` WHERE si_clients_id = ".$id;
        $convertionquery = $this->Data_model->Custome_query($Convertion);
        if($convertionquery[0]['p_id']!= 0)
            $c_pid="inner join si_product as p on p.si_product_id=cd.si_conversion_product_id";
        else*/
		
            $c_pid="inner join si_product as p on p.si_product_id=cd.si_product_id";
        $sql = "select cd.si_clients_details_id as si_clients_details_id,cd.si_conversion_product_id,fy.yearname as foryear, p.p_name as productname, pp.purchase_year as purchyear,pp.purchase_date as purchasedate,pp.renewal_date as renewdate,cd.activation_code as activationcode,cd.serial_no as serialno,cd.lan_type as lantype,cd.total_lan as lantotal,cd.reg_type as regtype,cd.status as status,cd.attach_file , cd.ul_declaration_file as filex,sc.register_email
                 from si_clients_details as cd 
                ".$c_pid."
                INNER JOIN si_clients sc ON sc.si_clients_id=cd.si_clients_id 
                left join si_product_purchase as pp on pp.si_clients_details_id=cd.si_clients_details_id
                left join si_for_year as fy on pp.purchase_year=fy.si_for_year_id
                where cd.si_clients_id='" . $id . "' and cd.status!='B' group by p.p_name,cd.serial_no";


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
       $sql .= " ORDER BY  pp.renewal_date desc ";
       //$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
        foreach ($query as $dt) {
            $nestedData = array();
            
            
            $st = $dt['attach_file'] != "" ? "Y" : "N";

            $file = $dt['attach_file'] != "" ? "<a href='" . base_url('assetss/upload/files/') . $dt['attach_file'] . "' download>Download File</a>" : "Not Yet Attached!";
			
			$filex = trim($dt['filex'])!="" ? "<a href='" . base_url('assetss/Declaration_files/') . $dt['filex'] . "' download>Download File</a>" : NULL;
			
		
            
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
             $view = "<a class='edit small-btn' data-id='" . $dt['si_clients_details_id'] . "' data-status='" . $dt['status'] . "' title='View Product'><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-eye fa-stack-1x fa-inverse'></i></span></button></a>";
             $mail= "<a class='mail small-btn' small-btn' data-mailid='" . $dt['register_email'] . "' data-serial='" . $dt['serialno'] . "' data-isstatus='" . $dt['status'] . "' title='Pay'><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-envelope fa-stack-1x fa-inverse'></i></span></button></a>";  
//             echo $file;
             if ($dt['status'] == "A"):
                $de_act = "<a class='dlt small-btn' data-id='" . $dt['si_clients_details_id'] . "' data-status='P' title='View Product'><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash fa-stack-1x fa-inverse'></i></span></button></a>";
                $edit = "<a class='view small-btn' data-id='" . $dt['si_clients_details_id'] . "' data-p_name='" . $dt['productname'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-primary'><span class='fa-stack'><i class='fa fa-plus fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $de_act = "<a class='dlt small-btn' data-id='" . $dt['si_clients_details_id'] . "' data-status='A' title='View Product'><button class='btn btn-xs btn-secondary'><span class='fa-stack'><i class='fa fa-trash fa-stack-1x fa-inverse'></i></span></button></a>";
                $edit = "";
            endif;
            if ($dt['si_conversion_product_id'] != 0):
                $sql_p= "Select p.p_name from si_clients_details as cd inner join si_product as p on p.si_product_id=cd.si_conversion_product_id where serial_no like '".$dt['serialno']."'";
             $p_nm = $this->Data_model->Custome_query($sql_p);
             $dt['productname']=$p_nm[0]['p_name'].'>>'.$dt['productname'];    
            endif;    
            if($this->session->userdata('id')==17 ||$this->session->userdata('id')==19)
             $get_show= $view. "&nbsp". $mail;
            else
             $get_show= $view. "&nbsp" . $edit . "&nbsp".$de_act . "&nbsp". $mail;
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
            $nestedData[] = $filex;
            $nestedData[] =$get_show;
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

        $sql = "select cd.category_id,cd.new_lan,cd.transaction_date,cd.si_transactions_detail_id,cd.status,cd.si_clients_details_id as si_clients_details_id,cd.for_year as foryear,cd.in_offer, cd.p_name as productname,cd.created_at as renewdate,cd.amount,cd.payment_type,cd.billremarks
                 from si_transactions_detail as cd 
                where cd.si_clients_id='" . $s_id . "' and cd.si_clients_details_id='" . $id . "' and cd.status!='B'";
        $gt_p="SELECT status FROM `si_clients_details` WHERE `si_clients_details_id` =".$id;
        
        $p_query = $this->Data_model->Custome_query($gt_p);
        $query = $this->Data_model->Custome_query($sql);


        if (count($query) > 0) {
            $tbl = "<tr id='dynOrderRow' data-id='" . $id . "'><td colspan='28'><table id='editable' class='table table-bordered cursor-auto noselect selectlast-two'><tr><th>#</th><th>Product Name</th><th>Convertion</th><th>Session</th><th>Transactions Date</th><th>Lan</th><th>Amount</th><th>Payment Type</th><th>Remarks</th><th>Action</th></tr>";
            $i = 1;
            foreach ($query as $dt) {
                if($p_query[0]['status']=="P")
                $edit= "";
                else    
                $edit= "<a class='t_edit small-btn' data-id='" . $dt['si_transactions_detail_id'] . "' data-status='" . $dt['status'] . "' title='View Product'><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-pencil  fa-stack-1x fa-inverse'></i></span></button></a>";

                if($dt['in_offer']!=0)
                    $style='background-color:orange;color:black;';
                else 
                    $style ='';

                if($dt['category_id']==0)
                    $fre_value='selected';
                else if($dt['category_id']==1)
                    $fre_value ="Installation";
                else if($dt['category_id']==2)
                    $fre_value ="Updatation";
                else if($dt['category_id']==3)
                    $fre_value ="Lan";
                else if($dt['category_id']==4)
                    $fre_value ="Conversion";
                else
                    $fre_value ="not geting";
                $tbl .= "<tr data-id='" . $i . "' class='dynrow'>"
                        . "<td>" . $i . "</td>"
                        . "<td>" . $dt['productname'] . "</td>"
                        . "<td>" . $fre_value . "</td>"
                        . "<td style=".$style.">" . $dt['foryear'] . "</td>"
                        . "<td>" . $dt['transaction_date'] . "</td>"  
                        . "<td>" . $dt['new_lan'] . "</td>"            
                        . "<td>" . $dt['amount'] . "</td>"              
                        . "<td>" . $dt['payment_type'] . "</td>"              
                        . "<td>" . $dt['billremarks'] . "</td>"              
                        . "<td>" . $edit . "</td>"              
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

    public function get_product_data(){
        extract($_REQUEST);
        if(isset($p_id) && $p_id!=''){
        $sql = "SELECT  p.sale_amount,cd.*,yearname,DATE_FORMAT(purchase_date, '%d-%m-%Y') as purchase_date, DATE_FORMAT(renewal_date, '%m-%d-%Y') as renewal_date FROM si_clients_details as cd inner join si_for_year as fy on fy.si_for_year_id=cd.si_for_year_id  inner join si_product_purchase  as pd on pd.si_clients_details_id=cd.si_clients_details_id inner join si_product  as p on p.si_product_id=cd.si_product_id  WHERE cd.si_clients_details_id =".$p_id." AND cd.si_clients_id = ".$id." ORDER BY renewal_date desc";
         $query = $this->Data_model->Custome_query($sql);
        $json_data = $query;
        echo json_encode($json_data);
        }
        else
        {
        echo json_encode(1);
        }

    }
    public function get_client_edit_data() {
        extract($_POST);
		$sql = " AND p.category_id=1";
        //$con = array($tbl . '_id' => $id);
        //$data['contact'] = $this->Data_model->Get_data_one($tbl, $con);
        $Convertion="SELECT si_conversion_product_id as p_id FROM `si_clients_details` WHERE si_clients_id = ".$id;
        $convertionquery = $this->Data_model->Custome_query($Convertion);
        if($convertionquery[0]['p_id']!= 0)
            $c_pid="inner join si_product as p on p.si_product_id=cp.si_conversion_product_id";
        else
            $c_pid="inner join si_product as p on p.si_product_id=cp.si_product_id";
        $data['product'] = $this->Data_model->Custome_query("SELECT cp.si_clients_details_id,p.* FROM `si_clients_details` as cp ".$c_pid." WHERE cp.si_clients_id=".$id." and cp.status!='B' and cp.status!='P' $sql ");
		
        /* $Convertion="SELECT si_conversion_product_id as p_id,si_clients_details_id  FROM `si_clients_details` WHERE si_clients_id = ".$id;
        $convertionquery = $this->Data_model->Custome_query($Convertion);
        //var_dump($convertionquery);die();
        $marge['product1']=array();
        $marge['product2']=array();
       foreach ($convertionquery as $enquery) {
           if($enquery['p_id']!= 0){
            $c_pid="inner join si_product as p on p.si_product_id=cp.si_conversion_product_id";
            $marge['product1'] = $this->Data_model->Custome_query("SELECT cp.si_clients_details_id,p.p_name FROM `si_clients_details` as cp ".$c_pid." WHERE cp.`si_clients_id` =".$id." and cp.`status`!='B' and cp.`status`!='P' and cp.si_clients_details_id=".$enquery['si_clients_details_id']);
        }
        else{
            $c_pid="inner join si_product as p on p.si_product_id=cp.si_product_id";        
            $marge['product2'] = $this->Data_model->Custome_query("SELECT cp.si_clients_details_id,p.p_name FROM `si_clients_details` as cp ".$c_pid." WHERE cp.`si_clients_id` =".$id." and cp.`status`!='B' and cp.`status`!='P' and cp.si_clients_details_id=".$enquery['si_clients_details_id']);
            }
       }
       // var_dump($marge);die;
        $data['product']=array_merge($marge['product1'],$marge['product2']);*/
        //$this->Data_model->Custome_query("select dc.si_product_id,dp.p_name from si_clients_details dc inner join si_product dp on dc.si_product_id=dp.si_product_id where dc.si_clients_id=" . $id . " AND dc.status like 'A'");
        echo json_encode($data);
    }
	
public function rd($length_of_string = 8)
	{
		$characters = 'GHIJKLA123MNOSTUVW0XYZPQR456789BCDEF'; 
    	$randomString = ''; 
  
    		for ($i = 0; $i < $length_of_string; $i++) { 
        					$index = rand(0, strlen($characters) - 1); 
       						$randomString .= $characters[$index]; 
    				}   
    		return $randomString; 
	}

	
	public function Get_Product_Wise_Price() {
        extract($_REQUEST);
        $sql="SELECT COUNT(si_product_id) as cnt,purchase_amount,sale_amount,purchase_amount2,sale_amount2 FROM si_product 
		WHERE status='A' AND si_product_id=".$product_id." LIMIT 1";
		//echo "<pre>";  print_r($sql); die;
        $data = $this->Data_model->Custome_query($sql)[0];
        echo json_encode($data);
    }


}
