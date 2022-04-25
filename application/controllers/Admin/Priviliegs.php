<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Priviliegs
 *
 * @author abcd
 */
class Priviliegs extends CI_Controller {

    public function __construct() {
        parent::__construct();

        date_default_timezone_set('Asia/Kolkata');
    }

    public function index() {

        $data['user'] = $this->Data_model->Custome_query("select * from si_admin where status='A' and status!='B'");
        $data['menu'] = $this->Data_model->Custome_query("select * from si_menu where status='A' and status!='B'");
        $this->load->view('Admin/Priviliges', $data);
    }

    public function drop_menu() {
        extract($_REQUEST);
        $data['dropmenu'] = $this->Data_model->edit_record("sai_menu", ["parent_id" => $id]);
        $output = array();
        $cnt = count($data['dropmenu']);
        //  print_r($data['dropmenu']);
        if ($cnt > 0) {
            $output[] = "<hr>";
            foreach ($data['dropmenu'] as $menu) {
                $output[] .="<div class='form-group'><input type='checkbox' name='menu[]' value='" . $menu->sai_menu_id . "'> " . $menu->menu_name . "</div>";
            }
            echo json_encode($output);
        } else {
            echo json_encode($output);
        }
    }

    function select_priviliegs() {
        $requestData = $_POST;

        $id = $requestData['columns'][1]['search']['value'];
        $dt = explode(' - ', $id);
//        print_r($date);
//        die;

        $columns = array(
// datatable column index  => database column name
            0 => 'ms.si_menu_assign_id',
            1 => 'ad.username',
            2 => 'me.menu_name',
        );


//        $sql = "SELECT ad.username,GROUP_CONCAT(me.menu_name SEPARATOR ',') as menu_name, ms.si_menu_assign_id, (SELECT GROUP_CONCAT(me.menu_name SEPARATOR ',') as menu_name from si_menu_assign  ms,si_admin  ad, si_menu  me where ms.si_admin_id=ad.si_admin_id and ms.status!='B' and ad.status='A' and ( ad.role='SA' or ad.role='A') and ad.si_admin_id!='" . $_SESSION['id'] . "' and FIND_IN_SET(me.si_menu_id, ms.client_form) group by ad.username LIMIT 1 ) as client_forms,
//(SELECT GROUP_CONCAT(me.menu_name SEPARATOR ',') as menu_name from si_menu_assign  ms,si_admin  ad, si_menu  me where ms.si_admin_id=ad.si_admin_id and ms.status!='B' and ad.status='A' and ( ad.role='SA' or ad.role='A') and ad.si_admin_id!='" . $_SESSION['id'] . "' and FIND_IN_SET(me.si_menu_id, ms.contact_form) group by ad.username LIMIT 1 ) as contact_forms,
//(SELECT GROUP_CONCAT(me.menu_name SEPARATOR ',') as menu_name from si_menu_assign  ms,si_admin  ad, si_menu  me where ms.si_admin_id=ad.si_admin_id and ms.status!='B' and ad.status='A' and ( ad.role='SA' or ad.role='A') and ad.si_admin_id!='" . $_SESSION['id'] . "' and FIND_IN_SET(me.si_menu_id, ms.product_form) group by ad.username LIMIT 1 ) as product_forms
//from si_menu_assign  ms,si_admin  ad, si_menu  me where ms.si_admin_id=ad.si_admin_id and ms.status!='B' and ad.status='A' and ( ad.role='SA' or ad.role='A') and ad.si_admin_id!='" . $_SESSION['id'] . "' and FIND_IN_SET(me.si_menu_id, ms.si_menu_id) group by ad.username";
$sql = "SELECT ad.username, GROUP_CONCAT(me.menu_name SEPARATOR ',') as menu_name,ms.client_form,ms.contact_form,ms.product_form, ms.si_menu_assign_id from si_menu_assign  ms,si_admin  ad, si_menu  me where ms.si_admin_id=ad.si_admin_id and ms.status!='B' and ad.status='A' and ( ad.role='SA'  or ad.role='TL' or ad.role='A') and ad.si_admin_id!='" . $_SESSION['id'] . "'  and FIND_IN_SET(me.si_menu_id, ms.si_menu_id) group by ad.username";
//        $sql = "SELECT ad.username, GROUP_CONCAT(me.menu_name SEPARATOR ',') as menu_name, ms.si_menu_assign_id from si_menu_assign  ms,si_admin  ad, si_menu  me where ms.si_admin_id=ad.si_admin_id and ms.status!='B' and ad.status='A' and ( ad.role='SA' or ad.role='A') and ad.si_admin_id!='".$_SESSION['id']."'  and FIND_IN_SET(me.si_menu_id, ms.si_menu_id) group by ad.username";
//        $sql = "SELECT ma.username,GROUP_CONCAT(mp.menu_name SEPARATOR ', ') as menu_name,mma.sai_menu_assign_id "
//                . "from sai_menu_assign mma,sai_admin ma, sai_menu mp "
//                . "where mma.sai_admin_id=ma.sai_admin_id and mma.is_delete='N' and ma.is_delete='N' and ma.status='A' and ma.role='SA' and FIND_IN_SET(mp.sai_menu_id, mma.sai_menu_assign_id) group by ma.username ";

        $query = $this->Data_model->Custome_query($sql);

        $totalData = count($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'" . str_replace(",", "','", $requestData['search']['value']) . "%'"; //wrapping qoutation
            $sql .= " and ( ms.si_menu_assign_id  LIKE " . $searchString;
            $sql .= " or ad.username  LIKE " . $searchString;
            $sql .= " or me.menu_name  LIKE " . $searchString . ")";
        }

//        echo $sql;die;
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.


        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length
        $query = $this->Data_model->Custome_query($sql);
        // $action=
        $data = array();
        $cnts = $requestData['start'] + 1;
        foreach ($query as $row) {

            if ($row['client_form'] != '') {
                $cfv = $row['client_form'];
            } else {
                $cfv = "'" . "'";
            }

            $sql = "select group_concat(menu_name) as client_forms  from si_menu where si_menu_id in (" . $cfv . ")";
            $cf = $this->Data_model->Custome_query($sql);

            if ($cf[0]["client_forms"] != '') {
                $cfd = "<div class='form-title'><span class='bg-purple'>Client Form</span></div> <div class='form-desc'>" . $cf[0]["client_forms"] . "</div><br>";
            } else {
                $cfd = '';
            }

            if ($row['contact_form'] != '') {
                $confv = $row['contact_form'];
            } else {
                $confv = "'" . "'";
            }

            $sql = "select group_concat(menu_name) as contact_forms  from si_menu where si_menu_id in (" . $confv . ")";
            $cof = $this->Data_model->Custome_query($sql);

            if ($cof[0]["contact_forms"] != '') {
                $cofd = "<div class='form-title'><span class='bg-green'>Contact Form</span></div> <div class='form-desc'>" . $cof[0]["contact_forms"] . "</div><br>";
            } else {
                $cofd = '';
            }

            if ($row['product_form'] != '') {
                $pfv = $row['product_form'];
            } else {
                $pfv = "'" . "'";
            }
            $sql = "select group_concat(menu_name) as product_forms  from si_menu where si_menu_id in (" . $pfv . ")";
            $pf = $this->Data_model->Custome_query($sql);
            if ($pf[0]["product_forms"] != '') {
                $pf = "<div class='form-title'><span class='bg-yellow'>Product Form</span></div> <div class='form-desc'>" . $pf[0]["product_forms"] . "</div>";
            } else {
                $pf = '';
            }
            $action = "<a onclick='edit_menu(" . $row["si_menu_assign_id"] . ")' data-toggle='modal' data-target='#myModal'><i class='btn btn-primary btn-sm fa fa-edit'></i></a>  <a onclick='dlt(" . $row["si_menu_assign_id"] . ")'><i class='btn btn-danger btn-sm fa fa-close'></i></a>";
            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row["username"];
            $nestedData[] = $cfd . $cofd . $pf;
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_menu_assign_id'];
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        echo json_encode($json_data);
    }

    public function insert() {
        extract($_POST);
        $q = "select * from si_menu_assign where si_admin_id='$type' and status!='B'";
        $result = $this->Data_model->Custome_query($q);

        if (count($result) > 0 || $type == 0) {
            $this->session->set_flashdata('message', 'User Already Menu Assign');
            $this->session->set_flashdata('cls', 'alert alert-danger');
        } else {
//            echo "<pre>";
//            print_r($_POST);
////            die;
            $menu_id = '';
            if (count($clinet_menu) > 0) {
                $menu_id .= implode(",", $clinet_menu);
                $client = implode(",", $clinet_menu);
            } else {
                $client = '';
            }
            if (count($contact_menu) > 0) {
                $menu_id .= "," . implode(",", $contact_menu);
                $contact = implode(",", $contact_menu);
            } else {
                $contact = '';
            }

            if (count($product_menu) > 0) {
                $menu_id .= "," . implode(",", $product_menu);
                $product = implode(",", $product_menu);
            } else {
                $product = '';
            }
//            echo $menu_id;
//            die;
            $data = [
                'si_admin_id' => $type,
                'si_menu_id' => $menu_id,
                'client_form' => $client,
                'contact_form' => $contact,
                'product_form' => $product,
                'create_date' => date('Y-m-d H:i:s'),
            ];

            $d = $this->Data_model->Insert_data('si_menu_assign', $data);
            if ($d > 0) {
                $this->session->set_flashdata('message', 'User successfully menu assign');
                $this->session->set_flashdata('cls', 'alert alert-warning');
            } else {
                $this->session->set_flashdata('message', 'Something went wrong');
                $this->session->set_flashdata('cls', 'alert alert-danger');
            }
        }
        redirect(base_url("Admin/Priviliegs"));
    }

    public function edit() {
        extract($_POST);
        $id = array("si_menu_assign_id" => $id);
        $data['menu'] = $this->Data_model->Get_data_one("si_menu_assign", $id);
        if (!empty($data)) {
            echo json_encode($data['menu']);
        } else {
            echo json_encode(array("success" => 0));
        }
    }

    public function update() {
        extract($_REQUEST);
//        echo $edit_id;die;

        if ($e_type == 0) {
            $this->session->set_flashdata('message', 'Select user to assign the menu.');
            $this->session->set_flashdata('cls', 'alert alert-danger');
        } else {
            $id = array("si_menu_assign_id" => $edit_id);

            $menu_id = '';
            if (count($e_clinet_menu) > 0) {
                $menu_id .= implode(",", $e_clinet_menu);
                $client = implode(",", $e_clinet_menu);
            } else {
                $client = '';
            }
            if (count($e_contact_menu) > 0) {
                $menu_id .= "," . implode(",", $e_contact_menu);
                $contact = implode(",", $e_contact_menu);
            } else {
                $contact = '';
            }

            if (count($e_product_menu) > 0) {
                $menu_id .= "," . implode(",", $e_product_menu);
                $product = implode(",", $e_product_menu);
            } else {
                $product = '';
            }
//            echo $menu_id;
//            die;
            $data = [
                'si_admin_id' => $e_type,
                'si_menu_id' => $menu_id,
                'client_form' => $client,
                'contact_form' => $contact,
                'product_form' => $product,
                'modify_date' => date('Y-m-d H:i:s'),
            ];


            $d = $this->Data_model->Update_data("si_menu_assign", $id, $data);
            if ($d > 0) {
                $this->session->set_flashdata('message', 'User successfully menu assign.');
                $this->session->set_flashdata('cls', 'alert alert-warning');
            } else {
                $this->session->set_flashdata('message', 'Something went wrong.');
                $this->session->set_flashdata('cls', 'alert alert-danger');
            }
        }
        redirect(base_url("Admin/Priviliegs"));
    }

}
