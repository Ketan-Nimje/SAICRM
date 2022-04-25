<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AccountReport extends CI_Controller {

    public $controll = "Admin/AccountReport";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/kolkata");
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
            4 => 'p.totalamount',
            5 => 'p.si_transactions_detail_id',
        );              
        if(isset($condtion) && !empty($condtion))
        {            
            $condtion=' and for_year like "%'.$year.'%" and  month(transaction_date) LIKE "%'.$month.'%"';            
        }
        else
        {
        $condtion=' and for_year like "%'.date('Y').'%" and  month(transaction_date) LIKE "%'.date('n').'%"';
        }
        $sql = "select *,count(amount) as qty,sum(amount) as t_amount from si_transactions_detail as p WHERE p.status='A' ".$condtion;
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

        foreach ($query as $dt) {
            $nestedData = array();            
            if($dt['category_id']==1)
                $c_name='sale';
            else if($dt['category_id']==2)
                $c_name='updation';
            else if($dt['category_id']==3)
                $c_name='lan';
            else if($dt['category_id']==4)
                $c_name='conversion';
            else
                $c_name='select';
            $nestedData[] = $cnt++;
            $nestedData[] = $c_name;
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['amount'];
            $nestedData[] = $dt['qty'];                       
            $nestedData[] = $dt['t_amount']; 
           // $nestedData["DT_RowId"] = "Rows_id" . $dt['si_transactions_detail_id'];
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
