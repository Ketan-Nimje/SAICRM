<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends CI_Controller {

    public $tbl = "si_inquiry_detail";
    public $controll = "Inquiry";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Calcutta');
        $this->Data_model->Validation();
    }

    public function index() {
        $data['states'] = $this->Data_model->Custome_query("select si_state_id,name from si_state where status ='A'");
        $data['product'] = $this->Data_model->Custome_query("select si_product_id,p_name from si_product where status='A'");
        $con = "status='A' ";
        $column = "si_admin_id as id,name as name,username as uname";
        $data['admin'] = $this->Data_model->Custom("si_admin", $con, $column);
        $this->load->view('Admin/' . $this->controll, $data);
    }

    public function addData_Inquiry() {
        extract($_REQUEST);

        if (!isset($_REQUEST) || empty($_REQUEST)) {
            redirect(base_url() . 'Admin/' . $this->controll . '');
        }

        if (!isset($iq_mob1)) {
            $iq_mob1 = NULL;
        } else {
            $iq_mob1 = $iq_mob1 . "<br>";
        }
        if (!isset($iq_mob2)) {
            $iq_mob2 = NULL;
        } else {
            $iq_mob2 = $iq_mob2 . "<br>";
        }
        if (!isset($iq_mob3)) {
            $iq_mob3 = NULL;
        } else {
            $iq_mob3 = $iq_mob3 . "<br>";
        }
        if (!isset($iq_mob4)) {
            $iq_mob4 = NULL;
        } else {
            $iq_mob4 = $iq_mob4 . "<br>";
        }
        if (!isset($iq_mob5)) {
            $iq_mob5 = NULL;
        } else {
            $iq_mob5 = $iq_mob5 . "<br>";
        }
        $mmn = $iq_mob1 . $iq_mob2 . $iq_mob3 . $iq_mob4 . $iq_mob5;
        $data = array(
            'si_generated_date' => date('Y-m-d', strtotime($inquiry_date_a)),
            'inquiry_name' => $inquiry_name_a,
            'inquiry_mobile' => $inquiry_mobile_a,
            'inquiry_other_no' => $inquiry_other_no_a,
            'product_id' => $selected_list,
            'inquiry_address' => $inquiry_address_a,
            'inquiry_city' => $inquiry_city_a,
            'inquiry_state' => $inquiry_state_a,
            'inquiry_ref_by' => $inquiry_ref_by_a,
            'inquiry_firm_name' => $inquiry_firmname_a,
            'si_inquiry_email' => $inquiry_email_a,
            'inquiry_gstno' => $inquiry_gstno_a, 'discount_offer' => $discount_offer_a,
            //'si_inquiry_added_by' => $_SESSION['id'],
            'inquiry_completion_status' => "P",
            'remark' => $remark_a,
            'interest_product' => $interest_product_a,
            'multiple_mobile_number' => substr($mmn, 0, -4),
        );
        $clients_id = $this->Data_model->Insert_data_id($this->tbl, $this->security->xss_clean($data));
        $con = array($this->tbl . '_id' => $clients_id);
        $data = array('inquiry_add_by' => $_SESSION['id']);
        $this->Data_model->Update_data($this->tbl, $con, $this->security->xss_clean($data));
        $sessdata = ['error' => '<strong>Success!</strong> Add New Inquiry.', 'errorcls' => 'alert-success'];
        $this->session->set_flashdata('flashmsg', '1 New Inquiry Added Successfully !!! ');

        redirect(base_url() . 'Admin/' . $this->controll . '');
    }

    public function updateData_inquiry() {
        extract($_REQUEST);
        if (!isset($_REQUEST) || empty($_REQUEST)) {
            redirect(base_url() . 'Admin/' . $this->controll . '');
        }

        if (!isset($iq_mob_e1)) {
            $iq_mob1 = NULL;
        } else {
            $iq_mob1 = $iq_mob_e1 . "<br>";
        }
        if (!isset($iq_mob_e2)) {
            $iq_mob2 = NULL;
        } else {
            $iq_mob2 = $iq_mob_e2 . "<br>";
        }
        if (!isset($iq_mob_e3)) {
            $iq_mob3 = NULL;
        } else {
            $iq_mob3 = $iq_mob_e3 . "<br>";
        }
        if (!isset($iq_mob_e4)) {
            $iq_mob4 = NULL;
        } else {
            $iq_mob4 = $iq_mob_e4 . "<br>";
        }
        if (!isset($iq_mob_e5)) {
            $iq_mob5 = NULL;
        } else {
            $iq_mob5 = $iq_mob_e5 . "<br>";
        }
        $mmn = $iq_mob1 . $iq_mob2 . $iq_mob3 . $iq_mob4 . $iq_mob5;

        if ($qpdf_ != '') {
            $fname = $qpdf_;
        } else {
            $fname = '';
        }
        if ($nfd != '') {
            $nfdt = $nfdt;
        } else {
            $nfdt = NULL;
        }

        $data = array(
            'si_generated_date' => date('Y-m-d', strtotime($inquiry_date)),
            'product_id' => $selected_list_e,
            'inquiry_name' => $inquiry_name,
            'inquiry_mobile' => $inquiry_mobile,
            'inquiry_other_no' => $inquiry_other_no,
            'inquiry_address' => $inquiry_address,
            'inquiry_city' => $inquiry_city, 'inquiry_state' => $inquiry_state,
            'inquiry_ref_by' => $inquiry_ref_by,
            'inquiry_firm_name' => $inquiry_firmname, 'si_inquiry_email' => $inquiry_email,
            'inquiry_gstno' => $inquiry_gstno, 'discount_offer' => $discount_offer,
            'inquiry_completion_status' => $inquiry_completion_status, 'remark' => $remark,
            'interest_product' => $interest_product,
            'next_follow_date' => $nfd, 'next_follow_time' => $nfdt, 'low_interest' => $li, 'generated_pdf' => $fname,
            'multiple_mobile_number' => substr($mmn, 0, -4),
                //'updated_at' => date('Y-m-d H:s:i')
        );

        if (isset($hid) && $hid != "") {
            /* $sql = "SELECT generated_pdf  pdf from si_inquiry_detail where si_inquiry_detail_id='$hid' ";
              $oneData = $this->Data_model->Custome_query($sql); $ov=$oneData[0]['pdf'];
              //echo "<pre>"; print_r($vttt); die;
              if(($qpdf_!='' && $ov!='' && $fname!=$ov) || ($qpdf_=='' && $ov!='') ) {
              $path="./assetss/PDF_for_inquiry/";   $pdf_file=$oneData[0]['pdf'];
              $dir=opendir($path); while($file=readdir($dir)) {  if($file==$pdf_file)  { unlink($path.$pdf_file); }}   } */

            $con = array($this->tbl . '_id' => $hid);
            $clients_id = $this->Data_model->Update_data($this->tbl, $con, $data);

            $sessdata = array('error' => '<strong>Success!</strong> Update Inquiry.', 'errorcls' => 'alert-success');
            $this->session->set_flashdata('flashmsg', 'Inquiry Updated Successfully !!! ');
        }
        redirect(base_url() . 'Admin/' . $this->controll . '');
    }

    public function Unlink_file() {
        extract($_REQUEST);
        $path = "./assetss/PDF_for_inquiry/";
        $sql = "SELECT count(si_inquiry_detail_id) as c  from si_inquiry_detail where si_inquiry_detail_id='$id' AND generated_pdf='$pdf' ";
        $cnt = $this->Data_model->Custome_query($sql)[0]['c'];
        if ($cnt == 1 || file_exists($path . $pdf)) {

            $dir = opendir($path);
            while ($file = readdir($dir)) {
                if ($file == $pdf) {
                    unlink($path . $pdf);
                }
            }
            $sql1 = "UPDATE  si_inquiry_detail SET generated_pdf='' WHERE si_inquiry_detail_id='$id' ";
            $this->Data_model->Custome_query_exe($sql1);
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function GetData() {
        $my_id = $_SESSION['id'];
        $requestData = $_REQUEST;

        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'inquiry_name',
            2 => 'inquiry_mobile',
            3 => 'inquiry_ref_by',
            4 => 'inquiry_city',
            5 => 'inquiry_state',
            6 => 'inquiry_mobile',
            7 => 'si_generated_date',
            8 => 'inquiry_completion_status',
            9 => 'si_generated_date',
        );

        if ($this->session->userdata('role') != "SA") {
            $tlcon = "AND ( s.inquiry_add_by='" . $my_id . "'  OR  s.assign_to='" . $my_id . "' )  ";
        } else {
            $tlcon = '';
        }

        if ($requestData['sms'] == "sms") {
            $sms = "sms";
        } else {
            $sms = "nosms";
        }

        if (isset($requestData['datefrom'])) {
            $date_con = " and  STR_TO_DATE(s.created_at, '%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($requestData['datefrom'])) .
                    "' AND '" . date('Y-m-d', strtotime($requestData['dateto'])) . "'";
        } else {
            $date_con = '';
        }

        if ($requestData['select_inq'] == "Pending") {
            $s = " and inquiry_completion_status='P'  ";
        } else if ($requestData['select_inq'] == "Completed") {
            $s = " and inquiry_completion_status='C' ";
        } else if ($requestData['select_inq'] == "L") {
            $s = " and inquiry_completion_status='L' ";
        } else {
            $s = "and inquiry_completion_status!='L'";
        }

        if ($requestData['select_id'] == "all") {
            $admin = '';
        } else {
            $admin_id = $requestData['select_id'];
            $admin = "and  s.inquiry_add_by='$admin_id' ";
        }

        $sql = "SELECT  s.* , s.assign_to  assigned  ,pp.name as added_name,pp.role as role, e.name as inquiry_state_name FROM " . $this->tbl . " as s 
                    INNER JOIN si_state as e on e.si_state_id=s.inquiry_state 
                    INNER JOIN si_admin as pp on s.inquiry_add_by=pp.si_admin_id  
                    WHERE s.status!='B' $s  $admin $date_con $tlcon ";

        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if ($requestData['v'] == 1) {
            $sql .= "AND next_follow_date BETWEEN  '" . date('Y-m-d') . "'  AND  '" . date('Y-m-d', strtotime("+365 day")) . "'
        /*OR DATE_FORMAT(next_follow_date, '%d-%m-%Y') LIKE '" . date('d-m-Y') . "%' */
         ORDER BY  next_follow_date ASC
        
        ";
        } else {


            if (!empty($requestData['search']['value'])) {
                $sql .= " AND ( " . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR inquiry_name LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR inquiry_mobile LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR inquiry_ref_by LIKE '" . $requestData['search']['value'] . "%'";

                $sql .= " OR inquiry_city LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR DATE_FORMAT(next_follow_date, '%d-%m-%Y') LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR inquiry_state LIKE '" . $requestData['search']['value'] . "%' ";
                $sql .= " OR DATE_FORMAT(s.si_generated_date, '%d-%m-%Y') LIKE '" . $requestData['search']['value'] . "%' )";

                //$sql .= " OR created_at LIKE '" . $requestData['search']['value'] . "%' )";            
            }

            /* else {
              $c = count($columns);
              for ($i = 0; $i < $c; $i++) {

              if (!empty($requestData['columns'][$i]['search']['value'])) {
              $sql .= " AND " . $columns[$i] . " LIKE '%" . $requestData['columns'][$i]['search']['value'] . "%'  ";
              }
              }
              } */
            $query = $this->Data_model->Custome_query($sql);

            $totalFiltered = count($query);
            if ($requestData['length'] != '-1')
                $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length        
            else
                $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        }
        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;

        //echo "<pre>";print_r($sql );die;  
        foreach ($query as $dt) {
            $nestedData = array();

            if ($dt['status'] == "A"):
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            endif;
            if ($this->session->userdata('role') == "SA") {
                $delete = "<a class='delete small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' data-isstatus='" . $dt['status'] . "' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";
            } else {
                $delete = '';
            }

            $edit = "<a class='edit small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' title='Edit '><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-edit fa-stack-1x fa-inverse'></i></span></button></a>";
            if ($dt['inquiry_completion_status'] == "P") {
                $whatsapp = "<a class='whatsapp small-btn' data-id='" . $dt['inquiry_mobile'] . "' id='" . $dt['si_inquiry_detail_id'] . "' title='Send WhatsApp' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-whatsapp fa-stack-1x fa-inverse'></i></span></button></a>";
            } else {
                $whatsapp = NULL;
            }
            $assign = "<a class='assign small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' title='Assign To '><button class='btn btn-xs btn-primary '><span class='fa-stack'><i class='fa fa-long-arrow-right fa-stack-1x fa-inverse'></i></span></button></a>";


            if ($sms != 'sms') {
                $nestedData[] = $cnt++;
            } else {
                $nestedData[] = $cnt++ . "&nbsp;&nbsp;&nbsp; <input class='select' type='checkbox' id='chk' data-id='" . $dt['inquiry_mobile'] . "' data-mm='" . $dt['multiple_mobile_number'] . "'  cn='" . $dt['inquiry_name'] . "' value='" . $dt['inquiry_mobile'] . "' 
             name='id[]' > ";
            }

            if ($dt['inquiry_completion_status'] == "C") {
                $nestedData[] = $dt['inquiry_name'] . "<br><b style='color:red'>" . $dt['inquiry_firm_name'] . "</br><i class='fa fa-check pull-right'></i>";
            } else {
                $nestedData[] = $dt['inquiry_name'] . "<br><b style='color:red'>" . $dt['inquiry_firm_name'] . "</br>";
            }

            if (strlen($dt['multiple_mobile_number']) > 2) {
                $nestedData[] = $dt['inquiry_mobile'] . "<br><b style='color:red'>" . $dt['multiple_mobile_number'] . "</b>";
            } else {
                $nestedData[] = $dt['inquiry_mobile'];
            }
            $nestedData[] = $dt['inquiry_ref_by'];
            $nestedData[] = $dt['inquiry_city'];


            //-------------------
            $p = explode(',', $dt['product_id']);
            $f = count($p);
            for ($i = 0; $i < $f; $i++) {
                $q = "SELECT  p_name as pro_name  FROM si_product WHERE si_product_id='" . $p[$i] . "'  ";
                $R = $this->Data_model->CQ0($q)['pro_name'];
                $RR = array("yy" => $R);
            }
            $seePro = "<a class='seePro " . $dt[$this->tbl . '_id'] . "pop small-btn'  id='" . $dt[$this->tbl . '_id'] . "pop' seepro='" . $dt['product_id'] . "' ><button class='btn btn-xs btn-info '>" . $RR['yy'] . "</button></a>";

            if ($f == 1) {
                $f = '';
                $nestedData[] = $RR['yy'];
            } else {
                $nestedData[] = $seePro . "<br> + " . ($f - 1) . " more";
            }

            //$nestedData[] = $dt['product_id']; 
            //------------




            if (($this->session->userdata('role') == "SA") && ($dt['role'] == "SA")) {
                $n = $dt['assigned'];
                if (($n != '') || ($n != NULL)) {
                    $q = "SELECT  a.name as name  FROM si_admin as a WHERE a.status!='B' AND a.si_admin_id='$n' limit 1 ";
                    $R = $this->Data_model->Custome_query($q)[0]['name'];
                    $t = $R;
                } else {
                    $t = '';
                }
                $nestedData[] = $dt['added_name'] . " &nbsp " . $assign . " " . $t;
            } else {
                if ($this->session->userdata('id') == $dt['assign_to']) {
                    $k = "<i class='fa fa-arrow-right' title='This Inquiry is Assigned to You . ' ></i> Assigned to You";
                } else {
                    $k = '';
                } $nestedData[] = $dt['added_name'] . "  " . $k;
            }


            $nestedData[] = $dt['inquiry_completion_status'];

            if (($dt['next_follow_date'] != '') || ($dt['low_interest'] != '') || $dt['generated_pdf'] != '') {

                if ($dt['next_follow_date'] != '') {
                    $tomorrow = date("Y-m-d", strtotime('tomorrow'));
                    $today = date('Y-m-d');

                    if ($today == $dt['next_follow_date']) {
                        $word = 'Today';
                    } else if ($tomorrow == $dt['next_follow_date']) {
                        $word = 'Tomorrow';
                    } else {
                        $word = date('d-m-Y', strtotime($dt['next_follow_date']));
                    }

                    $nfd = "<strong style='color:blue' title='Follow Date : " . date('d-F-Y', strtotime($dt['next_follow_date'])) . " and Time " . $dt['next_follow_time'] . "'>
            
            " . $word . " " . $dt['next_follow_time'] . "</strong> &nbsp;";
                } else {
                    $nfd = '';
                }

                if ($dt['low_interest'] != '') {
                    $li = "<strong style='color:green' title='Low Interest : " . $dt['low_interest'] . " % '>" . $dt['low_interest'] . "% </strong> &nbsp;";
                } else {
                    $li = '';
                }

                if ($dt['generated_pdf'] != '') {
                    $pdf = "<a title='Download PDF' target='_blank' href='" . base_url() . "assetss/PDF_for_inquiry/" . $dt['generated_pdf'] . "'>
             <strong style='color:red'>PDF <i class='fa fa-download'></i> </strong></a>";
                } else {
                    $pdf = '';
                }
                $nestedData[] = $nfd . " " . $li . " " . $pdf;
            } else {
                $nestedData[] = '';
            }


            $nestedData[] = date('d-m-Y', strtotime($dt['si_generated_date']));
            if ($this->session->userdata('role') == "SA") {
                $nestedData[] = $sts . "&nbsp" . $delete . "&nbsp" . $edit . "&nbsp" . $whatsapp;
            } else {
                if (($this->session->userdata('id') == $dt['inquiry_add_by']) || ($this->session->userdata('id') == $dt['assign_to'])) {
                    if ($dt['inquiry_completion_status'] == "C") {
                         $nestedData[] = "Completed &nbsp " . $edit;
                    } else {
                        $nestedData[] = $sts . "&nbsp" . $edit . "&nbsp" . $whatsapp;
                    }
                } else {
                    $nestedData[] = "No Action";
                }
            }
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

    public function UpdatePDF() {
        extract($_REQUEST);
        $path = "./assetss/PDF_for_inquiry/";
        $sql = "SELECT generated_pdf p from si_inquiry_detail where si_inquiry_detail_id='$id' ";
        $cnt = $this->Data_model->Custome_query($sql)[0]['p'];
        if (file_exists($path . $cnt)) {
            $dir = opendir($path);
            while ($file = readdir($dir)) {
                if ($file == $cnt) {
                    unlink($path . $cnt);
                }
            }
            $sql = "UPDATE  si_inquiry_detail SET generated_pdf='$pdf' WHERE si_inquiry_detail_id='$id' ";
            $this->Data_model->Custome_query_exe($sql);
        }
        echo json_encode(1);
    }

    public function pdf_calci($selUser = NULL) {
        extract($_REQUEST);
        $v = date('Y-m-');
        //echo "<pre>";print_r(($_REQUEST));die;


        $get = "SELECT generated_pdf  p FROM si_inquiry_detail  WHERE status!='B' AND generated_pdf LIKE  '" . $v . "%'  ORDER BY generated_pdf DESC LIMIT 1 ";
        $RR = $this->Data_model->Custome_query($get);
        if (count($RR) > 0) {
            $str = explode('-', $RR[0]['p']);
            $str = explode('.', $str[2]);
            $number = $str[0] + 1;
            $len = strlen($number);
            if ($len == 1) {
                $zero = "000";
            } else if ($len == 2) {
                $zero = "00";
            } else if ($len == 3) {
                $zero = "0";
            } else {
                $zero = NULL;
            }
            $str = $zero . $number;
        } else {
            $str = "0001";
        }


//***************** Condition start here 
        if ($txtI1 != "0") {
            $txtN1 = "Genius Installation";
        } else {
            $txtN1 = "0";
        }
        if ($txtI25 != "0") {
            $txtN25 = "Genius Updation";
        } else {
            $txtN25 = "0";
        }
        if ($txtI12 != "0") {
            $txtN12 = "Gen IT (Income Tax) Installation";
        } else {
            $txtN12 = "0";
        }
        if ($txtI36 != "0") {
            $txtN36 = "Gen IT (Income Tax) Updation";
        } else {
            $txtN36 = "0";
        }
        if ($txtI13 != "0") {
            $txtN13 = "Gen CMA/EMI Installation";
        } else {
            $txtN13 = "0";
        }
        if ($txtI37 != "0") {
            $txtN37 = "Gen CMA/EMI Updation";
        } else {
            $txtN37 = "0";
        }
        if ($txtI14 != "0") {
            $txtN14 = "Gen Bal (Balance Sheet) Installation";
        } else {
            $txtN14 = "0";
        }
        if ($txtI38 != "0") {
            $txtN38 = "Gen Bal (Balance Sheet) Updation";
        } else {
            $txtN38 = "0";
        }
        if ($txtI15 != "0") {
            $txtN15 = "Gen Form Manager Installation";
        } else {
            $txtN15 = "0";
        }
        if ($txtI39 != "0") {
            $txtN39 = "Gen Form Manager Updation";
        } else {
            $txtN39 = "0";
        }
        if ($txtI16 != "0") {
            $txtN16 = "Gen e-TDS Installation   ";
        } else {
            $txtN16 = "0";
        }
        if ($txtI40 != "0") {
            $txtN40 = "Gen e-TDS Updation";
        } else {
            $txtN40 = "0";
        }
        if ($txtI61 != "0") {
            $txtN61 = "Gen GST Desktop Installation";
        } else {
            $txtN61 = "0";
        }
        if ($txtI62 != "0") {
            $txtN62 = "Gen GST Desktop Updation";
        } else {
            $txtN62 = "0";
        }
        if ($txtI2 != "0") {
            $txtN2 = "Gen Payroll Installation";
        } else {
            $txtN2 = "0";
        }
        if ($txtI26 != "0") {
            $txtN26 = "Gen Payroll Updation";
        } else {
            $txtN26 = "0";
        }
        if ($txtI3 != "0") {
            $txtN3 = "Payroll Online Installation";
        } else {
            $txtN3 = "0";
        }
        if ($txtI27 != "0") {
            $txtN27 = "Payroll Online Updation (Without Domain Hosting)";
        } else {
            $txtN27 = "0";
        }
        if ($txtI4 != "0") {
            $txtN4 = "Comp Law With XBRL Installation";
        } else {
            $txtN4 = "0";
        }
        if ($txtI28 != "0") {
            $txtN28 = "Comp Law With XBRL Updation  ";
        } else {
            $txtN28 = "0";
        }
        if ($txtI5 != "0") {
            $txtN5 = "Comp Law Without XBRL Installation";
        } else {
            $txtN5 = "0";
        }
        if ($txtI29 != "0") {
            $txtN29 = "Comp Law Without XBRL Updation   ";
        } else {
            $txtN29 = "0";
        }
        if ($txtI10 != "0") {
            $txtN10 = "Comp Law Without XBRL Installation";
        } else {
            $txtN10 = "0";
        }
        if ($txtI34 != "0") {
            $txtN34 = "Comp Law Without XBRL Updation   ";
        } else {
            $txtN34 = "0";
        }
        if ($txtI52 != "0") {
            $txtN52 = "Gen Portal Installation";
        } else {
            $txtN52 = "0";
        }
        if ($txtI53 != "0") {
            $txtN53 = "Gen Portal Updation  ";
        } else {
            $txtN53 = "0";
        }
        if ($txtI57 != "0") {
            $txtN57 = "Gen Portal Android Installation";
        } else {
            $txtN57 = "0";
        }
        if ($txtI58 != "0") {
            $txtN58 = "Gen Portal Android Updation  ";
        } else {
            $txtN58 = "0";
        }
        if ($txtI59 != "0") {
            $txtN59 = "Gen Portal IOS App Installation";
        } else {
            $txtN59 = "0";
        }
        if ($txtI60 != "0") {
            $txtN60 = "Gen Portal IOS App Updation  ";
        } else {
            $txtN60 = "0";
        }
        if ($txtI51 != "0") {
            $txtN51 = "Bulk SMS (" . $txtQ51 * 5000 . " SMS)";
        } else {
            $txtN51 = "0";
        }
        if ($txtI23 != "0") {
            $txtN23 = "LAN Copy";
        } else {
            $txtN23 = "0";
        }

        if ($txtI56 != "0") {
            if ($ddllaptop == "1") {
                $ddllaptop_val = "Genius";
            } else if ($ddllaptop == "6") {
                $ddllaptop_val = "Gen Payroll";
            } else if ($ddllaptop == "2") {
                $ddllaptop_val = "Gen IT (Income Tax)";
            } else if ($ddllaptop == "5") {
                $ddllaptop_val = "Gen CMA/EMI";
            } else if ($ddllaptop == "3") {
                $ddllaptop_val = "Gen Bal (Balance Sheet)";
            } else if ($ddllaptop == "4") {
                $ddllaptop_val = "Gen Form Manager";
            } else if ($ddllaptop == "28") {
                $ddllaptop_val = "Gen XDExcise";
            } else if ($ddllaptop == "9") {
                $ddllaptop_val = "Gen Service Tax";
            } else if ($ddllaptop == "22") {
                $ddllaptop_val = "Gen A-VAT";
            } else if ($ddllaptop == "11") {
                $ddllaptop_val = "Gen RVAT";
            } else if ($ddllaptop == "36") {
                $ddllaptop_val = "Gen Auditor";
            } else if ($ddllaptop == "45") {
                $ddllaptop_val = "Project Finance";
            } else if ($ddllaptop == "13") {
                $ddllaptop_val = "Gen Smart Shoppee";
            } else if ($ddllaptop == "23") {
                $ddllaptop_val = "Gen Smart Bill";
            }

            $txtN56 = "Laptop Copy (" . $ddllaptop_val . ")";
        } else {
            $txtN56 = "0";
        }
//***************** Condition end here 
        $mx1 = $txtI1 . "," . $txtQ1 . "," . $lblL1 . "," . $txtN1;
        $mx25 = $txtI25 . "," . $txtQ25 . "," . $lblL25 . "," . $txtN25;
        $mx12 = $txtI12 . "," . $txtQ12 . "," . $lblL12 . "," . $txtN12;
        $mx36 = $txtI36 . "," . $txtQ36 . "," . $lblL36 . "," . $txtN36;
        $mx13 = $txtI13 . "," . $txtQ13 . "," . $lblL13 . "," . $txtN13;
        $mx37 = $txtI37 . "," . $txtQ37 . "," . $lblL37 . "," . $txtN37;
        $mx14 = $txtI14 . "," . $txtQ14 . "," . $lblL14 . "," . $txtN14;
        $mx38 = $txtI38 . "," . $txtQ38 . "," . $lblL38 . "," . $txtN38;
        $mx15 = $txtI15 . "," . $txtQ15 . "," . $lblL15 . "," . $txtN15;
        $mx39 = $txtI39 . "," . $txtQ39 . "," . $lblL39 . "," . $txtN39;
        $mx16 = $txtI16 . "," . $txtQ16 . "," . $lblL16 . "," . $txtN16;
        $mx40 = $txtI40 . "," . $txtQ40 . "," . $lblL40 . "," . $txtN40;
        $mx61 = $txtI61 . "," . $txtQ61 . "," . $lblL61 . "," . $txtN61;
        $mx62 = $txtI62 . "," . $txtQ62 . "," . $lblL62 . "," . $txtN62;
        $mx2 = $txtI2 . "," . $txtQ2 . "," . $lblL2 . "," . $txtN2;
        $mx26 = $txtI26 . "," . $txtQ26 . "," . $lblL26 . "," . $txtN26;
        $mx3 = $txtI3 . "," . $txtQ3 . "," . $lblL3 . "," . $txtN3;
        $mx27 = $txtI27 . "," . $txtQ27 . "," . $lblL27 . "," . $txtN27;
        $mx4 = $txtI4 . "," . $txtQ4 . "," . $lblL4 . "," . $txtN4;
        $mx28 = $txtI28 . "," . $txtQ28 . "," . $lblL28 . "," . $txtN28;
        $mx5 = $txtI5 . "," . $txtQ5 . "," . $lblL5 . "," . $txtN5;
        $mx29 = $txtI29 . "," . $txtQ29 . "," . $lblL29 . "," . $txtN29;
        $mx10 = $txtI10 . "," . $txtQ10 . "," . $lblL10 . "," . $txtN10;
        $mx34 = $txtI34 . "," . $txtQ34 . "," . $lblL34 . "," . $txtN34;
        $mx52 = $txtI52 . "," . $txtQ52 . "," . $lblL52 . "," . $txtN52;
        $mx53 = $txtI53 . "," . $txtQ53 . "," . $lblL53 . "," . $txtN53;
        $mx57 = $txtI57 . "," . $txtQ57 . "," . $lblL57 . "," . $txtN57;
        $mx58 = $txtI58 . "," . $txtQ58 . "," . $lblL58 . "," . $txtN58;
        $mx59 = $txtI59 . "," . $txtQ59 . "," . $lblL59 . "," . $txtN59;
        $mx60 = $txtI60 . "," . $txtQ60 . "," . $lblL60 . "," . $txtN60;
        $mx51 = $txtI51 . "," . $txtQ51 . "," . $lblL51 . "," . $txtN51;
        $mx23 = $txtI23 . "," . $txtQ23 . "," . $lblL23 . "," . $txtN23;
        $mx56 = $txtI56 . "," . $txtQ56 . "," . $lblL56 . "," . $txtN56;
        $all4 = array($mx1, $mx25, $mx12, $mx36, $mx13, $mx37, $mx14, $mx38, $mx15, $mx39, $mx16, $mx40, $mx61, $mx62, $mx2, $mx26, $mx3, $mx27, $mx4, $mx28, $mx5, $mx29, $mx10, $mx34, $mx52, $mx53, $mx57, $mx58, $mx59, $mx60, $mx51, $mx23, $mx56);


        $F_name = $n1;
        $F_address = $n2;
        $F_mob = $n3;
        $GST_No = $n4;
        $Firmname = $n5;

        /* $str = '';   $letnum = array_merge(range('A','Z'));  $max = count($letnum) - 1;
          for ($i = 0; $i < 2; $i++) {  $c10 = mt_rand(0, $max); $str .= $letnum[$c10];   } */

        $css = 'style="background: #3a6fa5;"';
        $css1 = 'style="background: #95b0d6;"';
        $css2 = 'style="background: #4ace72;"';
        $iddd = $v . $str;

        $html = '<table ><tr><td width="75%"><img align="left" src="' . base_url() . 'assetss/images/saii_ok.jpg"><img align="left" src="' . base_url() . 'assetss/images/sag.jpg"></td></td><td width="55%" align="right"><font size="2">106, AJANTA SHOPPING CENTER, RING ROAD <br/>Surat, Gujarat, 395002, India <br/>Phone : <b>0261-2369109</b><br/><b style="color:blue">sales@saiinfotech.co</b><br/>GSTN NUMBER .: <b>24AHYPA0655N1ZZ </b><br/>PAN: <b>AHYPA0655N</b> </font></td></tr></table>';

        $html .= '<table width="100%"><tr><td align="left"><font size="4"><b style="color:blue">www.saiinfotech.co </b></font></td>
    <td align="right"><font size="3"> </font></td></tr></table>';

        $html .= '<table width="100%"><tr><td width="72%"><font size="3">Firm Name : <b>' . $Firmname . '</b><br/>Bill To : ' . $F_name . '</font></td>
    <td width="28%" align="right"><font size="3"> QUOTATION : <b>' . $iddd . '</b><br/>Date : ' . date('d-F-Y') . ' </font></td></tr></table>';

        $html .= '<table width="100%"><tr><td width="72%"><font size="3"> Address : <b>' . $F_address . '</b></font></td></tr></table><br/>';
        ///***************
        $TotalAmount = $lblTtlTtl;
        $GST_Tax = $lblST;
        $AmountPayable = $lblAmtPayble; //$topc=$txtCleintTotalPay; $NetAmount=$txtCleintTotalAmountPayble;
        //***********

        $rtv = $this->Data_model->convertToIndianCurrency($AmountPayable);
        $html .= '<table width="100%"><tr><font size="3"><th align="left">GSTN : ' . $GST_No . '</th><th align="right"> Mobile : ' . $F_mob . '</th></font></tr></table>';

        $html .= '<table width="100%">'
                . '<tr ' . $css . '>'
                . '<th width="10%" >No.</th><th width="48%">Product/Service Name</th><th width="9%">Qty</th>
<th width="15%">Price </th><th width="18%"> Amount</th></tr></table>';

        /// For loop will start here
        $serialno = 1;
        foreach ($all4 as $one) {
            if ($one != "0,0,0,0") {

                $vv = explode(',', $one);
                $html .= '<table width="100%">
        <tr width="10%"><td>' . $serialno++ . '</td><td width="48%">' . $vv[3] . '</td><td width="9%" align="center">' . $vv[1] . '</td>
        <td width="15%">' . $vv[0] . '</td><td width="18%"> ' . $vv[2] . ' Rs.</td></tr>
        </table>';
            }
        }

        $html .= '<br><br><br><br><br>';

        /// For loop will end here // Product Listing

        /* $html .= '<br/><table width="100%">
          <tr width="10%"><td></td><td width="90%"> Notes : '.$Notes.'</td></tr>
          </table>'; // Notes */

        $html .= '<table width="100%">'
                . '<tr><th width="40%"  ' . $css2 . '></th><th width="38%" ' . $css1 . '>Total Amount</th><th width="22%" ' . $css1 . '>' . number_format($TotalAmount, 2) . ' Rs.</th></tr>'
                . '<tr><th width="40%" ' . $css2 . '></th><th width="38%" ' . $css1 . '>GST Tax @18%</th><th width="22%" ' . $css1 . '>' . number_format($GST_Tax, 2) . ' Rs.</th></tr>'
//.'<tr><th width="40%" '.$css2.'></th><th width="38%" '.$css1.'>Amount Payable</th><th width="22%" '.$css1.'>'.number_format($AmountPayable,2).' Rs.</th></tr>'
//.'<tr><th width="40%" '.$css2.'></th><th width="38%" '.$css1.'>Total Online Payment Charges</th><th width="22%" '.$css1.'>'.number_format($topc,2).' Rs.</th></tr>'
                . '</table>';
        $html .= '<table width="100%">'
//.'<tr ><th width="58%" '.$css2.'>in Words : '.$rtv.'</th><th width="20%" '.$css1.'>Net Amount</th><th width="22%" '.$css1.'>'.number_format($NetAmount,2).' Rs.</th></tr>'
                . '<tr><th width="40%" ' . $css2 . '></th><th width="38%" ' . $css1 . '>Total Amount Payable</th><th width="22%" ' . $css1 . '>' . number_format($AmountPayable, 2) . ' Rs.</th></tr>'
                . '</table>';

        $css3 = " style='background-color:#e2c7e2;' align='left' ";

        $html .= '<br/><table width="54%">'
                . '<tr ><th width="20%" style="background-color:#e0bae0" colspan="2"> BANK DETAILS   </th></tr>'
                . '<tr ><th width="20%" ' . $css3 . '> Account Name  </th><th width="34%" ' . $css3 . '>SAI INFOTECH</th></tr>'
                . '<tr><th width="20%" ' . $css3 . '>Bank Name</th><th width="34%" ' . $css3 . '>    INDUSIND Bank Ltd</th></tr>'
                . '<tr ><th width="20%" ' . $css3 . '> Branch    </th><th width="34%" ' . $css3 . '> Empire Estate Branch, Surat</th></tr>'
                . '<tr><th width="20%" ' . $css3 . '>Account Number</th><th width="34%" ' . $css3 . '>       200999038453</th></tr>'
                . '<tr ><th width="20%" ' . $css3 . '> IFSC Code </th><th width="34%" ' . $css3 . '> INDB0000023 </th></tr>'
                . '<tr><th width="20%" ' . $css3 . '> Account Type   </th><th width="34%" ' . $css3 . '> Current Account</th></tr>'
                . '</table>';

        $html .= '<br/><table width="100%">
        <tr ><td width="95%"> Notes : ' . $Notes . '</td></tr>
        </table>'; // Notes

        $html .= '<br/><table width="100%"><tr><td width="75%" align="left"><font size="2"><b> Terms</b><br/> 1. Software once installed not taken back. Online Charges will be Applied separately .<br/> 2. Support regarding our software will be provided during office hours. (10:30 to 7.00pm) in working days. <br/>  3. We are not responsible for any errors caused by VIRUS,Improper Hardware/LAN setting or any other cause.<br/>  4. Subject to SURAT Jurisdiction.<br/><b align="center"> This is Computer Generated invoice No need to Sign</b> </font></td><td width="25%" align="right"><b>FOR SAI INFOTECH <br/><br/><br/>Authorised Signatory</b><br/></td></tr></table>';


        $v = $v . $str;
        $pdfFilePath = "$v.pdf";

        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output(FCPATH . "assetss/PDF_for_inquiry/" . $pdfFilePath, "F");
        //$this->m_pdf->pdf->Output($pdfFilePath, "D"); 
        //$this->session->set_flashdata('file_path_for_pdf',$pdfFilePath); 

        echo json_encode($pdfFilePath);
    }

///**********************
    public function assigned() {
        extract($_REQUEST);
        $sql = "SELECT i.assign_to AS assigned FROM si_inquiry_detail i WHERE i.si_inquiry_detail_id='$id'  ";
        $R = $this->Data_model->Custome_query($sql)[0];
        echo json_encode($R);
    }

    public function assign_to() {
        extract($_REQUEST);
        //echo "<pre>";print_r($_REQUEST);die;
        $sql = "UPDATE si_inquiry_detail SET assign_to='$assign_id' WHERE  si_inquiry_detail_id='$hid_id'  ";
        $this->Data_model->Custome_query_exe($sql);
        echo json_encode(1);
    }

    public function listAdmin() {
        extract($_REQUEST);
        $sql = "SELECT a.si_admin_id id,a.name name FROM si_admin a WHERE a.status='A' AND a.role!='SA'  ";
        $R = $this->Data_model->Custome_query($sql);
        echo json_encode($R);
    }

    function Get_Cust() {
        extract($_REQUEST);

        $columns = array(
            0 => 'si_clients_id',
            1 => 'firm_name',
            2 => 'registed_mobile',
            3 => 'register_email',
        );
        //print_r($columns[2]);die;

        $sql = "select si_clients_id,firm_name,registed_mobile,register_email from si_clients where 1=1 ";

        if (!empty($valok)) {
            $sql .= " AND firm_name like '%" . $valok . "%'  ";
            $sql .= " OR registed_mobile like '%" . $valok . "%'  ";
            $sql .= " OR register_email like '%" . $valok . "%'  LIMIT 20 ";
        }
        $query = $this->Data_model->Custome_query($sql);

        echo json_encode($query);
    }

    function search_customer_and_select() {
        if (!isset($_POST['searchTerm'])) {
            $sql = "select si_clients_id as id, CONCAT(firm_name,' | ' , contact_person)
         as text from si_clients where status!='B' order by rand() limit 40";
        } else {
            $sql = "select si_clients_id as id, CONCAT(firm_name, ' | ' , contact_person)
         as text from si_clients where status!='B' ";
            $search = $_POST['searchTerm'];

            $sql .= " AND ( firm_name like '%" . $search . "%'  ";
            $sql .= " OR contact_person like '%" . $search . "%'  ";
            $sql .= " OR registed_mobile like '%" . $search . "%'  ";
            $sql .= " OR register_email like '%" . $search . "%' ) LIMIT 40 ";
        }
        $query = $this->Data_model->query($sql);
        echo json_encode($query);
    }

    function fill_existing_data() {
        extract($_REQUEST);
        if (!isset($id)) {
            echo "<script>window.close();</script>";
            die;
        }

        $sql = "Select  si_clients_id id, city c, contact_person n, firm_name f ,
        register_email e, gstin_no g, registed_mobile m,address a, mobile1 m1
        from si_clients 
        WHERE status!='B' AND si_clients_id='$id' limit 1 ";

        $R = $this->Data_model->CQ0($sql);
        echo json_encode($R);
    }

    public function seeProOnPopOver() {
        extract($_REQUEST);
        if (!isset($id)) {
            echo "<script>window.close();</script>";
            die;
        }
        $pro = explode(',', $id);
        for ($i = 0; $i < count($pro); $i++) {
            $q = "SELECT  p_name as pro_name  FROM si_product WHERE si_product_id='" . $pro[$i] . "'  limit 1 ";
            $R[] = $this->Data_model->CQ0($q)['pro_name'];
        }
        echo json_encode($R);
    }

    function name_auto_complete($keywords = NULL) {
        extract($_REQUEST);
        $sql = "select contact_person as name from si_clients where contact_person like '$keywords%'  limit 1";
        $query = $this->Data_model->Custome_query($sql);
        echo json_encode($query);
    }

    function productlist() {
        $sql = "Select si_product_id  id , p_name  text  from si_product WHERE status='A'  ";
        $query = $this->Data_model->Custome_query($sql);
        echo json_encode($query);
    }
    public function get_inquiry_report(){
        extract($_REQUEST);
        $requestData = $_REQUEST;
        //var_dump($_REQUEST);
        //die();
        //$sql="SELECT cd.firm_name,cd.contact_person,p.p_name,si_clients_details.p_email,cd.registed_mobile,cd.register_email,si_clients_details.serial_no,si_clients_details.si_for_year_id,si_clients_details.si_clients_details_id,(SELECT purchase_date FROM si_product_purchase WHERE si_clients_details_id=si_clients_details.si_clients_details_id ORDER BY si_product_purchase.created_at DESC LIMIT 1) as purchase_date FROM `si_clients_details` inner join si_clients as cd on cd.si_clients_id=si_clients_details.si_clients_id inner join si_product as p on p.si_product_id=si_clients_details.si_product_id  WHERE si_clients_details.si_clients_details_id Not IN (SELECT si_clients_details_id FROM si_transactions_detail where for_year=2020 GROUP BY si_clients_details_id) and si_clients_details.status='A' and cd.status!='B' and si_clients_details.si_for_year_id in (4)";
        //$query = $this->Data_model->Custome_query($sql);    
        if (isset($requestData['datefrom'])) {
            $date_con = " and  STR_TO_DATE(s.created_at, '%Y-%m-%d') BETWEEN '" . date('Y-m-d', strtotime($requestData['datefrom'])) .
                    "' AND '" . date('Y-m-d', strtotime($requestData['dateto'])) . "'";
        } else {
            $date_con = '';
        }

        if ($requestData['select_inq'] == "Pending") {
            $s = " and inquiry_completion_status='P'  ";
        } else if ($requestData['select_inq'] == "Completed") {
            $s = " and inquiry_completion_status='C' ";
        } else if ($requestData['select_inq'] == "L") {
            $s = " and inquiry_completion_status='L' ";
        } else {
            $s = "and inquiry_completion_status!='L'";
        }

        

        $sql = "SELECT  pro.p_name,s.* , s.assign_to  assigned  ,pp.name as added_name,pp.role as role, e.name as inquiry_state_name FROM " . $this->tbl . " as s 
                    INNER JOIN si_state as e on e.si_state_id=s.inquiry_state 
                    INNER JOIN si_admin as pp on s.inquiry_add_by=pp.si_admin_id  
                    INNER JOIN si_product as pro on pro.si_product_id=s.product_id 
                    WHERE s.status!='B' $s $date_con ";

        $query = $this->Data_model->Custome_query($sql);

       // echo "<pre>";
       // print_r($query);
       // die();
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
                    ->setCellValue("A1", 'Person name')
                    ->setCellValue("B1", 'firm Name')
                    ->setCellValue("C1", 'Product Name')
                    ->setCellValue("D1", 'Email')
                    ->setCellValue("E1", 'Mobile')
                    ->setCellValue("F1", 'Address')
                    ->setCellValue("G1", 'Ref By')
                    ->setCellValue("H1", 'Remark') ;                   
            $x = 2;
            $i = 1;
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();

            foreach ($query as $hr) {          
                $spreadsheet->setActiveSheetIndex(0)                        
                        ->setCellValue("A$x", (array_key_exists('inquiry_name', $hr) == true) ? $hr['inquiry_name'] : "")
                        ->setCellValue("B$x", (array_key_exists('inquiry_firm_name', $hr) == true) ? $hr['inquiry_firm_name'] : "")
                        ->setCellValue("C$x", (array_key_exists('p_name', $hr) == true) ? $hr['p_name'] : "")
                        ->setCellValue("D$x", (array_key_exists('si_inquiry_email', $hr) == true) ? $hr['si_inquiry_email'] : "")
                        ->setCellValue("E$x", (array_key_exists('inquiry_mobile', $hr) == true) ? $hr['inquiry_mobile'] : "")
                        ->setCellValue("F$x", (array_key_exists('inquiry_address', $hr) == true) ? $hr['inquiry_address'] : "")
                        ->setCellValue("G$x", (array_key_exists('inquiry_ref_by', $hr) == true) ? $hr['inquiry_ref_by'] : "")
                        ->setCellValue("H$x", (array_key_exists('remark', $hr) == true) ? $hr['remark'] : "");                        
                $x++;
                $i++;
            }
            //var_dump($spreadsheet);die;
//echo "<pre>";
//            print_r($spreadsheet->setActiveSheetIndex()); die;
// Rename worksheet
            $spreadsheet->getActiveSheet()->setTitle('Inquiry Report');

// set right to left direction
//      $spreadsheet->getActiveSheet()->setRightToLeft(true);
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $spreadsheet->setActiveSheetIndex(0);
            $anme='InquiryReport'.date('d-m-Y');
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
      redirect(base_url('Inquiry'));
    }   
}
