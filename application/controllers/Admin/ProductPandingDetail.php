<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ProductPandingDetail extends CI_Controller {
    private $tbl = "si_clients_details";
    public $controll = "Admin/ProductPandingDetail";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/kolkata");  $this->Data_model->Validation();
    }

    public function index() {        
       $data['product'] = $this->Data_model->Custome_query("select p_name from si_product where status like 'A'");       
       $data['years'] = $this->Data_model->Custome_query("select yearname  from si_for_year where status like 'A'");       
       $this->load->view($this->controll,$data);
    }

    public function GetData() {
        extract($_REQUEST);
        
        //echo "<pre>"; print_r($_REQUEST); die;
        
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'cd.firm_name',
            2 => 'cd.contact_person', 
            3 => 'cp.serial_no',
            4 => 'p.p_name',
            5 => 'cp.total_lan',
            /*6 => 'cd.address',
            7 => 'pp.purchase_date',
*/          6 => 'cd.registed_mobile',
            7 => 'cd.register_email',                                                          
        );
        
        $con_product='';$con_year='';

        if(isset($p_name) && $p_name !='All')
        {            
            $con_product=" and p.p_name like '".$p_name."'";            
        }
        
        if(isset($yearname) && $yearname !='All')
        {            
            $con_year="where for_year=$yearname";            
        }
        if(isset($st_status) && $st_status !=1)
        {            
            $con_st="and cp.status='A'";            
        }else{
            $con_st="";
        }
       
        //$sql = "select * from " . $this->tbl . " where status!='B'";
        /*        $sql = "SELECT cp.si_clients_details_id,p.p_name,cp.*,cd.*,date_format(pp.purchase_date,'%d/%m/%Y') as purchase_date FROM si_clients_details as cp inner join si_clients as cd on cd.si_clients_id=cp.si_clients_id inner join si_product as p on p.si_product_id=cp.si_product_id inner join si_product_purchase as pp on pp.si_clients_details_id=cp.si_clients_details_id WHERE cp.si_clients_details_id NOT IN (SELECT si_clients_details_id FROM si_transactions_detail GROUP BY si_clients_details_id) and cp.status='A' and cd.status='A' and cp.si_for_year_id=1 ";*/
        $sql = "SELECT cp.si_clients_details_id,p.p_name,cp.*,cd.* FROM si_clients_details as cp inner join si_clients as cd on cd.si_clients_id=cp.si_clients_id inner join si_product as p on p.si_product_id=cp.si_product_id  WHERE cp.si_clients_details_id NOT IN 
        (SELECT si_clients_details_id FROM si_transactions_detail $con_year  GROUP BY si_clients_details_id ) 
         ".$con_st." and cd.status!='B' ".$con_product."  /*and cp.si_for_year_id=4 */ ";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;        
        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( cp.si_clients_details_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.contact_person LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cp.serial_no LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.firm_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.registed_mobile LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.register_email LIKE '" . $requestData['search']['value'] . "%' )";
        }
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
       if($requestData['length'] != '-1') {
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";          
            } else {  $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir']; }
            
        $query = $this->Data_model->Custome_query($sql);
        //echo $sql;
        $data = array();
        $cnt = $requestData['start'] + 1;
        
        foreach ($query as $dt) {
            $nestedData = array();   
            $sms= "<a class='sms small-btn' data-smsid='" . $dt['registed_mobile'] . "' title='Send SMS' data-id='".$dt['si_clients_details_id']."'><button class='btn btn-xs btn-primary'><span class='fa-stack'><i class='fa fa-envelope fa-stack-1x fa-inverse'></i></span></button></a>";  
            $whatsapp = "<a class='whatsapp small-btn' data-id='" . $dt['registed_mobile'] . "' id='" . $dt['si_clients_details_id'] . "' title='Send WhatsApp' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-whatsapp fa-stack-1x fa-inverse'></i></span></button></a>";       
            $nestedData[] = $cnt++ . "&nbsp;&nbsp;&nbsp; <input class='delete' type='checkbox' id='chk' data-id='".$dt['registed_mobile']."' cn='".$dt['contact_person']."' value='".$dt['registed_mobile']."' 
                sn='".$dt['serial_no']."'   pn='".$dt['p_name']."'
             name='id[]' > ";
            $nestedData[] =$dt['firm_name'];
            $nestedData[] = $dt['contact_person'];
            $nestedData[] = $dt['serial_no'];
            $nestedData[] = $dt['p_name'];
            $nestedData[] = $dt['total_lan'];       
            /*$nestedData[] = $dt['address'];   
            $nestedData[] = $dt['purchase_date'];*/
            $nestedData[] = $dt['registed_mobile'];         
            $nestedData[] = $dt['register_email'];
            $nestedData[] = $whatsapp;                              
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
    public function get_due_report(){
        extract($_REQUEST);
        $sql="SELECT cd.firm_name,cd.contact_person,p.p_name,si_clients_details.p_email,cd.registed_mobile,cd.register_email,si_clients_details.serial_no,si_clients_details.si_for_year_id,si_clients_details.si_clients_details_id,(SELECT purchase_date FROM si_product_purchase WHERE si_clients_details_id=si_clients_details.si_clients_details_id ORDER BY si_product_purchase.created_at DESC LIMIT 1) as purchase_date FROM `si_clients_details` inner join si_clients as cd on cd.si_clients_id=si_clients_details.si_clients_id inner join si_product as p on p.si_product_id=si_clients_details.si_product_id  WHERE si_clients_details.si_clients_details_id Not IN (SELECT si_clients_details_id FROM si_transactions_detail where for_year=2020 GROUP BY si_clients_details_id) and si_clients_details.status='A' and cd.status!='B' and si_clients_details.si_for_year_id in (4)";
        $query = $this->Data_model->Custome_query($sql);    
        $cnt=0;
        $data = array();
        
        
        //echo json_encode($data);
        //die;        
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

            foreach (range('A', 'B','C', 'D','E', 'F','G', 'H') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
            // set the names of header cells
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A1", 'firm name')
                    ->setCellValue("B1", 'Person Name')
                    ->setCellValue("C1", 'Product Name')
                    ->setCellValue("D1", 'Email')
                    ->setCellValue("E1", 'Mobile')
                    ->setCellValue("F1", 'Register Email')
                    ->setCellValue("G1", 'Serial No')
                    ->setCellValue("H1", 'Purchase Date') ;                   
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();

            foreach ($query as $hr) {          
                $spreadsheet->setActiveSheetIndex(0)                        
                        ->setCellValue("A$x", (array_key_exists('firm_name', $hr) == true) ? $hr['firm_name'] : "")
                        ->setCellValue("B$x", (array_key_exists('contact_person', $hr) == true) ? $hr['contact_person'] : "")
                        ->setCellValue("C$x", (array_key_exists('p_name', $hr) == true) ? $hr['p_name'] : "")
                        ->setCellValue("D$x", (array_key_exists('p_email', $hr) == true) ? $hr['p_email'] : "")
                        ->setCellValue("E$x", (array_key_exists('registed_mobile', $hr) == true) ? $hr['registed_mobile'] : "")
                        ->setCellValue("F$x", (array_key_exists('register_email', $hr) == true) ? $hr['register_email'] : "")
                        ->setCellValue("G$x", (array_key_exists('serial_no', $hr) == true) ? $hr['serial_no'] : "")
                        ->setCellValue("H$x", (array_key_exists('purchase_date', $hr) == true) ? $hr['purchase_date'] : "");                        
                $x++;
                $i++;
            }
            //var_dump($spreadsheet);die;
//echo "<pre>";
//            print_r($spreadsheet->setActiveSheetIndex()); die;
// Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Due Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='DueReport'.date('d-m-Y');
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
    public function get_due_report2021(){
        extract($_REQUEST);
        $sql="SELECT cd.firm_name,cd.contact_person,p.p_name,si_clients_details.p_email,cd.registed_mobile,cd.register_email,si_clients_details.serial_no,si_clients_details.si_for_year_id,si_clients_details.si_clients_details_id,(SELECT purchase_date FROM si_product_purchase WHERE si_clients_details_id=si_clients_details.si_clients_details_id ORDER BY si_product_purchase.created_at DESC LIMIT 1) as purchase_date FROM `si_clients_details` inner join si_clients as cd on cd.si_clients_id=si_clients_details.si_clients_id inner join si_product as p on p.si_product_id=si_clients_details.si_product_id  WHERE si_clients_details.si_clients_details_id Not IN (SELECT si_clients_details_id FROM si_transactions_detail where for_year=2021 GROUP BY si_clients_details_id) and si_clients_details.status='A' and cd.status!='B' and si_clients_details.si_for_year_id in (5,6)";
        $query = $this->Data_model->Custome_query($sql);    
        $cnt=0;
        $data = array();
        
        
        //echo json_encode($data);
        //die;        
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

            foreach (range('A', 'B','C', 'D','E', 'F','G', 'H') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
            // set the names of header cells
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A1", 'firm name')
                    ->setCellValue("B1", 'Person Name')
                    ->setCellValue("C1", 'Product Name')
                    ->setCellValue("D1", 'Email')
                    ->setCellValue("E1", 'Mobile')
                    ->setCellValue("F1", 'Register Email')
                    ->setCellValue("G1", 'Serial No')
                    ->setCellValue("H1", 'Purchase Date') ;                   
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();

            foreach ($query as $hr) {          
                $spreadsheet->setActiveSheetIndex(0)                        
                        ->setCellValue("A$x", (array_key_exists('firm_name', $hr) == true) ? $hr['firm_name'] : "")
                        ->setCellValue("B$x", (array_key_exists('contact_person', $hr) == true) ? $hr['contact_person'] : "")
                        ->setCellValue("C$x", (array_key_exists('p_name', $hr) == true) ? $hr['p_name'] : "")
                        ->setCellValue("D$x", (array_key_exists('p_email', $hr) == true) ? $hr['p_email'] : "")
                        ->setCellValue("E$x", (array_key_exists('registed_mobile', $hr) == true) ? $hr['registed_mobile'] : "")
                        ->setCellValue("F$x", (array_key_exists('register_email', $hr) == true) ? $hr['register_email'] : "")
                        ->setCellValue("G$x", (array_key_exists('serial_no', $hr) == true) ? $hr['serial_no'] : "")
                        ->setCellValue("H$x", (array_key_exists('purchase_date', $hr) == true) ? $hr['purchase_date'] : "");                        
                $x++;
                $i++;
            }
            //var_dump($spreadsheet);die;
//echo "<pre>";
//            print_r($spreadsheet->setActiveSheetIndex()); die;
// Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Due Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='DueReport'.date('d-m-Y');
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
    public  function get_excel_data()
    {
        extract($_REQUEST);
        if(isset($p_name) && $p_name !='All')
        {            
            $con_product=" and p.p_name like '".$p_name."'";            
        }
        else
        {
            $con_product='';
        }   
        
        if(isset($yearname) && $yearname !='All')
        {            
            $con_year="where for_year=$yearname";            
        }
        else
        {
            $con_year='';
        }
            
         //$sql = "SELECT cp.si_clients_details_id,p.p_name,cp.*,cd.* FROM si_clients_details as cp inner join si_clients as cd on cd.si_clients_id=cp.si_clients_id inner join si_product as p on p.si_product_id=cp.si_product_id WHERE si_clients_details_id NOT IN (SELECT si_clients_details_id FROM si_transactions_detail GROUP BY si_clients_details_id) and cp.status='A' ".$con_product."and cp.si_for_year_id=1 GROUP BY cp.si_clients_id";
         $sql="SELECT cp.si_clients_details_id,p.p_name,cp.*,cd.* FROM si_clients_details as cp inner join si_clients as cd on cd.si_clients_id=cp.si_clients_id inner join si_product as p on p.si_product_id=cp.si_product_id  WHERE cp.si_clients_details_id NOT IN 
         (SELECT si_clients_details_id FROM si_transactions_detail $con_year GROUP BY si_clients_details_id) and cp.status='A' and cd.status!='B' ".$con_product." /*and cp.si_for_year_id=1 GROUP BY cd.registed_mobile */ ";
     
        $query = $this->Data_model->Custome_query($sql);
        //echo $sql;die;
        $cnt=0;
        $data = array();
        
        
        //echo json_encode($data);
        //die;        
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

            foreach (range('A', 'B') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                        ->setAutoSize(true);
            }
            // set the names of header cells
            /*$spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A1", 'Registed Mobile')
                    ->setCellValue("B1", 'Person Name') ; */                  

            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A1", 'firm name')
                    ->setCellValue("B1", 'Person Name')
                    ->setCellValue("C1", 'Product Name')
                    ->setCellValue("D1", 'Email')
                    ->setCellValue("E1", 'Mobile')
                    ->setCellValue("F1", 'Register Email')
                    ->setCellValue("G1", 'Serial No')
                    ->setCellValue("H1", 'Purchase Date') ;                           
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();

            foreach ($query as $hr) {          
                $spreadsheet->setActiveSheetIndex(0)     
                        ->setCellValue("A$x", (array_key_exists('firm_name', $hr) == true) ? $hr['firm_name'] : "")
                        ->setCellValue("B$x", (array_key_exists('contact_person', $hr) == true) ? $hr['contact_person'] : "")
                        ->setCellValue("C$x", (array_key_exists('p_name', $hr) == true) ? $hr['p_name'] : "")
                        ->setCellValue("D$x", (array_key_exists('register_email', $hr) == true) ? $hr['register_email'] : "")           
                        ->setCellValue("E$x", (array_key_exists('registed_mobile', $hr) == true) ? $hr['registed_mobile'] : "")
                        ->setCellValue("F$x", (array_key_exists('p_email', $hr) == true) ? $hr['p_email'] : "")
                        ->setCellValue("G$x", (array_key_exists('serial_no', $hr) == true) ? $hr['serial_no'] : "")
                        ->setCellValue("H$x", (array_key_exists('created_at', $hr) == true) ? $hr['created_at'] : "");                        
                $x++;
                $i++;
            }
            //var_dump($spreadsheet);die;
//echo "<pre>";
//            print_r($spreadsheet->setActiveSheetIndex()); die;
// Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Due Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='DueReport'.date('d-m-Y');
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
}
