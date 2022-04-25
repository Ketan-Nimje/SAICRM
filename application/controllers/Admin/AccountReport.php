<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AccountReport extends CI_Controller {

    public $controll = "Admin/AccountReport";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/kolkata");
        $this->Data_model->Validation();
    }

    public function index() {
        $data['for_year'] = $this->Data_model->Custome_query("select * from si_for_year where status like 'A'");
        $this->load->view($this->controll,$data);
    }

    public function getData() {
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $solve='';
        $columns = array(
            0 => 'p.si_transactions_detail_id',
            1 => 'p.category_id',
            2 => 'p.p_name',
            3 => 'qty',
            4 => 'p.amount',
            5 => 'p.si_transactions_detail_id',
        );


        if(isset($condtion) && !empty($condtion))
        {            
            $condtion=' and year(transaction_date) LIKE "%'.$year.'%" and  month(transaction_date) LIKE "%'.$month.'%"';
        }  

        else {  $condtion=' and transaction_date like "'.date('Y-m-').'%" ';  }

        $sql = "select *,count(p.p_name) as qty,sum(amount) as t_amount from si_transactions_detail as p WHERE p.status='A' ".$condtion;
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;
        //echo date('n').$sql;
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( p.si_transactions_detail_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.category_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%')";
           // $sql .= " OR qty LIKE '" . $requestData['search']['value'] . "%' ";
            //$sql .= " OR t_amount LIKE '" . $requestData['search']['value'] . "%' 
        }
        $sql .=" GROUP BY p.p_name,p.category_id";
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
        
        $c_sql ="SELECT sum(new_lan) as qty,sum(lan_amount) as t_amount ,p.category_id,p_name,cp.lan_type FROM `si_transactions_detail` as p inner join si_clients_details as cp on cp.si_clients_details_id=p.si_clients_details_id  WHERE cp.lan_type IN (2) and p.category_id IN (1,2,3,4) and p.status='A' and lan_amount>0 ".$condtion;
        $rs_category=$this->Data_model->Custome_query($c_sql);
        foreach ($rs_category as $rescat) {
            $nestedData = array(); 
            if($rescat['qty']>0){
                 $url_fr= "Admin/ProductTransactionsDetail?type=3&year=$year&month=$month";
                $nestedData[] = $cnt++;
                $nestedData[] = 'Lan Tr';
                $nestedData[] = "<a href='".base_url($url_fr)."'>Lan copy</a>";//$rescat['p_name'];
                $nestedData[] = '500';//$rescat['amount'];
                $nestedData[] = $rescat['qty'];                       
                $nestedData[] = $rescat['t_amount']; 
                // $nestedData["DT_RowId"] = "Rows_id" . $dt['si_transactions_detail_id'];
                $data[] = $nestedData;
            }
        }       
        foreach ($query as $dt) {
            $nestedData = array();            
            if($dt['category_id']==1)            
                $c_name='Sale';            
            else if($dt['category_id']==2)
                $c_name='Updation';
            else if($dt['category_id']==3)
                $c_name='Lan';
            else if($dt['category_id']==4)
                $c_name='Conversion';
            else
                $c_name='Select';
            if($dt['category_id']!=3){
               $url_fr= "Admin/ProductTransactionsDetail?product=".$dt['p_name']."&type=".$dt['category_id']."&year=$year&month=$month";
            $nestedData[] = $cnt++;
            $nestedData[] = $c_name;
            $nestedData[] = "<a href='".base_url($url_fr)."'>".$dt['p_name']."</a>";
            $nestedData[] = $dt['amount'];
            $nestedData[] = $dt['qty'];                       
            $nestedData[] = $dt['t_amount']; 
           // $nestedData["DT_RowId"] = "Rows_id" . $dt['si_transactions_detail_id'];
            $data[] = $nestedData;
            }
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
