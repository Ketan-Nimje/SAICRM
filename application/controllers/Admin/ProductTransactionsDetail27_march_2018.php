<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductTransactionsDetail extends CI_Controller {
    private $tbl = "si_transactions_detail";
    public $controll = "Admin/ProductTransactionsDetail";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/kolkata");
    }

    public function index() {

        $data['product'] = $this->Data_model->Custome_query("select p_name from si_product where status like 'A'");
        $data['selected']=$_REQUEST;
        $this->load->view($this->controll,$data);
    }

    public function GetData() {
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'td.transaction_date',
            2 => 'cd.contact_person', 
            3 => 'cp.serial_no',
            4 => 'p.p_name',
            5 => 'for_year',
            6 => 'category_id',            
            7 => 'amount',
            8 => 'payment_type',                        
            9 => 'billremarks',                                    
        );
        if(isset($datefrom))
        {            
            $condtion=" and  STR_TO_DATE(td.transaction_date, '%Y-%m-%d') BETWEEN '" .  date('Y-m-d', strtotime($datefrom))  . "' AND  '" . date('Y-m-d', strtotime($dateto))  . "'";            
        }
        else
        {
            $condtion='';
        }
        if(isset($category_id) && $category_id !='All' && is_numeric($category_id))
        {            
            $con_cat=" and td.category_id = ".$category_id;            
        }
        else
        {
            $con_cat='';
        }
        if(isset($p_name) && $p_name !='All')
        {            
            $con_product=" and p.p_name like '".$p_name."'";            
        }
        else
        {
            $con_product='';
        }
        //$sql = "select * from " . $this->tbl . " where status!='B'";
        $sql = "SELECT cd.contact_person,cp.si_product_id,cp.serial_no,p.p_name,td.* FROM " . $this->tbl . " as td 
inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
inner join si_product as p on p.si_product_id=cp.si_product_id where td.status!='B'".$condtion." ".$con_cat." ".$con_product;
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
            $sql .= " OR td.transaction_date LIKE '" . $requestData['search']['value'] . "%' )";
        }
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);
        //echo $sql;
        $data = array();
        $cnt = $requestData['start'] + 1;
        if(isset($category_id) && $category_id ==3 && is_numeric($category_id))
        {
         $c_sql ="SELECT td.*,cp.*,cd.contact_person FROM `si_transactions_detail` as td 
            inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
            inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            inner join si_product as dp on dp.si_product_id=cp.si_product_id where
             cp.lan_type IN (2) and td.category_id IN (1,2,4) and td.status='A' ".$condtion;
        
        $rs_category=$this->Data_model->Custome_query($c_sql);
        foreach ($rs_category as $rescat) {
            $nestedData = array(); 
            
               $getremarks='';
           if($rescat['category_id']==0)
                    $fre_value='selected';
                else if($rescat['category_id']==1)
                {
                    $fre_value ="Sale";
                    $getremarks=$rescat['new_lan'].'LAN';
                }
                else if($rescat['category_id']==2)
                {
                    $fre_value ="Updation";
                    $getremarks=$rescat['new_lan'].'LAN';
                }
                else if($rescat['category_id']==3)
                {    
                    $fre_value ="Lan";
                    $getremarks=$rescat['new_lan'].'LAN';
                }
                else if($rescat['category_id']==4)
                {
                    $fre_value ="Conversion";
                    $getremarks=$rescat['new_lan'].'LAN';
                }
                else
                    $fre_value ="not geting";
					$url = "Admin/TransactionsDetail/add_payment_view?id=".$rescat['si_clients_id'];
                $nestedData[] = $cnt++;
                $nestedData[] = date('d-m-Y', strtotime($rescat['transaction_date']));
                $nestedData[] = "Lan Tr";   
                $nestedData[] = "<a href='".base_url($url)."'>".$rescat['contact_person']."</a>";
                $nestedData[] = $rescat['serial_no'];
                $nestedData[] = $rescat['p_name'];
                $nestedData[] = $rescat['for_year'];         
                $nestedData[] = $rescat['lan_amount'];
                $nestedData[] = $rescat['payment_type'];
                $nestedData[] = $getremarks."/".$rescat['billremarks']; 
                $data[] = $nestedData;           
        }
        }
        foreach ($query as $dt) {
            $nestedData = array();           
            $getremarks='';
           if($dt['category_id']==0)
                    $fre_value='selected';
                else if($dt['category_id']==1)
                    $fre_value ="Sale";
                else if($dt['category_id']==2)
                    $fre_value ="Updation";
                else if($dt['category_id']==3)
                {    
                    $fre_value ="Lan";
                    $getremarks=$dt['new_lan'].'LAN';
                }
                else if($dt['category_id']==4)
                    $fre_value ="Conversion";
                else
                    $fre_value ="not geting";
					$url = "Admin/TransactionsDetail/add_payment_view?id=".$dt['si_clients_id'];
            $nestedData[] = $cnt++;
            $nestedData[] = date('d-m-Y', strtotime($dt['transaction_date']));
            $nestedData[] = $fre_value;   
            $nestedData[] = "<a href='".base_url($url)."'>".$dt['contact_person']."</a>";//$dt['contact_person'];
            $nestedData[] = $dt['serial_no'];
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['for_year'];         
            $nestedData[] = $dt['amount'];
            $nestedData[] = $dt['payment_type'];
            $nestedData[] = $getremarks."/".$dt['billremarks'];            
           // $nestedData[] =  $sts . "&nbsp" . $edit . "&nbsp" . $delete;
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
