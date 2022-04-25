<?php

/**
 * Created by PhpStorm.
 * User: Dreamworld Solutions
 * Date: 10/07/17
 * Time: 10:52 AM
 */
class AdminDashboard extends CI_Controller {

    public $tbl = "si_admin";
    public $controll = "AdminDashboard";

    public function __construct() {
        parent::__construct();  $this->Data_model->Validation();
        
    }

     public function index() { 
        $data['branch'] = $this->Data_model->Custome_query("select * from ".$this->tbl." where role='A' and status='A'");
        $sql="select p_name as label from si_product where status='A'";
        $data['product'] = $this->Data_model->Custome_query($sql);    
        $data['year'] = $this->Data_model->Custome_query("select yearname from si_for_year where status='A'"); 
        $con="status='A' ";$column="si_admin_id as id,name as name,username as uname";
        $data['admin'] = $this->Data_model->Custom("si_admin",$con,$column);   
         //echo "<pre>";print_r($pro);die;
         $this->load->view('Admin/' . $this->controll, $data);
    }

      public function GetData_onChange() {  extract($_REQUEST);
  
    if($p_name!="all") { $p="and td.p_name='$p_name'";} else { $p=NULL; }
    if($yearname=="all") { $dateto=date('Y-m-d'); $datefrom="2016-01-01";} else { $dateto="$yearname-12-31"; $datefrom="$yearname-01-01"; }
     $condtion="$p and  STR_TO_DATE(td.transaction_date, '%Y-%m-%d') BETWEEN '".$datefrom."'AND  '" . date('Y-m-d', strtotime($dateto))  . "'";  
     
     
       $msql="SELECT  sum(new_lan) as e FROM si_transactions_detail as td 
                   INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id 
                   INNER JOIN si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
                   INNER JOIN si_product as dp on dp.si_product_id=cp.si_product_id WHERE ";
             
    $c_sql ="$msql
                       cp.lan_type IN (2) and td.category_id IN (1,2,4) and td.status='A' and td.lan_amount>0 ".$condtion;
                       $data['LANTR']=intval($this->Data_model->Custome_query($c_sql)[0]['e']);
             
    $d_sql = "$msql
            td.status='A' and td.category_id='3' ".$condtion;
                        $data['LANN'] =intval($this->Data_model->Custome_query($d_sql)[0]['e']);
       
    $srv_sql ="$msql
                    cp.lan_type IN (1) and td.category_id IN (1,2,4) and  td.status='A' and td.lan_amount>0 ".$condtion;
                $data['LAN_SRV'] =intval($this->Data_model->Custome_query($srv_sql)[0]['e']);
                             
          
       $sql = "SELECT count(td.p_name) as total FROM si_transactions_detail as td 
            /*INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id 
            INNER JOIN si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            INNER JOIN si_product as p on p.si_product_id=cp.si_product_id */
            WHERE td.status='A' ".$condtion . " and td.category_id";
      
      $data['Installation'] = $this->Data_model->Custome_query($sql."='1'")[0]['total'];
      $data['Updatation'] = $this->Data_model->Custome_query($sql."='2'")[0]['total'];
      $data['LAN'] = $this->Data_model->Custome_query($sql."='3'")[0]['total'];
      $data['Conversion'] = $this->Data_model->Custome_query($sql."='4'")[0]['total'];
      echo json_encode($data);   // echo "<pre>";print_r($sql);die;
   }
   

