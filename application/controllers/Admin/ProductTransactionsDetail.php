<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductTransactionsDetail extends CI_Controller {
    private $tbl = "si_transactions_detail";
    public $controll = "Admin/ProductTransactionsDetail";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/kolkata");
        $this->Data_model->Validation();
    }

    public function index() {
        $data['product'] = $this->Data_model->Custome_query("select p_name from si_product where status like 'A' ");
        $data['selected'] = $_REQUEST;
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
            if(isset($requestData['QQyear']) && ($requestData['QQmonth'])) 
            {
                $mm=$requestData['QQmonth'];$yy=$requestData['QQyear'];
                $datefrom='01-'.$mm.'-'.$yy; 
                $dateto=date("t-m-Y", strtotime($datefrom));
            } 
                $condtion=" AND  ( STR_TO_DATE(td.transaction_date, '%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($datefrom)) . "' AND  '" . date('Y-m-d', strtotime($dateto)) . "' )";
        }
        else
        {
            $condtion='';
        }
        
        if(isset($category_id) && $category_id !='All' && is_numeric($category_id))
        {            
            $con_cat=" AND ( td.category_id = ".$category_id. " )";            
        }
        else
        {
            $con_cat='';
        }
        if(isset($p_name) && $p_name !='All' && (count($p_name)>0) )
            {   $cn=count($p_name);  
            if($cn > 1) {  
                                for($i=0; $i<=$cn-2; $i++) {  $v[]= " p.p_name LIKE '".$p_name[$i]."' OR "; } 
            } else {  $v[]='';}
            
            $w[]= " p.p_name ='".$p_name[$cn-1]."'  "; 
            
            $u=array_merge($v,$w);
            $e=implode(' ',$u);   $con_product="AND ( $e ) ";
        }
        else
        {
            $con_product=" AND (1=2) ";
        }
        if(isset($payment) && $payment == 1)
        {            
            $paymentdue=" AND ( td.paymentdue like '".$payment."' ) ";
        }
        else
        {
            $paymentdue='';
        }
        //$sql = "select * from " . $this->tbl . " where status!='B'";
        $sql = "SELECT cd.contact_person,cp.si_product_id,cp.serial_no,p.p_name,td.* FROM " . $this->tbl . " as td 
inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
inner join si_product as p on p.si_product_id=cp.si_product_id where td.status!='B' $con_product  $condtion  $con_cat  $paymentdue  ";
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
        if(isset($category_id) && $category_id ==5 && is_numeric($category_id))
        {
         $srv_sql ="SELECT td.*,cp.*,cd.contact_person FROM `si_transactions_detail` as td 
            INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id 
            INNER JOIN si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            INNER JOIN si_product as dp on dp.si_product_id=cp.si_product_id where
             cp.lan_type IN (1) and td.category_id IN (1,2,4) and  td.status='A' and td.lan_amount>0 ".$condtion;
        
        $srv_category=$this->Data_model->Custome_query($srv_sql);
        
        foreach ($srv_category as $rescat) {
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
                $nestedData[] = $cnt++ . "&nbsp;&nbsp;&nbsp; <input class='delete'type='checkbox'id='chk' data-id='".$rescat['si_transactions_detail_id']."' name='id[]' > ";
                $nestedData[] = date('d-m-Y', strtotime($rescat['transaction_date']));
                $nestedData[] = "Lan with srv";   
                $nestedData[] =  "<a href='".base_url()."/".$url."'>".$rescat['contact_person']."</a>";
                
                if(strlen($rescat['serial_no'])>14) {
                $nestedData[] =  chunk_split($rescat['serial_no'], 14, "\n"); }
                else {  $nestedData[] = $rescat['serial_no'];  }

                $nestedData[] =$rescat['p_name'];
                 $nestedData[] =  "<a class='seePro ".$rescat[$this->tbl . '_id']."pop small-btn'  data-id='" . $rescat[$this->tbl . '_id'] ."' seepro='".$rescat['for_year']."' ><button class='btn btn-xs btn-info '>".$rescat['for_year']."</button></a>";         
                $nestedData[] = $rescat['lan_amount'];
                $nestedData[] = $rescat['payment_type'];
                $nestedData[] = $getremarks."/".$rescat['billremarks']; 
                $data[] = $nestedData;           
        }
        }
        if(isset($category_id) && $category_id ==3 && is_numeric($category_id))
        {
         $c_sql ="SELECT td.*,cp.*,cd.contact_person FROM `si_transactions_detail` as td 
            inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
            inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            inner join si_product as dp on dp.si_product_id=cp.si_product_id where
             cp.lan_type IN (2) and td.category_id IN (1,2,4) and td.status='A' and td.lan_amount>0 ".$condtion;
        /* $srv_sql ="SELECT td.*,cp.*,cd.contact_person FROM `si_transactions_detail` as td 
            inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
            inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            inner join si_product as dp on dp.si_product_id=cp.si_product_id where
             cp.lan_type IN (1) and td.category_id IN (1,2,4) and td.status='A' and td.lan_amount>0 ".$condtion;*/
        $rs_category=$this->Data_model->Custome_query($c_sql);
        //$srv_category=$this->Data_model->Custome_query($srv_sql);
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
                $nestedData[] = $cnt++ . "&nbsp;&nbsp;&nbsp; <input class='delete' type='checkbox' id='chk' data-id='".$rescat['si_transactions_detail_id']."' name='id[]' > ";
                $nestedData[] = date('d-m-Y', strtotime($rescat['transaction_date']));
                $nestedData[] = "Lan Tr";   
                $nestedData[] =  "<a href='".base_url()."/".$url."'>".$rescat['contact_person']."</a>";
                $nestedData[] = $rescat['serial_no'];
                $nestedData[] =$rescat['p_name'];
                 $nestedData[] =  "<a class='seePro ".$rescat[$this->tbl . '_id']."pop small-btn'  data-id='" . $rescat[$this->tbl . '_id'] ."' seepro='".$rescat['for_year']."' ><button class='btn btn-xs btn-info '>".$rescat['for_year']."</button></a>";        
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
            $nestedData[] = $cnt++ . "&nbsp;&nbsp;&nbsp; <input class='delete' type='checkbox' id='chk' data-id='".$dt['si_transactions_detail_id']."' name='id[]' > ";
            $nestedData[] = date('d-m-Y', strtotime($dt['transaction_date']));
            $nestedData[] = $fre_value;   
            $nestedData[] = "<a href='".base_url($url)."'>".$dt['contact_person']."</a>";//$dt['contact_person'];
            $nestedData[] = $dt['serial_no'];
            $nestedData[] = $dt['p_name'];
            $nestedData[] =  "<a class='seePro ".$dt[$this->tbl . '_id']."pop small-btn'  data-id='" . $dt[$this->tbl . '_id'] ."' seepro='".$dt['for_year']."' ><button class='btn btn-xs btn-info '>".$dt['for_year']."</button></a>";         
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
    
    public  function get_excel_data() {
        extract($_REQUEST);
         
        if(isset($datefrom))
        {            
            $condtion=" and STR_TO_DATE(td.transaction_date, '%Y-%m-%d') BETWEEN '" .  date('Y-m-d', strtotime($datefrom))  . "' AND  '" . date('Y-m-d', strtotime($dateto))  . "'";            
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
        
        if(isset($si_for_year_id[0]) && $si_for_year_id[0] !='All')
        {            
            $con_product=" and p.p_name like '".$si_for_year_id[0]."'";            
        }
        else
        {
            $con_product='';
        }
               
        $sql = "SELECT DATE_FORMAT(td.transaction_date, '%d-%m-%Y') as transaction_date,cd.contact_person,cd.firm_name,cd.address,cd.registed_mobile,'Ashish Agarwal' AS dealer,p.p_name,cp.laptop,td.for_year,cp.reg_type,cp.serial_no, td.amount, 'NULL' AS EXECUTIVE,td.billremarks,cd.register_email FROM " . $this->tbl . " as td 
inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
inner join si_product as p on p.si_product_id=cp.si_product_id where td.status!='B'".$condtion." ".$con_cat." ".$con_product;
     
        $query = $this->Data_model->Custome_query($sql);
        //echo $sql;
        $cnt=0;
        $data = array();
        $srv_category= array();
        $rs_category = array();
        if(isset($category_id) && $category_id ==5 && is_numeric($category_id))
        {
         $srv_sql ="SELECT DATE_FORMAT(td.transaction_date, '%d-%m-%Y') as transaction_date,cd.contact_person,cd.firm_name,cd.address,cd.registed_mobile,'Ashish Agarwal' AS dealer,dp.p_name,cp.laptop,td.for_year,cp.reg_type,cp.serial_no,td.lan_amount as amount,'' AS EXECUTIVE,td.billremarks,cd.register_email FROM `si_transactions_detail` as td 
            inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
            inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            inner join si_product as dp on dp.si_product_id=cp.si_product_id where
             cp.lan_type IN (1) and td.category_id IN (1,2,4) and  td.status='A' and td.lan_amount>0 ".$condtion;
        
        $srv_category=$this->Data_model->Custome_query($srv_sql);        
      
        }
        if(isset($category_id) && $category_id ==3 && is_numeric($category_id))
        {
         $c_sql ="SELECT DATE_FORMAT(td.transaction_date, '%d-%m-%Y') as transaction_date,cd.contact_person,cd.firm_name,cd.address,cd.registed_mobile,'Ashish Agarwal' AS dealer,dp.p_name,cp.laptop,td.for_year,cp.reg_type,cp.serial_no,td.lan_amount as amount,'' AS EXECUTIVE,td.billremarks,cd.register_email FROM `si_transactions_detail` as td 
            inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
            inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            inner join si_product as dp on dp.si_product_id=cp.si_product_id where
             cp.lan_type IN (2) and td.category_id IN (1,2,4) and td.status='A' and td.lan_amount>0 ".$condtion;
        /* $srv_sql ="SELECT DATE_FORMAT(td.transaction_date, '%d-%m-%Y') as transaction_date,cd.contact_person,cd.firm_name,cd.address,cd.registed_mobile,'Ashish Agarwal' AS dealer,dp.p_name,cp.laptop,td.for_year,cp.reg_type,cp.serial_no,td.lan_amount as amount,'' AS EXECUTIVE,td.billremarks,cd.register_email FROM `si_transactions_detail` as td 
            inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
            inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
            inner join si_product as dp on dp.si_product_id=cp.si_product_id where
             cp.lan_type IN (1) and td.category_id IN (1,2,4) and td.status='A' and td.lan_amount>0 ".$condtion;*/
        $rs_category=$this->Data_model->Custome_query($c_sql);
        //$srv_category=$this->Data_model->Custome_query($srv_sql);
        
        }
        
        //echo json_encode($data);
        //die;
        $query_marge=array_merge($query,$rs_category,$srv_category);
        $excel='gwer';
        if (isset($excel)) {
            require_once APPPATH . '/third_party/Phpexcel/Bootstrap.php';

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

// Set document properties
            $spreadsheet->getProperties()->setCreator('http://saiinfotech.co')
                    ->setLastModifiedBy('Hashrail Devloper')
                    ->setTitle('H')
                    ->setSubject('Sale Report Detail')
                    ->setDescription('Dealer : Ashish Agarwal');

            // add style to the header
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                    'top' => array(
                        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array(
                        'argb' => 'FFA0A0A0',
                    ),
                    'endcolor' => array(
                        'argb' => 'FFFFFFFF',
                    ),
                ),
            );

            //#c5efce
            $spreadsheet->getActiveSheet()->getStyle('A1:O1')->applyFromArray($styleArray);

            $styleArrayFamily = array(
                'font' => array(
                    'bold' => true,
                ),
            );
            // Head member color and bold
            $styleArrayHead = array(
                'font' => array(
                    'bold' => true,
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array(
                        'argb' => 'c5efce',
                    ),
                    'endcolor' => array(
                        'argb' => 'c5efce',
                    ),
                ),
            );
            // auto fit column to content

            foreach (range('A', 'V') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
            // set the names of header cells
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A1", 'Sr No')
                    ->setCellValue("B1", 'Date')
                    ->setCellValue("C1", 'Client')
                    ->setCellValue("D1", 'Address')
                    ->setCellValue("E1", 'Contact No.')
                    ->setCellValue("F1", 'Dealer')
                    ->setCellValue("G1", 'Product')
                    ->setCellValue("H1", 'Laptop')
                    ->setCellValue("I1", 'Session')
                    ->setCellValue("J1", 'AM')
                    ->setCellValue("K1", 'Product Key')
                    ->setCellValue("L1", 'Amount')
                    ->setCellValue("M1", 'Executive')
                    ->setCellValue("N1", 'Remarks')
                    ->setCellValue("O1", 'EMail Id');
//echo $img = base_url('/assets/Uploads/headImage/') . $hr['image'];
//$img64 = base64_encode($img);
//$imgDe64 = base64_decode($img64);
            // Add some data
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            //var_dump($query);die;
            foreach ($query_marge as $hr) {
//                if ((array_key_exists('image', $hr))) {
//
//                    $path = base_url('/assets/Uploads/headImage/') . $hr['image'];
//                    $type = pathinfo($path, PATHINFO_EXTENSION);
//                    $datas1 = file_get_contents($path);
//                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($datas1);
//                    $img = $this->base64_to_jpeg($base64, $path);
//                }     
                //var_dump($hr['transaction_date']);die;          
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", $i)
                        ->setCellValue("B$x", (array_key_exists('transaction_date', $hr) == true) ? $hr['transaction_date'] : "")
                        ->setCellValue("C$x", (array_key_exists('contact_person', $hr) == true) ? $hr['contact_person']."/".$hr['firm_name'] : "")
                        ->setCellValue("D$x", (array_key_exists('address', $hr) == true) ? $hr['address'] : "")
                        ->setCellValue("E$x", (array_key_exists('registed_mobile', $hr) == true) ? $hr['registed_mobile'] : "")
                        ->setCellValue("F$x", (array_key_exists('dealer', $hr) == true) ? $hr['dealer'] : "")
                        ->setCellValue("G$x", (array_key_exists('p_name', $hr) == true) ? $hr['p_name'] : "")
                        ->setCellValue("H$x", (array_key_exists('laptop', $hr) == true) ? $hr['laptop'] : "")
                        ->setCellValue("I$x", (array_key_exists('for_year', $hr) == true) ? $hr['for_year'] : "")
                        ->setCellValue("J$x", (array_key_exists('reg_type', $hr) == true) ? $hr['reg_type'] : "")
                        ->setCellValue("K$x", (array_key_exists('serial_no', $hr) == true) ? $hr['serial_no'] : "")
                        ->setCellValue("L$x", (array_key_exists('amount', $hr) == true) ? $hr['amount'] : "")
                        ->setCellValue("M$x", (array_key_exists('EXECUTIVE', $hr) == true) ? $hr['EXECUTIVE'] : "")
                        ->setCellValue("N$x", (array_key_exists('billremarks', $hr) == true) ? $hr['billremarks'] : "")
                        ->setCellValue("O$x", (array_key_exists('register_email', $hr) == true) ? $hr['register_email'] : "");
                $x++;
                $i++;
            }
            //var_dump($spreadsheet);die;
//echo "<pre>";
//            print_r($spreadsheet->setActiveSheetIndex()); die;
// Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Sale Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='SaleReporte'.date('d-m-Y');
// Redirect output to a clientâ€™s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$anme.'.xls"');
            header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel5');
            $writer->save('php://output');
            //var_dump($query);
            exit;

            //  create new file and remove Compatibility mode from word title
        }
    }  

    public  function create_excel_sales_report() { extract($_REQUEST);

            $e=$this->session->tempdata('sales_report');

            $con="AND td.si_transactions_detail_id  IN(".$e.") ";


        $sql = "SELECT 
        DATE_FORMAT(td.transaction_date, '%d-%m-%Y') as transaction_date,
        cd.contact_person,
        cd.firm_name,
        cd.address,
        cd.registed_mobile,
        'Ashish Agarwal' AS dealer,
        p.p_name,
        cp.laptop,
        td.for_year,
        cp.reg_type,
        cp.serial_no,
        td.amount,
        cp.referby AS EXECUTIVE,
        td.billremarks, 
        td.new_lan ,
        cd.register_email ,
        td.category_id,
        cp.lan_type,
        IFNULL(td.taxamount, 0) as taxamount ,
        td.payment_type,
        td.billnumber,
        td.deposit_bank,
        td.amount,
        td.costamount

        FROM " . $this->tbl . " as td 
        INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id 
        INNER JOIN si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
        INNER JOIN si_product as p on p.si_product_id=cp.si_product_id where td.status!='B'".$con;
     
        $query = $this->Data_model->Custome_query($sql);



           /* echo "<pre>";
            print_r(($sql));
            die;  */
            
        $excel='gwer';
        if (isset($excel)) {
            require_once APPPATH . '/third_party/Phpexcel/Bootstrap.php';

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

            // Set document properties
            $spreadsheet->getProperties()->setCreator('http://saiinfotech.co')
                    ->setLastModifiedBy('Hashrail Devloper')
                    ->setTitle('H')
                    ->setSubject('Sale Report Detail')
                    ->setDescription('Dealer : Ashish Agarwal');

            // add style to the header
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                    'top' => array(
                        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array(
                        'argb' => 'FFA0A0A0',
                    ),
                    'endcolor' => array(
                        'argb' => 'FFFFFFFF',
                    ),
                ),
            );

            //#c5efce
            $spreadsheet->getActiveSheet()->getStyle('A1:S1')->applyFromArray($styleArray);

            $styleArrayFamily = array(
                'font' => array(
                    'bold' => true,
                ),
            );
            // Head member color and bold
            $styleArrayHead = array(
                'font' => array(
                    'bold' => true,
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array(
                        'argb' => 'c5efce',
                    ),
                    'endcolor' => array(
                        'argb' => 'c5efce',
                    ),
                ),
            );
            // auto fit column to content

            foreach (range('A', 'V') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
            // set the names of header cells
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A1", 'Sr No')
                    ->setCellValue("B1", 'SERIAL NO')
                    ->setCellValue("C1", 'Bill No')
                    ->setCellValue("D1", 'Date')
                    ->setCellValue("E1", 'Client Name')
                    ->setCellValue("F1", 'EMail Id')
                    ->setCellValue("G1", 'Mobile')
                    ->setCellValue("H1", 'Product')
                    ->setCellValue("I1", 'Session')
                    ->setCellValue("J1", 'Sale Amount with Tax')
                    ->setCellValue("K1", 'Sale Amount without Tax')
                    ->setCellValue("L1", 'Purchase Amount')
                    ->setCellValue("M1", 'EXECUTIVE')
                    ->setCellValue("N1", 'Remarks')
                    ->setCellValue("O1", 'Payment Type')
                    ->setCellValue("P1", 'LAN Type')
                    ->setCellValue("Q1", 'LAN Remark')
                    ->setCellValue("R1", 'LAN Changes')
                    ->setCellValue("S1", 'Category')
                    ->setCellValue("T1", 'Deposit Bank')
                    ->setCellValue("U1", 'Amount');
//echo $img = base_url('/assets/Uploads/headImage/') . $hr['image'];
//$img64 = base64_encode($img);
//$imgDe64 = base64_decode($img64);
            // Add some data
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            //var_dump($query);die;
            //echo "<pre>";print_r($query_marge);die;
            foreach ($query as $hr) {



                //var_dump($hr['transaction_date']);die;     
                if($hr['category_id']==1) { $cat='Sale';}
                else if($hr['category_id']==2) { $cat='Updation'; }
                else if($hr['category_id']==3) { $cat='LAN'; }
                else if($hr['category_id']==4) { $cat='Conversion'; }
                else { $cat='';}  
                
                if($hr['lan_type']==0) { $lan_type='Decl Without Srv';}
                else if($hr['lan_type']==1) { $lan_type='Decl With Srv'; }
                else if($hr['lan_type']==2) { $lan_type='LAN'; }
                else { $lan_type='';}   
                
                $nil="NULL"; 
                  
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", $i)
                        ->setCellValue("B$x", (array_key_exists('serial_no', $hr) == true) ? $hr['serial_no'] : "")
                        ->setCellValue("C$x", (array_key_exists('billnumber', $hr) == true) ? $hr['billnumber'] : "")
                        ->setCellValue("D$x", (array_key_exists('transaction_date', $hr) == true) ? $hr['transaction_date'] : "")
                        ->setCellValue("E$x", (array_key_exists('contact_person', $hr) == true) ? $hr['contact_person']." | ".$hr['firm_name'] : "")
                        ->setCellValue("F$x", (array_key_exists('register_email', $hr) == true) ? $hr['register_email'] : "")
                        ->setCellValue("G$x", (array_key_exists('registed_mobile', $hr) == true) ? $hr['registed_mobile'] : "")
                        ->setCellValue("H$x", (array_key_exists('p_name', $hr) == true) ? $hr['p_name'] : "")
                        ->setCellValue("I$x", (array_key_exists('for_year', $hr) == true) ? $hr['for_year'] : "")
                        ->setCellValue("J$x", (array_key_exists('amount', $hr) == true) ? intval($hr['amount'] + $hr['taxamount']) : "")
                        ->setCellValue("K$x", (array_key_exists('amount', $hr) == true) ? $hr['amount'] : "")
                        ->setCellValue("L$x", (array_key_exists('costamount', $hr) == true) ? $hr['costamount'] : "")
                        ->setCellValue("M$x", (array_key_exists('EXECUTIVE', $hr) == true) ? $hr['EXECUTIVE'] : "")
                        ->setCellValue("N$x", (array_key_exists('reg_type', $hr) == true) ? $nil: "")
                        ->setCellValue("O$x", (array_key_exists('payment_type', $hr) == true) ? $hr['payment_type'] : "")
                        ->setCellValue("P$x", (array_key_exists('lan_type', $hr) == true) ? $lan_type : "")
                        ->setCellValue("Q$x", $hr['billremarks']." LAN  / ".$hr['billremarks'] )
                        ->setCellValue("R$x", (array_key_exists('new_lan', $hr) == true) ? $hr['new_lan'] : "")
                        ->setCellValue("S$x",$cat)
                        ->setCellValue("T$x", (array_key_exists('deposit_bank', $hr) == true) ? $hr['deposit_bank'] : "")
                        ->setCellValue("U$x", (array_key_exists('amount', $hr) == true) ? $hr['amount'] : "");
                $x++;
                $i++;
            }
             

            /*
            $sql = "SELECT DATE_FORMAT(td.transaction_date, '%d-%m-%Y') as transaction_date,cd.contact_person,cd.firm_name,cd.address,cd.registed_mobile,
        'Ashish Agarwal' AS dealer,p.p_name,cp.laptop,td.for_year,cp.reg_type,cp.serial_no,td.amount,
         cp.referby AS EXECUTIVE,td.billremarks, td.new_lan ,cd.register_email , td.category_id FROM " . $this->tbl . " as td 
        INNER JOIN si_clients as cd on cd.si_clients_id=td.si_clients_id 
        INNER JOIN si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
        INNER JOIN si_product as p on p.si_product_id=cp.si_product_id where td.status!='B'".$con;
     
        $query = $this->Data_model->Custome_query($sql);
            
        $excel='gwer';
        if (isset($excel)) {
            require_once APPPATH . '/third_party/Phpexcel/Bootstrap.php';
            //echo "<pre>"; print_r($excel); die;

            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

// Set document properties
            $spreadsheet->getProperties()->setCreator('http://saiinfotech.co')
                    ->setLastModifiedBy('Hashrail Devloper')
                    ->setTitle('H')
                    ->setSubject('Sale Report Detail')
                    ->setDescription('Dealer : Ashish Agarwal');

            // add style to the header
            $styleArray = array(
                'font' => array(
                    'bold' => true,
                ),
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ),
                'borders' => array(
                    'top' => array(
                        'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ),
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array(
                        'argb' => 'FFA0A0A0',
                    ),
                    'endcolor' => array(
                        'argb' => 'FFFFFFFF',
                    ),
                ),
            );

            //#c5efce
            $spreadsheet->getActiveSheet()->getStyle('A1:P1')->applyFromArray($styleArray);

            $styleArrayFamily = array(
                'font' => array(
                    'bold' => true,
                ),
            );
            // Head member color and bold
            $styleArrayHead = array(
                'font' => array(
                    'bold' => true,
                ),
                'fill' => array(
                    'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startcolor' => array(
                        'argb' => 'c5efce',
                    ),
                    'endcolor' => array(
                        'argb' => 'c5efce',
                    ),
                ),
            );
            // auto fit column to content

            foreach (range('A', 'V') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
            // set the names of header cells
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A1", 'Sr No')
                    ->setCellValue("B1", 'Date')
                    ->setCellValue("C1", 'Client')
                    ->setCellValue("D1", 'Address')
                    ->setCellValue("E1", 'Contact No.')
                    ->setCellValue("F1", 'EMail Id')
                    ->setCellValue("G1", 'Product')
                    ->setCellValue("H1", 'Laptop')
                    ->setCellValue("I1", 'Session')
                    ->setCellValue("J1", 'AM')
                    ->setCellValue("K1", 'Product Key')
                    ->setCellValue("L1", 'Amount')
                    ->setCellValue("M1", 'Executive')
                    ->setCellValue("N1", 'Remarks')
                    ->setCellValue("O1", 'Dealer')
                    ->setCellValue("P1", 'Category');
//echo $img = base_url('/assets/Uploads/headImage/') . $hr['image'];
//$img64 = base64_encode($img);
//$imgDe64 = base64_decode($img64);
            // Add some data
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            //var_dump($query);die;
            //echo "<pre>";print_r($query_marge);die;
            foreach ($query as $hr) {
//                if ((array_key_exists('image', $hr))) {
//
//                    $path = base_url('/assets/Uploads/headImage/') . $hr['image'];
//                    $type = pathinfo($path, PATHINFO_EXTENSION);
//                    $datas1 = file_get_contents($path);
//                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($datas1);
//                    $img = $this->base64_to_jpeg($base64, $path);
//                }     
                //var_dump($hr['transaction_date']);die;     
                if($hr['category_id']==1) { $cat='Sale';}
                else if($hr['category_id']==2) { $cat='Updation'; }
                else if($hr['category_id']==3) { $cat='LAN'; }
                else if($hr['category_id']==4) { $cat='Conversion'; }
                else { $cat='';}   
                  
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", $i)
                        ->setCellValue("B$x", (array_key_exists('transaction_date', $hr) == true) ? $hr['transaction_date'] : "")
                        ->setCellValue("C$x", (array_key_exists('contact_person', $hr) == true) ? $hr['contact_person']." | ".$hr['firm_name'] : "")
                        ->setCellValue("D$x", (array_key_exists('address', $hr) == true) ? $hr['address'] : "")
                        ->setCellValue("E$x", (array_key_exists('registed_mobile', $hr) == true) ? $hr['registed_mobile'] : "")
                         ->setCellValue("F$x", (array_key_exists('register_email', $hr) == true) ? $hr['register_email'] : "")
                        ->setCellValue("G$x", (array_key_exists('p_name', $hr) == true) ? $hr['p_name'] : "")
                        ->setCellValue("H$x", (array_key_exists('laptop', $hr) == true) ? $hr['laptop'] : "")
                        ->setCellValue("I$x", (array_key_exists('for_year', $hr) == true) ? $hr['for_year'] : "")
                        ->setCellValue("J$x", (array_key_exists('reg_type', $hr) == true) ? $hr['reg_type'] : "")
                        ->setCellValue("K$x", (array_key_exists('serial_no', $hr) == true) ? $hr['serial_no'] : "")
                        ->setCellValue("L$x", (array_key_exists('amount', $hr) == true) ? $hr['amount'] : "")
                        ->setCellValue("M$x", (array_key_exists('EXECUTIVE', $hr) == true) ? $hr['EXECUTIVE'] : "")
                        //->setCellValue("N$x", (array_key_exists('billremarks', $hr) == true) ? $hr['billremarks'] : "")
                        ->setCellValue("N$x", $hr['new_lan']." LAN  / ".$hr['billremarks'] )
                        ->setCellValue("O$x", (array_key_exists('dealer', $hr) == true) ? $hr['dealer'] : "")
                         ->setCellValue("P$x",$cat);
                $x++;
                $i++;
            }
*/



            //var_dump($spreadsheet);die;

// Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Sale Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='Sales_Report'.date('d-m-Y H-i-s');
// Redirect output to a clientâ€™s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$anme.'.xls"');
            header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

           $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel5');
           $writer->save('php://output');

            //var_dump($query);
            redirect('ProductTransactionsDetail');
            exit;

            //  create new file and remove Compatibility mode from word title
        }
        //echo json_encode(1);

    } 

    public function excel_ids_lists(){  extract($_REQUEST);
        $this->session->set_tempdata('sales_report',$id, 120); /// deletes after 5 min
        echo json_encode(1);
    }
    
    public function assigned() { extract($_REQUEST);
        $sql="SELECT i.for_year AS assigned FROM si_transactions_detail i WHERE i.si_transactions_detail_id='$id'  ";
        $R = $this->Data_model->Custome_query($sql)[0];
        echo json_encode($R);
    }
    
    public function listYear() { extract($_REQUEST);
        $sql="SELECT yearname year FROM si_for_year WHERE status='A'   ";
        $R = $this->Data_model->Custome_query($sql);
        echo json_encode($R);
    }
    
    public function assign_to() { extract($_REQUEST);
            $sql="SELECT si_clients_details_id id FROM si_transactions_detail WHERE  si_transactions_detail_id='$hid_id'   ";
            $id = $this->Data_model->Custome_query($sql)[0]['id'];
            $sql="UPDATE si_transactions_detail SET for_year='$assign_id' WHERE  si_transactions_detail_id='$hid_id'  ";
            $this->Data_model->Custome_query_exe($sql);
            $ysql="SELECT si_for_year_id yid FROM si_for_year WHERE  yearname='$assign_id'   ";
            $yid = $this->Data_model->Custome_query($ysql)[0]['yid'];
            //  echo "<pre>"; print_r($yid);die;
            $sql="UPDATE si_clients_details SET si_for_year_id='$yid' WHERE  si_clients_details_id='$id'  ";
            $this->Data_model->Custome_query_exe($sql);
        
        echo json_encode(1);
    }


























}
