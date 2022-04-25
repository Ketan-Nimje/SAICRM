<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class NewAccountReport extends CI_Controller {

    public $controll = "Admin/NewAccountReport";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/kolkata");
		$this->Data_model->Validation();
    }

    public function index() {
		$data['for_year'] = $this->Data_model->Custome_query("select * from si_for_year where status like 'A'");
        $this->load->view($this->controll,$data);
    }

    public function getData() {  /*----- This is Used for Sales Report -----*/
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 's.si_transactions_detail_id',
            1 => 's.category_id',
            2 => 's.p_name',
            3 => 'qty',
            4 => 's.amount',
            5 => 's.si_transactions_detail_id',
        );

        if(isset($condtion) && !empty($condtion))
        { 
            $condtion=' and year(s.transaction_date) LIKE "%'.$year.'%" and  month(s.transaction_date) LIKE "%'.$month.'%"';
        }  

        else
		{
			$condtion=' and s.transaction_date like "'.date('Y-m-').'%" ';
		}

        $sql = "SELECT 
		count(s.p_name) as qty,
		sum(amount) as t_amount ,
		s.si_transactions_detail_id,
		s.category_id,
		s.p_name,
		s.amount as main_amount

		 FROM si_transactions_detail as s WHERE s.status='A'  AND s.category_id IN (1,2,4) ".$condtion;
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( p.si_transactions_detail_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.category_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%')";
        }
		
        $sql .=" GROUP BY s.category_id, s.p_name, s.amount";
		
		
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
		
		//echo $sql; die;
		   
        foreach ($query as $dt) {
			$c_name = '';
		
			if($dt['category_id']==1) { $c_name='Installation'; }  
			else if($dt['category_id']==2) { $c_name='Updation'; }
			else if($dt['category_id']==4) { $c_name='Conversion'; }
			
			$btn = '<button type="button" id="idx" data-type="sale" data-category_id="'.$dt["category_id"].'" data-p_name="'.$dt["p_name"].'" data-main_amount="'.$dt["main_amount"].'"
			 class="btn btn-primary btn-xs cvbx2tn" onclick="dx_modal(\'' . $dt["category_id"] . '\', \'' . $dt["p_name"] . '\', \'' . $dt["main_amount"] . '\' ,  \'s\');">view</button>';
			
            $nestedData = array();            
            $nestedData[] = $cnt++;
            $nestedData[] = $c_name . " " . $btn; 
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['main_amount'];
            $nestedData[] = $dt['qty'];                       
            $nestedData[] = $dt['t_amount'];
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


    public function getData2() {  /*----- This is Used for LAN Sale Report -----*/
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'lan.si_lan_managed_id',
            1 => 'lan.category_id',
            2 => 'lan.p_name',
            3 => 'qty',
            4 => 'lan.sale_lan_amount',
            5 => 'lan.si_lan_managed_id',
        );


        if(isset($condtion) && !empty($condtion))
        {  
            $condtion=' and year(s.transaction_date) LIKE "%'.$year.'%" and month(s.transaction_date) LIKE "%'.$month.'%"';
        }  

        else
		{
			$condtion=' and s.transaction_date like "'.date('Y-m-').'%" ';
		}
		//$condtion='';
		

        $sql = "SELECT 
		count(lan.sale_lan_amount) as qty,
		sum(lan.sale_lan_amount) as t_amount ,
		lan.si_lan_managed_id,
		lan.category_id,
		lan.p_name,
		lan.lan_type,
		lan.sale_lan_amount
		FROM si_transactions_detail s
		INNER JOIN si_lan_managed as lan
		ON s.si_transactions_detail_id=lan.si_transactions_detail_id
		WHERE s.status='A'  ".$condtion;
		 
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( lan.si_lan_managed_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR lan.category_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR lan.p_name LIKE '" . $requestData['search']['value'] . "%')";
        }
		
        $sql .=" GROUP BY lan.category_id, lan.si_product_id, lan.lan_type, lan.sale_lan_amount";
		
		
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
		
		//echo $sql; die;
        
		   
        foreach ($query as $dt) {
			$c_name = '';
			if($dt['lan_type']==2) { $c_name='LAN'; }
			else if($dt['lan_type']==1) { $c_name='Declaration With Service'; }
			else if($dt['lan_type']==0)  { $c_name='Declaration Without Service'; }
			
			if($dt['category_id']==1) { $ddx ='Installation'; }  
			else if($dt['category_id']==2) { $ddx ='Updation'; }
			else if($dt['category_id']==4) { $ddx ='Conversion'; }
			else  { $ddx ='Extend'; }
			
			$btn = '<button type="button" id="idx" data-type="sale" data-category_id="'.$dt["category_id"].'" data-p_name="'.$dt["p_name"].'" data-main_amount="'.$dt["sale_lan_amount"].'"
			 class="btn btn-primary btn-xs cvbx2tn" onclick="dx_modal1(\'' . $dt["category_id"] . '\', \'' . $dt["p_name"] . '\', \'' . $dt["sale_lan_amount"] . '\' ,  \'s\');">view</button>';
 
			
            $nestedData = array();            
            $nestedData[] = $cnt++;
            $nestedData[] = $c_name . "  " . $btn." " .$ddx;
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['sale_lan_amount'];
            $nestedData[] = $dt['qty'];                       
            $nestedData[] = $dt['t_amount']; 
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



    public function getData3() { /*----- This is Used for Purchase Report -----*/
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 's.si_transactions_detail_id',
            1 => 's.category_id',
            2 => 's.p_name',
            3 => 'qty',
            4 => 's.costamount',
            5 => 's.si_transactions_detail_id',
        );


        if(isset($condtion) && !empty($condtion))
        {            
            $condtion=' and year(s.transaction_date) LIKE "%'.$year.'%" and  month(s.transaction_date) LIKE "%'.$month.'%"';
        }  

        else
		{
			$condtion=' and s.transaction_date like "'.date('Y-m-').'%" ';
		}

        $sql = "SELECT 
		count(s.p_name) as qty,
		sum(s.costamount) as t_amount ,
		s.si_transactions_detail_id,
		s.category_id,
		s.p_name,
		s.costamount as main_amount

		 FROM si_transactions_detail as s WHERE s.status='A'  AND s.category_id IN (1,2,4) ".$condtion;
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( p.si_transactions_detail_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.category_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%')";
        }
		
        $sql .=" GROUP BY s.category_id, s.p_name, s.costamount";
		
		
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
		
		//echo $sql; die;
        
		   
        foreach ($query as $dt) {
			$c_name = '';
			if($dt['category_id']==1) { $c_name='Installation'; }  
			else if($dt['category_id']==2) { $c_name='Updation'; }
			else if($dt['category_id']==4) { $c_name='Conversion'; }
			
			$btn = '<button type="button" id="idx" data-type="purchase" data-category_id="'.$dt["category_id"].'" data-p_name="'.$dt["p_name"].'" data-main_amount="'.$dt["main_amount"].'"
			 class="btn btn-primary btn-xs cvbx2tn" onclick="dx_modal(\'' . $dt["category_id"] . '\', \'' . $dt["p_name"] . '\' , \'' . $dt["main_amount"] . '\' , \'p\');">view</button>';
			
            $nestedData = array();            
            $nestedData[] = $cnt++;
            $nestedData[] = $c_name." " . $btn;
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['main_amount'];
            $nestedData[] = $dt['qty'];                       
            $nestedData[] = $dt['t_amount']; 
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


    public function getData4() {  /*----- This is Used for LAN Purchase Report -----*/
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'lan.si_lan_managed_id',
            1 => 'lan.category_id',
            2 => 'lan.p_name',
            3 => 'qty',
            4 => 'lan.purchase_lan_amount',
            5 => 'lan.si_lan_managed_id',
        );


        if(isset($condtion) && !empty($condtion))
        {  
            $condtion=' and year(s.transaction_date) LIKE "%'.$year.'%" and month(s.transaction_date) LIKE "%'.$month.'%"';
        }  
        else
		{
			$condtion=' and s.transaction_date like "'.date('Y-m-').'%" ';
		}
		

        $sql = "SELECT 
		count(lan.purchase_lan_amount) as qty,
		sum(lan.purchase_lan_amount) as t_amount ,
		lan.si_lan_managed_id,
		lan.category_id,
		lan.p_name,
		lan.lan_type,
		lan.purchase_lan_amount
		FROM si_transactions_detail s
		INNER JOIN si_lan_managed as lan
		ON s.si_transactions_detail_id=lan.si_transactions_detail_id
		WHERE s.status='A'  ".$condtion;
		 
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( lan.si_lan_managed_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR lan.category_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR lan.p_name LIKE '" . $requestData['search']['value'] . "%')";
        }
		
        $sql .=" GROUP BY lan.category_id, lan.si_product_id, lan.lan_type, lan.purchase_lan_amount";
		
		
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
		
		//echo $sql; die;
        
		   
        foreach ($query as $dt) {
			$c_name = '';
			if($dt['lan_type']==2) { $c_name='LAN'; }
			else if($dt['lan_type']==1) { $c_name='Declaration With Service'; }
			else if($dt['lan_type']==0)  { $c_name='Declaration Without Service'; } 
			
			
			if($dt['category_id']==1) { $ddx ='Installation'; }  
			else if($dt['category_id']==2) { $ddx ='Updation'; }
			else if($dt['category_id']==4) { $ddx ='Conversion'; }
			else  { $ddx ='Extend'; }
			
			
			$btn = '<button type="button" id="idx" data-type="sale" data-category_id="'.$dt["category_id"].'" data-p_name="'.$dt["p_name"].'" data-main_amount="'.$dt["purchase_lan_amount"].'"
			 class="btn btn-primary btn-xs cvbx2tn" onclick="dx_modal1(\'' . $dt["category_id"] . '\', \'' . $dt["p_name"] . '\', \'' . $dt["purchase_lan_amount"] . '\' ,  \'p\');">view</button>';


			
            $nestedData = array();            
            $nestedData[] = $cnt++;
            $nestedData[] = $c_name. " " . $btn. " " .$ddx;
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['purchase_lan_amount'];
            $nestedData[] = $dt['qty'];                       
            $nestedData[] = $dt['t_amount']; 
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
	
	
	public function getDetails() {  
        extract($_REQUEST);
        $requestData = $_REQUEST;
		
        $columns = array(
            0 => 's.si_transactions_detail_id',
            1 => 's.category_id',
            2 => 's.p_name',
            3 => 's.si_transactions_detail_id',
            4 => 's.amount',
        );


        $condtion=' and year(s.transaction_date) LIKE "%'.$year.'%" and month(s.transaction_date) LIKE "%'.$month.'%"';
		
		
		if($type=='s')
        { 
            $whr="AND s.amount='".$main_amount."' "; 
        }  

        else
		{
			$whr="AND s.costamount='".$main_amount."' "; 
		}
       

        $sql = "SELECT 
		s.si_transactions_detail_id,
		s.p_name,
		c.contact_person as client_name, cl.serial_no as serial_number, c.si_clients_id client_id,
		s.transaction_date as purchase_date,
		s.for_year ,
		s.amount as sale_amount,
		s.costamount as purchase_amount,
		s.payment_type,
		s.billremarks
		FROM si_transactions_detail as s 
		LEFT JOIN si_clients_details cl on cl.si_clients_details_id=s.si_clients_details_id
		LEFT JOIN si_clients c on c.si_clients_id=s.si_clients_id
		WHERE s.status='A'  AND s.category_id='".$category_id."' AND s.p_name='".$p_name."'  $whr  ".$condtion;
        $query = $this->Data_model->Custome_query($sql);
		
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( s.si_transactions_detail_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR s.category_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR s.p_name LIKE '" . $requestData['search']['value'] . "%')";
        }
		
  		
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
		
		//echo $sql; die;
		
		   
        foreach ($query as $dt) {
			
            $nestedData = array();            
            $nestedData[] = $cnt++;
            $nestedData[] = date('d-m-Y', strtotime($dt['purchase_date']));
			$nestedData[] = $dt['serial_number'];
			$nestedData[] = $dt['for_year'];
            $nestedData[] = "<a href='".base_url('Admin/TransactionsDetail/add_payment_view')."?id=".$dt['client_id']."'>". $dt['client_name']."</a>" ;
            $nestedData[] = $dt['sale_amount'];                       
            $nestedData[] = $dt['purchase_amount'];
			$nestedData[] = $dt['payment_type'];
			$nestedData[] = $dt['billremarks'];
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


	public function getDetails1() {  
        extract($_REQUEST);
        $requestData = $_REQUEST;
		
        $columns = array(
            0 => 'lan.si_lan_managed_id',
            1 => 's.category_id',
            2 => 's.p_name',
            3 => 'lan.si_lan_managed_id',
            4 => 'lan.sale_lan_amount',
        );

        $condtion=' and year(s.transaction_date) LIKE "%'.$year.'%" and month(s.transaction_date) LIKE "%'.$month.'%"';
		
		if($type=='s')
        { 
            $whr="AND lan.sale_lan_amount='".$main_amount."' "; 
        }  

        else
		{
			$whr="AND lan.purchase_lan_amount='".$main_amount."' "; 
		}
       

        $sql = "SELECT 
		lan.si_lan_managed_id, 
		s.p_name,
        count(*) as cnt,
		c.contact_person as client_name, cl.serial_no as serial_number, c.si_clients_id client_id,
		s.transaction_date as purchase_date,
		s.for_year ,
		lan.sale_lan_amount as sale_amount,
		lan.purchase_lan_amount as purchase_amount,
		s.payment_type,
		s.billremarks
		FROM si_lan_managed as lan
		INNER JOIN si_transactions_detail s on lan.si_transactions_detail_id=s.si_transactions_detail_id 
		LEFT JOIN si_clients_details cl on cl.si_clients_details_id=s.si_clients_details_id
		LEFT JOIN si_clients c on c.si_clients_id=s.si_clients_id
		WHERE s.status='A'  AND s.category_id='".$category_id."' AND s.p_name='".$p_name."'  $whr  ".$condtion;
        $query = $this->Data_model->Custome_query($sql);
		
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( lan.si_lan_managed_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR s.category_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR s.p_name LIKE '" . $requestData['search']['value'] . "%')";
        }

        $sql .=" GROUP BY  lan.sale_lan_amount, lan.purchase_lan_amount,c.si_clients_id,s.for_year";
		
  		
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
		
		//echo $sql; die;
		
		   
        foreach ($query as $dt) {
			
            $nestedData = array();            
            $nestedData[] = $cnt++;
            $nestedData[] = date('d-m-Y', strtotime($dt['purchase_date']));
			$nestedData[] = $dt['serial_number'];
			$nestedData[] = $dt['for_year'];
            $nestedData[] = "<a href='".base_url('Admin/TransactionsDetail/add_payment_view')."?id=".$dt['client_id']."'>". $dt['client_name']."</a>" ;
            
            $nestedData[] = $dt['sale_amount'] . " x ". $dt['cnt'] . " = ".$dt['cnt']*$dt['sale_amount'];                            
            $nestedData[] = $dt['purchase_amount'] . " x ". $dt['cnt'] . " = ".$dt['cnt']*$dt['purchase_amount'];
			$nestedData[] = $dt['payment_type'];
			$nestedData[] = $dt['billremarks'];
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









/*


public function datapaste() { 


        $data = [1,2,3,4,5];


        $sql ="SELECT 
        si_lan_managed_id,
        lan_number,
        sale_lan_amount,
        purchase_lan_amount,   
        
        lan_type,
        si_transactions_detail_id,
        si_clients_details_id,
        si_clients_id,
        for_year,
        p_name,
        category_id,
        si_product_id,
        si_for_year_id,
        serial_no
        FROM `si_lan_managed`
        GROUP BY sale_lan_amount,purchase_lan_amount,si_clients_details_id,p_name 
        LIMIT 500";

        $query = $this->Data_model->Custome_query($sql);


            
        echo "<pre>";

        foreach ($query as $key => $value) 
        {
        echo " | ";
        print_r(implode(' | ', $value));
        //echo " <br> _________________________________________________________________ ";
        echo " | <br>";
        }

        die;
}
*/



















}
