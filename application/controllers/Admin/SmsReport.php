<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SmsReport extends CI_Controller {

    public $controll = "Admin/SmsReport";

    public function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/kolkata");
        $this->Data_model->Validation();
    }

    public function index() {
        $this->load->view($this->controll);
    }

    public function getCustomerSolution() {
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $solve='';
        $columns = array(
            0 => 'cs.si_customer_solution_id',
            1 => 'p.p_name',
            2 => 'cs.s_type',
            3 => 'cs.remark',
            4 => 'cs.created_date',
            5 => 'cs.cs_proccess',
        );

        if ($this->session->userdata('role') == 'SA') {
            $join = " and csh.s_type in ('SendAdmin','SendTL','Itself') ";
        } else if ($this->session->userdata('role') == 'TL') {
            $join = " and csh.s_type in ('SendTL') ";
        } else {
            $join = '';
        }
        $sql = "select cs.si_customer_solution_id,cs.si_admin_id,ad.name,ad.role,p.p_name,csh.s_type,csh.remark,cs.created_date,cs.status,csh.cs_proccess,
                                (SELECT COUNT(cs_proccess) FROM si_customer_solution_history where cs_proccess='H' and cs.status!='B'  " . $join . " GROUP BY cs.si_admin_id) high,
                                (SELECT COUNT(cs_proccess) FROM si_customer_solution_history WHERE cs_proccess='D' and cs.status!='B'  " . $join . " GROUP BY cs.si_admin_id) done
                                from si_customer_solution cs
                                inner join si_customer_solution_history csh on csh.si_customer_solution_id = cs.si_customer_solution_id
                inner join si_product as p on p.si_product_id=cs.si_product_id
                inner join si_clients as sic on sic.si_clients_id=cs.si_clients_id
                inner join si_admin ad  on ad.si_admin_id=cs.si_admin_id
                where cs.status!='B' " . $join;


        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( cd.cs.si_customer_solution_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cs.s_type LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cs.remark LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " cs.created_date LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cs.status LIKE '" . $requestData['search']['value'] . "%' ) ";
        }
        $sql .=" GROUP BY cs.si_admin_id";
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;

        foreach ($query as $dt) {
            $nestedData = array();
//            if ($dt['cs_proccess'] == "D"):
//                $sts = "<a href='javascript:void(0);' class='btn btn-xs btn-success'>Done</a>";
//            else:
//                $sts = "<a href='javascript:void(0);' class='btn btn-xs btn-warning'>High Priority</a>";
//            endif;
//            $dn = "<a href='javascript:void(0);' class='btn btn-xs btn-success'>" . $dt['done'] . "</a>";
//////            else:
//            $hg = "<a href='javascript:void(0);' class='btn btn-xs btn-warning'>" . $dt['high'] . "</a>";

            $view = "<a href='javascript:void(0);' class='btn btn-info views' data-id='" . $dt['si_admin_id'] . "'><i class='fa fa-eye'></i></a>";
            if ($dt['role'] == 'A') {
                $solve = 'Staff';
            }
//            if ($dt['s_type'] == 'Itself') {
//                $solve = 'It Self';
//            } else if ($dt['s_type'] == 'SendAdmin') {
//                $solve = 'Sent To Admin';
//            } else {
//                $solve = 'Sent To Team Leader';
//            }
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['name'];
            $nestedData[] = $solve;
//            $nestedData[] = $dt['remark'];
            $nestedData[] = date("Y-m-d", strtotime($dt['created_date']));
            $nestedData[] = $view;
//            $nestedData[] = $view . '&nbsp' . $dn . "&nbsp" . $hg;
            $nestedData["DT_RowId"] = "Rows_id" . $dt['si_admin_id'];
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

    public function StaffInquiry() {
        extract($_REQUEST);
        // $MM for Min and Max function in query
        $adminWhere = '';
        if ($this->session->userdata('role') == 'SA') {
            $join = " and csh.s_type in ('SendAdmin','SendTL','Itself') ";
            $MM = "max";
            $adminWhere = "where c.s_type='SendAdmin'";
        } else if ($this->session->userdata('role') == 'TL') {
            $join = " and csh.s_type in ('SendTL') ";
            $MM = "min";
        } else {
            $join = '';
            $MM = '';
        }
//        echo $this->session->userdata('role');
//        $sql = "select * from (
            $sql = "select * from ( select csh.s_type, csh.si_customer_solution_id,csh.si_customer_solution_history_id,sic.firm_name,sic.registed_mobile,sic.register_email,cs.si_admin_id,ad.name,
(SELECT serial_no FROM si_clients_details WHERE si_product_id=cs.si_product_id and si_clients_id=cs.si_clients_id limit 1) as serialno,
(SELECT activation_code FROM si_clients_details WHERE si_product_id=cs.si_product_id and si_clients_id=cs.si_clients_id limit 1) as activation, ad.role,p.p_name,csh.remark,cs.created_date,cs.status,csh.cs_proccess from si_customer_solution cs
                                inner join si_customer_solution_history csh on csh.si_customer_solution_id = cs.si_customer_solution_id
                                inner join si_product as p on p.si_product_id=cs.si_product_id
                                inner join si_clients as sic on sic.si_clients_id=cs.si_clients_id
                                inner join si_admin  as ad  on ad.si_admin_id=cs.si_admin_id
                                where cs.status!='B' and cs.si_admin_id='" . $id . "' " . $join . " and csh.si_customer_solution_history_id in(select " . $MM . "(cshi.si_customer_solution_history_id) 
                                from si_customer_solution_history as cshi GROUP by cshi.si_customer_solution_id )  
                                order by csh.si_customer_solution_history_id DESC ) as c";  

    $query = $this->Data_model->Custome_query($sql);


        if (count($query) > 0) {
            $tbl = "<tr id='dynOrderRow' data-id='" . $id . "'><td colspan='5'><table id='editable' class='table table-bordered'><tr><th>#</th><th>Firm Name</th><th>Mobile</th><th>Email</th><th>Serial No</th><th>Activation Code</th><th>Product Name</th><th>Action</th></tr>";
            $i = 1;
            foreach ($query as $dt) {
                $class = '';
                if ($dt['s_type'] == 'Itself') {
                    $class = '';
                } else if ($dt['s_type'] == 'SendTL') {
//                    if ($this->session->userdata('role') == 'TL') {
                    $class = 'high';
//                    }
                } else {
//                    if ($this->session->userdata('role') == 'SA') {
                    $class = 'high';
//                    }
                }
//                if ($this->session->userdata('role') == 'SA') {
//                    $join = " and csh.s_type in ('SendAdmin','SendTL','Itself') ";
//                } else if ($this->session->userdata('role') == 'TL') {
//                    $join = " and csh.s_type in ('SendTL') ";
//                } else {
//                    $join = '';
//                }

                if ($dt['cs_proccess'] == "D"):
                    if ($dt['s_type'] == 'SendAdmin') {
                        $sts = "<a class='small-btn' title='Done'><button class='btn btn-xs btn-success'>Done By Admin</button></a>";
                    } else if ($dt['s_type'] == 'SendTL') {
                        $sts = "<a class='small-btn' title='Done'><button class='btn btn-xs btn-success'>Done By Team Leader</button></a>";
                    } else {
                        $sts = "<a class='small-btn' title='Done'><button class='btn btn-xs btn-success'>Done By Staff</button></a>";
                    }

                else:
                    if ($dt['s_type'] == 'SendTL') {
                        $sts = "<a class='" . $class . " small-btn' data-status='TL' title='High Priority' data-id='" . $dt['si_customer_solution_id'] . "' data-status='" . $dt['cs_proccess'] . "' ><button class='btn btn-xs btn-warning'>Team Leader</button></a>";
                    } else {
                        $sts = "<a class='" . $class . " small-btn' data-status='AD' title='High Priority' data-id='" . $dt['si_customer_solution_id'] . "' data-status='" . $dt['cs_proccess'] . "' ><button class='btn btn-xs btn-primary'>Admin</button></a>";
                    }
                endif;

//                if ($dt['regtype'] == "O") {
//                    $rgT = "Online";
//                } else {
//                    $rgT = "H Lock";
//                }
//
//                if ($dt['lan_type'] == 0) {
//                    $lt = "Decl Without Srv";
//                } else if ($dt['lan_type'] == 1) {
//                    $lt = "Decl With Srv" . " / " . $dt['lantotal'];
//                } else {
//                    $lt = "Lan" . " / " . $dt['lantotal'];
//                }
                $tbl .= "<tr data-id='" . $i . "' class='dynrow'>"
                        . "<td>" . $i . "</td>"
                        . "<td>" . $dt['firm_name'] . "</td>"
                        . "<td>" . $dt['registed_mobile'] . "</td>"
                        . "<td>" . $dt['register_email'] . "</td>"
                        . "<td>" . $dt['serialno'] . "</td>"
                        . "<td>" . $dt['activation'] . "</td>"
                        . "<td>" . $dt['p_name'] . "</td>"
//                        . "<td>" . $dt['remark'] . "</td>"
                        . "<td>" . $sts . "</td>"
                        . "</tr>";
                $i++;
            }
            $tbl .="</table></td></tr>";
            echo $tbl;
            die;
        } else {
            echo $tbl = '';
        }
    }

    public function getCustomerSolutionEdit() {
        extract($_POST);
//        $con = array($tbl . '_id' => $id);
//        $data['cs'] = $this->Data_model->Get_data_one($tbl, $con);
        $data['cs'] = $this->Data_model->Custome_query("select p_name,cs.* from si_product sp inner join si_customer_solution cs on sp.si_product_id=cs.si_product_id where cs.si_customer_solution_id=" . $id);
        $sql = "SELECT csh.is_complete FROM si_customer_solution cs LEFT JOIN si_customer_solution_history csh ON cs.si_customer_solution_id=csh.si_customer_solution_id WHERE csh.si_customer_solution_id='" . $id . "' and cs.status!='B' order by csh.si_customer_solution_history_id desc";
        $data['csh'] = $this->Data_model->Custome_query($sql);
        echo json_encode($data);
    }

    public function UpdateSmsSeen() {
        extract($_REQUEST);


        $data = [
            'is_seen' => 'S',
        ];
        $con = [
            'si_admin_id' => $id,
            'is_seen' => 'U',
        ];
        $dt = $this->Data_model->Update_data('si_customer_solution', $con, $data);
        echo 1;
    }

    public function addCustomerSolution() {
        extract($_REQUEST);
//          echo "<pre>";
//        print_r($_REQUEST);
        if ($s_type != '') {
            if ($s_type == 'SendTL') {
                $cp = "D";
                $cm = "Y";
            } else {
                $cp = "H";
                $cm = "N";
            }
        } else {
            $cp = "D";
            $cm = "Y";
            $s_type = "SendAdmin";
        }


        $data = [
            'si_customer_solution_id' => $csId,
            'si_admin_id' => $_SESSION['id'],
            's_type' => $s_type,
            'remark' => $remark,
            'cs_proccess' => $cp,
            'created_date' => date('Y-m-d H:i:s'),
        ];
//        echo "<pre>";
//        print_r($data);
//        die;
        $this->Data_model->Insert_data('si_customer_solution_history', $data);

        $datas = [
            'is_complete' => $cm,
        ];
        $con = [
            'si_customer_solution_id' => $csId,
        ];
        $this->Data_model->Update_data('si_customer_solution_history', $con, $datas);
        redirect(base_url('Admin/SmsReport'));
    }

    public function CustomerSolutionHistory() {
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
            0 => 'csh.si_customer_solution_id',
            2 => 'csh.s_type',
            3 => 'csh.remark',
            4 => 'csh.created_date',
            5 => 'csh.cs_proccess',
        );

        $sql = "SELECT cs.si_customer_solution_id,csh.* FROM si_customer_solution cs LEFT JOIN si_customer_solution_history csh ON cs.si_customer_solution_id=csh.si_customer_solution_id WHERE csh.si_customer_solution_id='" . $id . "' and cs.status!='B'";


        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( cs.si_customer_solution_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR csh.s_type LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR csh.remark LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " csh.created_date LIKE '" . $requestData['search']['value'] . "%') ";
        }

        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
        foreach ($query as $dt) {
            $nestedData = array();
            if ($dt['cs_proccess'] == "D"):
                $sts = "<a href='javascript:void(0);' class='btn btn-xs btn-success'>Done</a>";
            else:
                $sts = "<a href='javascript:void(0);' class='btn btn-xs btn-warning'>High Priority</a>";
            endif;

            if ($dt['s_type'] == 'Itself') {
                $solve = 'By Staff';
            } else if ($dt['s_type'] == 'SendAdmin') {
                $solve = 'By Admin';
            } else {
                $solve = 'By Team Leader';
            }
            $nestedData[] = $cnt++;
            $nestedData[] = $solve;
            $nestedData[] = $dt['remark'];
            $nestedData[] = date("Y-m-d H:i", strtotime($dt['created_date']));
            $nestedData[] = $sts;
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
