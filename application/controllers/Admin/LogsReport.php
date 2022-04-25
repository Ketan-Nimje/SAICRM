<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LogsReport extends CI_Controller {

    public $tbl = "si_clients_handle_logs";
    public $controll = "LogsReport";
    

    public function __construct() {
        parent::__construct();
        $this->Data_model->Validation();
    }

     public function index() {
        $data['for_year'] = $this->Data_model->Custome_query("select * from si_for_year where status like 'A'");
        $this->load->view('Admin/'.$this->controll,$data);
    }
	
    public function GetData() { $my_id=$_SESSION['id']; 
        $requestData = $_REQUEST;
	
        $columns = array(
            0 => 'id',
            1 => 'on_by_admin',
            2 => 'client_id',
            3 => 'turn_on_time',
            4 => 'turn_off_time',
            5 => 'status',          
            6 => 'clicked_while',
          
        );
       $sql = "SELECT  s.* , c.contact_person client ,e.name  admin  FROM ".$this->tbl." as s 
					INNER JOIN si_admin as e on e.si_admin_id=s.on_by_admin 
					INNER JOIN si_clients as c on s.client_id=c.si_clients_id  WHERE s.status='A' ";
	
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND (  c.contact_person LIKE '" . $requestData['search']['value'] . "%' ";
			$sql .= " OR e.name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR DATE_FORMAT(s.turn_on_time, '%d-%m-%Y')  LIKE '". $requestData['search']['value'] . "%' "; 
            $sql .= " OR DATE_FORMAT(s.turn_off_time, '%d-%m-%Y')  LIKE '". $requestData['search']['value'] . "%' )";         
        } /*else {
            $c = count($columns);
            for ($i = 0; $i < $c; $i++) {

                if (!empty($requestData['columns'][$i]['search']['value'])) {
                    $sql .= " AND " . $columns[$i] . " LIKE '%" . $requestData['columns'][$i]['search']['value'] . "%'  ";
                }
            }
        }*/
        $query = $this->Data_model->Custome_query($sql);
	
        $totalFiltered = count($query);
        if ($requestData['length'] != '-1')
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length        
        else
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;

        foreach ($query as $dt) {
            $nestedData = array();

            $delete = "<a class='delete small-btn' data-id='" . $dt['id'] . "'  data-isstatus='" . $dt['status'] . "' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";
			$eye = "<a class='eye small-btn' data-id='" . $dt['id'] . "'  data-isstatus='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-eye fa-stack-1x fa-inverse'></i></span></button></a>";
			
			if($dt['turn_off_time']!='' || $dt['turn_off_time']!=NULL) { 
		
			$seconds = strtotime($dt['turn_off_time']) - strtotime($dt['turn_on_time']) ;
			
			$days  = floor($seconds / 86400);
			$hr   = floor(($seconds - ($days * 86400)) / 3600);
			$min = floor(($seconds - ($days * 86400) - ($hr * 3600))/60);
			$sec = floor(($seconds - ($days * 86400) - ($hr * 3600) - ($min*60)));
			
 			//$hr = sprintf("%02d", $hr);$min = sprintf("%02d", $min);$sec = sprintf("%02d", $sec);
			
			if($days==0){$day='';}else {$day=" + ".$days." days";}
			if($hr==0){$hr='';}else {$hr=$hr." hrs ";}
			
			$diff= $hr.$min." mins ".$sec." secs".$day;
			}
			
			else { $diff="Not"; }
			
			
			
			$nestedData[] = $cnt++;
			$nestedData[] = $dt['admin'];            
            $nestedData[] = $dt['client'];
            $nestedData[] = "<strong style='color:Red'>".date('d-M',strtotime($dt['turn_on_time']))."</strong> on <strong style='color:Green'> ".date('h : i : s A',strtotime($dt['turn_on_time']))."</strong>";
			if($dt['turn_off_time']!='' || $dt['turn_off_time']!=NULL) {
			$nestedData[] ="<strong style='color:Red'>".date('d-M',strtotime($dt['turn_off_time']))."</strong> on <strong style='color:Green'> ".date('h : i : s A',strtotime($dt['turn_off_time']))."</strong>"; }else{  $nestedData[] =''; }
			$nestedData[] = $diff;
            $nestedData[] =  $delete." &nbsp;".$eye;
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
	
	
	
	public function DeleteLogs() { extract($_REQUEST);
		if(!isset($id)) {echo "<script>window.close();</script>"; die;} 
		
		$sql="DELETE  FROM ".$this->tbl." WHERE id='$id' ";
		$this->Data_model->Custome_query_exe($sql);
		echo json_encode(1);
	}
	
	
 public function GetData_Noti() { $my_id=$_SESSION['id']; 
        $requestData = $_REQUEST;
        
        if($this->session->userdata('role')=="SA") { $con=NULL;}
        else { $con=" AND c.on_by_admin=".$this->session->userdata('id')." "; }
        
    
        $columns = array(
            0 => 'c.id',
            1 => 'e.name',
            2 => 'P.firm_name',
           3 => 'c.turn_on_time',
           
            
        );

        $sql=" SELECT  c.id,P.Client_Assigned admin_id , P.firm_name client, P.Logs_id log_id,
                   e.name as admin,c.turn_on_time time_on  FROM si_clients_handle_logs  c
                   INNER JOIN si_admin as e ON e.si_admin_id=c.on_by_admin 
                   INNER JOIN si_clients as P ON P.Client_Assigned=c.on_by_admin AND P.si_clients_id=c.client_id
                   WHERE LENGTH(P.Client_Assigned)>0 AND c.turn_off_time IS NULL /* AND DATE_FORMAT(c.turn_on_time,'%d-%m-%Y') LIKE 
                   '".date('d-m-Y')."%' */  $con GROUP BY client_id ";
                   
        $query = $this->Data_model->Custome_query($sql);
        //echo "<pre>"; print_r($query);die;
        
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( P.firm_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR e.name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR DATE_FORMAT(c.turn_on_time, '%d-%m-%Y')  LIKE '". $requestData['search']['value'] . "%' )";          
        } 
        $query = $this->Data_model->Custome_query($sql);
    
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length        
        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;

        foreach ($query as $dt) {
            $nestedData = array();
            
            if(1==1){
        $se = "<a class='se small-btn pull-right'  title='Search This' data-id='".$dt['client']."'><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-search fa-stack-1x fa-inverse'></i></span></button></a>";}
        else {$se='';}
        
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['admin'];            
            $nestedData[] = $dt['client']." ".$se;

            if(date('Y-m-d',strtotime($dt['time_on']))==date('Y-m-d')) {

            $nestedData[] = "Today on<strong style='color:Green'> ".date('h : i : s A',strtotime($dt['time_on']))."</strong>";
            } else {


            $nestedData[] =date('d-M h : i : s A',strtotime($dt['time_on'])); 
            }
            
            
            $seconds = strtotime(date('Y-m-d H:i:s')) - strtotime($dt['time_on']) ;
            
            
            $days  = floor($seconds / 86400);
            $hr   = floor(($seconds - ($days * 86400)) / 3600);
            $min = floor(($seconds - ($days * 86400) - ($hr * 3600))/60);
            $sec = floor(($seconds - ($days * 86400) - ($hr * 3600) - ($min*60)));
            if(strlen($hr)==1){ $hr="0".$hr;}
            if(strlen($min)==1){ $min="0".$min;}
            if(strlen($sec)==1){ $sec="0".$hr;}
            
            
            
            //$nestedData[] = $hr.":".$min.":".$sec;
            //$nestedData[] = "01:52:45";
            $nestedData[] = $seconds;
            $nestedData[] = $dt['log_id'];
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
    
    
	public function Count_Calls_Live() {
		if($this->session->userdata('role')=="SA") { $con=NULL;}
		else { $con=" AND c.on_by_admin=".$this->session->userdata('id')." "; }
		
		
		
		$sql=" SELECT  count(P.Logs_id) as CL  FROM    si_clients_handle_logs c
				   INNER JOIN si_admin as e ON e.si_admin_id=c.on_by_admin 
				   INNER JOIN si_clients as P ON P.Client_Assigned=c.on_by_admin AND P.si_clients_id=c.client_id
				   WHERE LENGTH(P.Client_Assigned)>0 AND c.turn_off_time IS NULL /*AND DATE_FORMAT(c.turn_on_time,'%d-%m-%Y') LIKE '".date('d-m-Y')."%' */
				    $con ";		   
			
		
		$sq=" SELECT  count(P.Logs_id) as CT  FROM    si_clients_handle_logs c
				   INNER JOIN si_admin as e ON e.si_admin_id=c.on_by_admin 
				   INNER JOIN si_clients as P ON P.Client_Assigned=c.on_by_admin AND P.si_clients_id=c.client_id
				   WHERE LENGTH(P.Client_Assigned)>0 AND c.turn_off_time IS NULL 
                   /*AND DATE_FORMAT(c.turn_on_time,'%d-%m-%Y') LIKE '".date('d-m-Y')."%' */  AND  TIMESTAMPDIFF(SECOND,c.turn_on_time, NOW())>1200 $con ";
					
			/*$sqlp=" DELETE t1 FROM si_clients_handle_logs t1, si_clients_handle_logs t2 WHERE t1.id < t2.id AND t1.on_by_admin = t2.on_by_admin 
			AND t1.client_id = t2.client_id AND t1.turn_off_time IS NULL ";	
				$this->Data_model->Custome_query_exe($sqlp); */
				   
   		$q = $this->Data_model->CQ0($sql);
		$q1 = $this->Data_model->CQ0($sq);
		//echo "<pre>"; print_r($sq);die;
	
		$Q=array_merge($q,$q1);
		echo json_encode($Q);
		}

	public function Export_Excel_Logs_Calls($datefrom,$dateto) { extract($_REQUEST);
		if(!isset($datefrom)) {echo "<script>window.close();</script>"; die;} 
		
		$sql="SELECT  a.name admin, contact_person client,l.turn_on_time  time_on,l.turn_off_time  time_off  FROM ".$this->tbl." as l  
		INNER JOIN  si_admin as a ON a.si_admin_id=l.on_by_admin
		INNER JOIN  si_clients as c ON c.si_clients_id=l.client_id
		WHERE    STR_TO_DATE(l.turn_on_time, '%Y-%m-%d') BETWEEN 
		'".date('Y-m-d',strtotime($datefrom))."'  AND  '".date('Y-m-d',strtotime($dateto))."'  AND l.turn_off_time IS NOT NULL";
		 
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
                    ->setSubject('Calls Report Detail')
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
            $spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);

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
                    ->setCellValue("B1", 'Admin By')
                    ->setCellValue("C1", 'Client Name')
                    ->setCellValue("D1", 'Time On')
                    ->setCellValue("E1", 'Time Off')
                    ->setCellValue("F1", 'Total Time');
					
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            
            foreach ($query as $q) {
			//echo"<pre>";	print_r($hr['admin']); 
				
				
			$seconds = strtotime($q['time_off']) - strtotime($q['time_on']) ;
			$days  = floor($seconds / 86400);
			$hr   = floor(($seconds - ($days * 86400)) / 3600);
			$min = floor(($seconds - ($days * 86400) - ($hr * 3600))/60);
			$sec = floor(($seconds - ($days * 86400) - ($hr * 3600) - ($min*60)));
			
			if($days==0){$day='';}else {$day=" + ".$days." days";}
			if($hr==0){$hr='';}else {$hr=$hr." hrs ";}
			
			$diff= $hr.$min." mins ".$sec." secs".$day;
				  
                $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue("A$x", $i)
                        ->setCellValue("B$x",$q['admin'])
                        ->setCellValue("C$x", $q['client'])
                        ->setCellValue("D$x",$q['time_on'])
                        ->setCellValue("E$x",$q['time_off'])
						->setCellValue("F$x", $diff);
                $x++;
                $i++;
            }
            $spreadsheet->getActiveSheet()->setTitle('Calls Client Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='Client_Calls_Report'.date('d-m-Y H-i-s');
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
        
		 redirect(base_url('Admin/LogsReport')); 
		
	}
    
	
	
	
















}
