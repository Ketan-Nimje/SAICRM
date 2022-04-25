<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ClientReport extends CI_Controller {

    public $tbl = "si_clients";
    public $controll = "Admin/ClientReport";

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
        $this->load->view($this->controll);
    }

    public function GetData() {
        $requestData = $_REQUEST;
        if($requestData['select_inq']=="A") { $status=" sc.status='A' and "; }
        else if($requestData['select_inq']=="D") { $status=" sc.status='D' and "; }
        else { $status=" sc.status!='B' and "; }
		

        $columns = array(
            0 => 'sc.si_clients_id',
            1 => 'sc.contact_person',
            2 => 'sc.firm_name',
            3 => 'sc.registed_mobile',
            4 => 'sc.register_email',
          );

        $sql = "SELECT 
				sc.si_clients_id,
				sc.contact_person,
				sc.firm_name,
				sc.registed_mobile,
				sc.register_email
				
				FROM si_clients sc 
				INNER JOIN si_clients_details scd ON sc.si_clients_id=scd.si_clients_id 
				INNER JOIN si_product_purchase spp ON scd.si_clients_details_id=spp.si_clients_details_id 
				where  $status scd.status !='B'";

        $query = $this->Data_model->Custome_query($sql);
		
		//echo "<pre>";  print_r($query); die;
		
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . "sc." . $this->tbl . "_id LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.contact_person LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.firm_name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.registed_mobile LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.register_email LIKE '%" . $requestData['search']['value'] . "%' )";
        } else {
            $c = count($columns);
            for ($i = 0; $i < $c; $i++) {

                if (!empty($requestData['columns'][$i]['search']['value'])) {
                    $sql .= " AND " . $columns[$i] . " LIKE '%" . $requestData['columns'][$i]['search']['value'] . "%'  ";
                }
            }
        }

        $sql .= " group by scd.si_clients_id";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;


        foreach ($query as $dt) {
            $nestedData = array();

            $nestedData[] = $cnt++;
			
			 $nestedData[] = $dt['contact_person'];
			 $nestedData[] = $dt['firm_name'];
			 $nestedData[] = $dt['registed_mobile']; 
			 $nestedData[] = $dt['register_email'];
			 
   
         	/*$sr = $this->Data_model->Custome_query('select GROUP_CONCAT(fy.yearname  SEPARATOR " , ") as foryear from si_clients_details as cd inner join si_for_year as fy on fy.si_for_year_id=cd.si_for_year_id where cd.si_clients_id = ' . $dt[$this->tbl . '_id']);

            $nestedData[] = $sr[0]['foryear'] != "" ? $sr[0]['foryear'] : "-";

            $sr = $this->Data_model->Custome_query('select GROUP_CONCAT(spp.purchase_date  SEPARATOR " , ") as p_date from si_clients_details as cd inner join si_product_purchase as spp on spp.si_clients_details_id=cd.si_clients_details_id where cd.si_clients_id = ' . $dt[$this->tbl . '_id']);

            $nestedData[] = $sr[0]['p_date'] != '' ? $sr[0]['p_date'] : "-";
                 
            $sr = $this->Data_model->Custome_query('select GROUP_CONCAT(spp.renewal_date  SEPARATOR " , ") as r_date from si_clients_details as cd inner join si_product_purchase as spp on spp.si_clients_details_id=cd.si_clients_details_id where cd.si_clients_id = ' . $dt[$this->tbl . '_id']);

            $nestedData[] = $sr[0]['r_date'] != "" ? $sr[0]['r_date'] : "-";
                 
           
            $nestedData["DT_RowId"] = "Rows_id" . $dt[$this->tbl . '_id'];  */
			
			//$nestedData[] = '';
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


    public function client_report_product_index() {
        $data['product'] = $this->Data_model->Custome_query("SELECT si_product_id,p_name FROM si_product WHERE status LIKE 'A'");
        $this->load->view("Admin/ClientReportProduct", $data);
    }

    public function GetData_report() {
        $requestData = $_REQUEST;
        //echo "<pre>";  print_r($requestData['select_inq']); die;
    
        $status=" scd.si_product_id='".$requestData['select_inq']."' AND ";

        $columns = array(
            0 => 'sc.si_clients_id',
            1 => 'sc.contact_person',
            2 => 'sc.firm_name',
            3 => 'sc.registed_mobile',
            4 => 'sc.register_email',
        );

        $sql = "SELECT sc.si_clients_id, sc.contact_person, sc.firm_name, sc.registed_mobile, sc.register_email
                FROM si_clients sc 
                INNER JOIN si_clients_details scd ON sc.si_clients_id=scd.si_clients_id 
                INNER JOIN si_product_purchase spp ON scd.si_clients_details_id=spp.si_clients_details_id 
                where  $status scd.status !='B'";

        $query = $this->Data_model->Custome_query($sql);
        
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . "sc." . $this->tbl . "_id LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.contact_person LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.firm_name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.registed_mobile LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.register_email LIKE '%" . $requestData['search']['value'] . "%' )";
        } else {
            $c = count($columns);
            for ($i = 0; $i < $c; $i++) {

                if (!empty($requestData['columns'][$i]['search']['value'])) {
                    $sql .= " AND " . $columns[$i] . " LIKE '%" . $requestData['columns'][$i]['search']['value'] . "%'  ";
                }
            }
        }

        $sql .= " group by scd.si_clients_id";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;


        foreach ($query as $dt) {
            $nestedData = array();
            
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['contact_person'];
            $nestedData[] = $dt['firm_name'];
            $nestedData[] = $dt['registed_mobile']; 
            $nestedData[] = $dt['register_email'];   
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


	public function Excel() { extract($_REQUEST);
		if(!isset($date)) {echo "<script>window.close();</script>"; die;}  
	
		$date=explode('|',$date);
		
		//echo "<pre>";print_r($date); die;
	
		if($select_inq=="A") 
				{ 
				$status=" sc.status='A'  "; 
				}
        else if($select_inq=="D") 
				{ 
				$status=" sc.status='D'  "; 
				}
        else 
				{ 
				$status=" sc.status!='B'  "; 
				}
		
		if($select_inq1=="R") 
				{ 
				$daterange="AND  ( STR_TO_DATE(spp.renewal_date, '%Y-%m-%d') BETWEEN  '".date('Y-m-d',strtotime($date[0]))."'  AND  '".date('Y-m-d',strtotime($date[1]))."'  ) "; 
				}
        else if($select_inq1=="P") 
				{ 
				$daterange="AND  ( STR_TO_DATE(spp.purchase_date, '%Y-%m-%d') BETWEEN  '".date('Y-m-d',strtotime($date[0]))."'  AND  '".date('Y-m-d',strtotime($date[1]))."' )  "; 
				}
        else 
				{ 
				$daterange="AND  ( 
									STR_TO_DATE(spp.purchase_date, '%Y-%m-%d') BETWEEN  '".date('Y-m-d',strtotime($date[0]))."'  AND  '".date('Y-m-d',strtotime($date[1]))."'  
									OR  
									 STR_TO_DATE(spp.renewal_date, '%Y-%m-%d') BETWEEN  '".date('Y-m-d',strtotime($date[0]))."'  AND  '".date('Y-m-d',strtotime($date[1]))."'
											)"; 
				}
		
		
		$sql="SELECT 
				sc.si_clients_id,
				sc.contact_person,
				sc.firm_name,
				sc.registed_mobile,
				sc.register_email,
				spp.renewal_date,
				spp.purchase_date
				FROM si_clients sc 
				INNER JOIN si_clients_details scd ON sc.si_clients_id=scd.si_clients_id 
				INNER JOIN si_product_purchase spp ON scd.si_clients_details_id=spp.si_clients_details_id 
				where  $status  /*scd.status !='B'  */  $daterange ";
		 
		$query=$this->Data_model->Custome_query($sql);
		
		//-------
        if (count($query)>0) {
            require_once APPPATH . '/third_party/Phpexcel/Bootstrap.php';
            // Create new Spreadsheet object
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

// Set document properties
            $spreadsheet->getProperties()->setCreator('http://saiinfotech.co')
                    ->setLastModifiedBy('Hashrail Devloper')
                    ->setTitle('H')
                    ->setSubject('Excel Report Detail')
                    ->setDescription('Owner : Ashish Agarwal');

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
            $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);

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
                    ->setCellValue("B1", 'Client Name')
                    ->setCellValue("C1", 'Firm Name')
                    ->setCellValue("D1", 'Mobile')
                    ->setCellValue("E1", 'Email')
                    ->setCellValue("F1", 'Purchase_Date')
					->setCellValue("G1", 'Renewal_Date');
					
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            
            foreach ($query as $q) {
			//echo"<pre>";	print_r($hr['admin']); 
		
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", $i)
                        ->setCellValue("B$x",$q['contact_person'])
                        ->setCellValue("C$x", $q['firm_name'])
                        ->setCellValue("D$x",$q['registed_mobile'])
                        ->setCellValue("E$x",$q['register_email'])
						->setCellValue("F$x",$q['purchase_date'])
						->setCellValue("G$x",$q['renewal_date']);
                $x++;
                $i++;
            }
            $spreadsheet->getActiveSheet()->setTitle('Excel Client Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='Excel_Report'.date('d-m-Y');
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

        }
		 redirect(base_url('Admin/ClientReport')); 
		
	}
    
	
	
	




















































}?>