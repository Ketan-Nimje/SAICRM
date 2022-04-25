<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sadmin
 *
 * @author abcd
 */
class Sadmin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index() {
        $this->load->view('Admin/Sadmin');
    }

    public function insert() {
        extract($_REQUEST);
        $q = "select * from si_admin where username='" . $username . "' and status!='B' and status='A'";
        $result = $this->Data_model->Custome_query($q);

//         print_r($result);die;
        if (count($result) > 0) {
            echo json_decode(0);
            // redirect(base_url("Sadmin?value=null")); 
        } else {
            $data = [
                "name" => $name,
                "username" => $username,
                "phone" => $phone,
                "password" => $pwd,
                "role" => $type,
                "status" => $status,
                "create_date" => date('Y-m-d H:i:s'),
            ];
            $d = $this->Data_model->Insert_data("si_admin", $data);
            if ($d > 0) {
                echo json_decode(1);
            } else {
                echo json_decode(0);
            }
        }
    }

    function select_sadmin() {
        $requestData = $_POST;

        $id = $requestData['columns'][1]['search']['value'];
        $dt = explode(' - ', $id);
//        print_r($date);
//        die;

        $columns = array(
// datatable column index  => database column name
            0 => 'si_admin_id',
            1 => 'name',
            2 => 'username',
            3 => 'phone',
            4 => 'role',
            5 => 'create_date',
            6 => 'si_admin_id',
        );



        $sql = 'select * from si_admin where status!="B" ';
        $Custome_query = $this->Data_model->Custome_query($sql);

        $totalData = count($Custome_query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'" . str_replace(",", "','", $requestData['search']['value']) . "%'"; //wrapping qoutation
            $sql .= " and ( si_admin_id  LIKE " . $searchString;
            $sql .= " or name  LIKE " . $searchString;
            $sql .= " or username  LIKE " . $searchString;
            $sql .= " or phone  LIKE " . $searchString;
            $sql .= " or role  LIKE " . $searchString;
            $sql .= " or create_date  LIKE " . $searchString . ")";
        }
        $Custome_query = $this->Data_model->Custome_query($sql);

        $totalFiltered = count($Custome_query); // when there is a search parameter then we have to modify total number filtered rows as per search result.


        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length
        $Custome_query = $this->Data_model->Custome_query($sql);
        // $action=
        $data = array();
        $cnts = $requestData['start'] + 1;
        foreach ($Custome_query as $row) {
            if ($row['role'] == 'SA') {
                $role = 'Admin';
            } else {
                $role = 'Staff';
            }

            if ($role != 'Admin') {
                if ($row['status'] == 'A') {
                    $stts = 'D';
                    $action = "<a onclick='sts(" . $row["si_admin_id"] . ",\"" . $stts . "\")'><i class='btn btn-success fa fa-flag' aria-hidden='true'></i></a>  <a onclick='edit_sadmin(" . $row["si_admin_id"] . ")' data-toggle='modal' data-target='#myModal'><i class='btn btn-primary btn-sm fa fa-edit'></i></a>  <a onclick='dlt(" . $row["si_admin_id"] . ")'><i class='btn btn-danger btn-sm fa fa-close'></i></a>";
                } else {
                    $stts = 'A';
                    $action = "<a onclick='sts(" . $row["si_admin_id"] . ",\"" . $stts . "\")'><i class='btn btn-warning fa fa-flag' aria-hidden='true'></i></a>  <a onclick='edit_sadmin(" . $row["si_admin_id"] . ")' data-toggle='modal' data-target='#myModal'><i class='btn btn-primary btn-sm fa fa-edit'></i></a>  <a onclick='dlt(" . $row["si_admin_id"] . ")'><i class='btn btn-danger btn-sm fa fa-close'></i></a>";
                }
            } 
            else {
                $action = '';
//                $action = "<a onclick='edit_sadmin(" . $row["si_admin_id"] . ")' data-toggle='modal' data-target='#myModal'><i class='btn btn-primary btn-sm fa fa-edit'></i></a>";
            }
            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row["name"];
            $nestedData[] = $row["username"];
            $nestedData[] = $row["phone"];
            $nestedData[] = $role;
            $nestedData[] = date("Y-m-d", strtotime($row["create_date"]));
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_admin_id'];
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

    public function edit() {
        extract($_POST);
        $id = array("si_admin_id" => $id);
        $data['admin'] = $this->Data_model->Get_data_one("si_admin", $id);

        if (!empty($data)) {
            echo json_encode($data['admin']);
        } else {
            echo json_encode(array("success" => 0));
        }
    }

    public function update() {
        extract($_POST);

        $data = [
            "name" => $e_name,
            "username" => $e_username,
            "phone" => $e_phone,
            "password" => $e_pwd,
            "role" => $e_type,
            "update_date" => date('Y-m-d H:i:s'),
        ];
        $id = array("si_admin_id" => $edit_id);

        $d = $this->Data_model->Update_data("si_admin", $id, $data);
        if ($d > 0) {
            echo json_decode(1);
        } else {
            echo json_decode(0);
        }
    }

}