      public function GetData_onChange1() {   extract($_REQUEST);
  
    if($p_name!="all") { $p="and td.p_name='$p_name'";} else { $p=NULL; }
    $datefrom="$ym-01";   $dateto=date("Y-m-t", strtotime($datefrom));
      //echo "<pre>";print_r($dateto);die;
       $condtion="$p and  STR_TO_DATE(td.transaction_date, '%Y-%m-%d') BETWEEN '".$datefrom."'AND  '" . date('Y-m-d', strtotime($dateto))  . "'";  
       
       $msql="SELECT sum(new_lan) as e FROM si_transactions_detail as td 
                   INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id 
                   INNER JOIN si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
                   INNER JOIN si_product as dp on dp.si_product_id=cp.si_product_id WHERE ";
          
          $c_sql ="$msql
              cp.lan_type IN (2) and td.category_id IN (1,2,4) and td.status='A' and td.lan_amount>0 ".$condtion;
            $data['LANTR']=intval($this->Data_model->Custome_query($c_sql)[0]['e']);
        
          $d_sql = "$msql 
              td.status='A' and td.category_id='3' ".$condtion;
            $data['LANN'] =intval($this->Data_model->Custome_query($d_sql)[0]['e']);
       
          $srv_sql ="$msql
                  cp.lan_type IN (1) and td.category_id IN (1,2,4) and  td.status='A' and td.lan_amount>0 ".$condtion;
          $data['LAN_SRV'] =intval($this->Data_model->Custome_query($srv_sql)[0]['e']);
      $tlad = "SELECT COUNT(lan.sale_lan_amount) as qty, lan.category_id,lan.lan_type FROM si_transactions_detail as td INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id INNER JOIN si_lan_managed as lan ON td.si_transactions_detail_id=lan.si_transactions_detail_id INNER JOIN si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id INNER JOIN si_product as dp on dp.si_product_id=cp.si_product_id WHERE td.status='A' $p and  STR_TO_DATE(td.transaction_date, '%Y-%m-%d') BETWEEN '".$datefrom."'AND  '" . date('Y-m-d', strtotime($dateto))  . "' GROUP BY lan.category_id,lan.lan_type";
      $resultlan= $this->Data_model->Custome_query($tlad);
      $daju=0;
      $recalicuate=0;
      $data['tryLANInstallation']='';
      $data['tryLANExtend']='';
      foreach ($resultlan as $dt) {
     $c_name = '';
      if($dt['lan_type']==2) { $c_name='LAN'; }
      else if($dt['lan_type']==1) { $c_name='DelSer'; }
      else if($dt['lan_type']==0)  { $c_name='DelWithoutSer'; }
      
      if($dt['category_id']==1) { $ddx ='Installation'; }  
      else if($dt['category_id']==2) { $ddx ='Updation'; }
      else if($dt['category_id']==4) { $ddx ='Conversion'; }
      else  { $ddx ='Extend'; }
            if($daju <3)
            $data['tryLANInstallation'] .= $ddx.' - '.$c_name.' : '.$dt['qty'].'<br> &nbsp; ';
            else
            $data['tryLANExtend'] .= $ddx.' - '.$c_name.' : '.$dt['qty'].'<br> &nbsp; ';
            $recalicuate +=$dt['qty'];
            $daju++;
      }
      $data['tryLANExtend'] .= '<br>Total : '.$recalicuate;
       $sql = "SELECT count(td.p_name) as total FROM si_transactions_detail as td 
            /* INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id 
            inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            inner join si_product as p on p.si_product_id=cp.si_product_id */
            WHERE td.status='A' ".$condtion . " and td.category_id";
      
      $data['Installation'] = $this->Data_model->Custome_query($sql."='1'")[0]['total'];
      $data['Updatation'] = $this->Data_model->Custome_query($sql."='2'")[0]['total'];
      $data['LAN'] = $this->Data_model->Custome_query($sql."='3'")[0]['total'];
      $data['Conversion'] = $this->Data_model->Custome_query($sql."='4'")[0]['total'];
      echo json_encode($data);   
   }

     public function GetData_onChange_Inquiry() {   extract($_REQUEST);
  
    if($admin!="all") { $p="and adm.si_admin_id='$admin'";} else { $p=NULL; }
    if($month_id=="all") { $dateto=date('Y-m-d'); $datefrom="2016-01-01";} else { $dateto=date('Y-m-t', strtotime($month_id)) ; $datefrom="$month_id-01"; }
     
   $condtion="$p and  STR_TO_DATE(inq.created_at, '%Y-%m-%d') BETWEEN '".$datefrom."'AND  '" .$dateto. "'";          
           
       $sql = "SELECT count(adm.si_admin_id) as t FROM si_admin as adm 
            inner join si_inquiry_detail as inq on adm.si_admin_id=inq.inquiry_add_by 
            where adm.status!='B' and inq.status!='B' ".$condtion;
      
      //$data['Inq']= $this->Data_model->Custome_query($sql)[0]['t'];
      $data['P']= $this->Data_model->Custome_query($sql."and inquiry_completion_status='P'")[0]['t']; //Pending
      $data['C']= $this->Data_model->Custome_query($sql."and inquiry_completion_status='C'")[0]['t']; //Completed
     //echo "<pre>";print_r( $sql );die;
    
      echo json_encode($data);   
   }
     
    public function GetData() { 
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'ad.' . $this->tbl . '_id',
            1 => 'ad.name',
            2 => 'ad.update_date',
            3 => 'sws.quantity',
            4 => 'ad.' . $this->tbl . '_id',
        );

        $sql = "SELECT ad.*,sws.quantity as quantity FROM of_admin ad 
LEFT JOIN of_shop_wise_stock sws ON sws.of_admin_id=ad.of_admin_id where ad.role='SA'";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( ad." . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR ad.name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR ad.update_date LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sws.quantity LIKE '" . $requestData['search']['value'] . "%' )";
//            $sql .= " OR vb.branch_name LIKE '" . $requestData['search']['value'] . "%' )";
        }
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;


        foreach ($query as $dt) {
            $nestedData = array();
//            if ($dt['status'] == "A"):
//                $sts = "<a class='status' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
//            else:
//                $sts = "<a class='status' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
//            endif;
////            $edit = "<a class='edit' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span></button></a>";
//            $delete = "<a class='delete' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";
            if ($dt['quantity'] == "") {
                $qty = 0;
            } else {
                $qty = $dt['quantity'];
            }
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['name'];
            $nestedData[] = date('d-m-Y H:i:s', strtotime($dt['update_date']));
            $nestedData[] = $qty;
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

    public function GetData_onChange_By_Graph() { extract($_REQUEST);  
     //$date_from =1530383400;$date_to= 1532975400; //$product_wise_graph_id="Genius";
     
     $FirstDate= "".$yearmonth."-01"; $LastDate =date("Y-m-t", strtotime($FirstDate));
        $date_from = strtotime($FirstDate);  $date_to = strtotime($LastDate);
     
         if($product_wise_graph_id!="all") { $p="and    p_name= '$product_wise_graph_id'";} else { $p=NULL; }
         
        $sql="select sum(amount) as y from si_transactions_detail where status='A' $p ";

for ($i=$date_from; $i<=$date_to; $i+=86400) {  $LB=date("Y-m-d", $i); $TH=date('d',strtotime($LB));
$s= $this->Data_model->Custome_query($sql."and created_at ='$LB' and category_id='1' ")[0]['y'];
$Ins[]= array("label"=>"Installation" ,"t"=>intval($TH),"y"=>intval($s));  
}
for ($i=$date_from; $i<=$date_to; $i+=86400) {  $LB=date("Y-m-d", $i); $TH=date('d',strtotime($LB));
$s= $this->Data_model->Custome_query($sql."and created_at ='$LB' and category_id='2' ")[0]['y'];
$Up[]= array("label"=>"Updatation" ,"t"=>intval($TH),"y"=>intval($s));  
}
for ($i=$date_from; $i<=$date_to; $i+=86400) {  $LB=date("Y-m-d", $i); $TH=date('d',strtotime($LB));
$s= $this->Data_model->Custome_query($sql."and created_at ='$LB' and category_id='3' ")[0]['y'];
$Lan[]= array("label"=>"LAN" ,"t"=>intval($TH),"y"=>intval($s));  
}
for ($i=$date_from; $i<=$date_to; $i+=86400) {  $LB=date("Y-m-d", $i); $TH=date('d',strtotime($LB));
$s= $this->Data_model->Custome_query($sql."and created_at ='$LB' and category_id='4' ")[0]['y'];
$Con[]= array("label"=>"Conversion" ,"t"=>intval($TH),"y"=>intval($s));  
}
 $dataSeries=array_merge($Ins,$Up,$Lan,$Con);

echo json_encode($dataSeries);
        
    }
    public function Passcode() { extract($_REQUEST);  
    $sql="SELECT  count(password) c FROM si_admin WHERE si_admin_id=".$this->session->userdata('id')."  AND password='$passcode' ";
    $R= $this->Data_model->CQ0($sql)['c'];
    if($R==1) {  
    $this->session->set_tempdata('Passcode',1, 120); /// deletes after 2 min
    echo json_encode(1);
    }
    else { echo json_encode(0); }
  }


    

}
