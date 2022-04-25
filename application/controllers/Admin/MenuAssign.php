<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MenuAssign extends CI_Controller {

    public $path = "";
    public $op = "<option value='0'>-----Select Account-----</option>";
    public $ops = "";
    public $opes = "";

    public function __construct() {
        parent::__construct();
        $this->Data_model->Validation();
    }

//    public function Validation() {
//        if ($this->session->userdata('logsession') == ""):
//            redirect(base_url());
//        endif;
//    }

    public function index() {
//        $data['user'] = $this->Data_model->Custome_query("select * from admin_login where admin_email='" . $_SESSION['admin_email'] . "'");
        $sql = "SELECT mc.si_main_menu_id,mc.si_main_menu_id as ct,mc.main_menu,mc.status,mc.parent_id,mc.id_path FROM si_main_menu mc left join si_main_menu mc1 on mc1.parent_id=mc.si_main_menu_id where mc.status='A' and mc.status!='B'  GROUP BY mc.si_main_menu_id";
        $fcat = $this->Data_model->Custome_query($sql);
        $ss = $this->buildTree($fcat);
        $this->printTree($ss);
//        $data = $this->Data_model->Custome_query("SELECT mc.account_master_id,mc.account_master_id as ct,mc.account_type,mc.is_status,mc.parent_id,mc.id_path,mc.level FROM account_master mc left join account_master mc1 on mc1.parent_id=mc.account_master_id where mc.is_delete='N' and mc.user_uniq_id in ('') GROUP BY mc.account_master_id");
//        $menu = $this->get_menu($data, 0);

        $data['account'] = array(
            'data' => $this->op,
            'datas' => $this->ops,
            'e_datas' => $this->opes,
            'ecat' => array()
        );
        $data['user'] = $this->Data_model->Custome_query("select * from si_admin where role='TL' and status='A' and status!='B'");
        $data['menu'] = $this->Data_model->Custome_query("select * from si_main_menu  where parent_id ='0'");
//        echo "<pre>"; print_r($data); die;
//        $data['filter_account'] = $this->Data_model->Custome_query("select * from account_master where parent_id = '0' and is_delete='N'");
        $this->load->view('Admin/MenuAssign', $data);
//        $this->load->view('Admin/MenuAssign');
    }

    public function buildTree($data, $parent = 0) {
        $tree = array();

        foreach ($data as $d) {
            if ($d['parent_id'] == $parent) {
                $children = $this->buildTree($data, $d['si_main_menu_id']);
                if (!empty($children)) {
                    $d['_children'] = $children;
                }
                $tree[] = $d;
            }
        }
        return $tree;
    }

    function printTree($tree, $r = 0, $p = null) {
        foreach ($tree as $i => $t) {
            $dash = ($t['parent_id'] == 0) ? ' ' : '' . str_repeat('|--', $r) . ' ';
//            $this->op.="\t<option value='" . $t['account_master_id'] . "," . $t['id_path'] . "'>" . $dash . $t['account_type'] . "</option>\n";

            $this->op.="\t<option value='" . $t['si_main_menu_id'] . "," . $t['id_path'] . "'>" . $dash . $t['main_menu'] . "</option>\n";
            if ($t['parent_id'] == 0) {
                $this->ops.="\t<input type='checkbox' class='main' id='main" . $t['si_main_menu_id'] . "' value='" . $t['si_main_menu_id'] . "' name='menu[]'><label class='text-default' for='main" . $t['si_main_menu_id'] . "'>" . $t['main_menu'] . "</label><br>";
                $this->opes.="\t<input type='checkbox' class='main e_chk" . $t['si_main_menu_id'] . "' id='e_main" . $t['si_main_menu_id'] . "' onclick='e_toggle(" . $t['si_main_menu_id'] . ")' value='" . $t['si_main_menu_id'] . "' name='menu[]'><label class='text-default' for='e_main" . $t['si_main_menu_id'] . "'>" . $t['main_menu'] . "</label><br>";
            } else {
                $this->ops.="\t<input type='checkbox' class='sub_main' id='sub_main" . $t['si_main_menu_id'] . "' value='" . $t['si_main_menu_id'] . "' name='menu[]'><label class='text-default' for='main" . $t['si_main_menu_id'] . "'>" . $dash . $t['main_menu'] . "</label><br>";
                $this->opes.="\t<div class='subdiv_menu subhid" . $t['parent_id'] . "' id='dropmenu_edit" . $t['parent_id'] . "'><div class='form-group'><input type='checkbox' class='sub_main e_chk" . $t['si_main_menu_id'] . "' id='e_sub_main" . $t['si_main_menu_id'] . "' value='" . $t['si_main_menu_id'] . "' name='menu[]'><label class='text-default' for='e_sub_main" . $t['si_main_menu_id'] . "'>" . $dash . $t['main_menu'] . "</label></div></div>";
            }

            if ($t['parent_id'] == $p) {
                $r = 0;
            }
            if (isset($t['_children'])) {
                $this->printTree($t['_children'], $r + 1, $t['parent_id']);
            }
        }
    }

    public function drop_menu() {
        extract($_REQUEST);
        $data['dropmenu'] = $this->Data_model->Get_data_all("si_main_menu", ["parent_id" => $id]);
        $output = array();
        $cnt = count($data['dropmenu']);
        //  print_r($data['dropmenu']);
        if ($cnt > 0) {
//            $output[] = "<hr>";
            $output[] = "";
            foreach ($data['dropmenu'] as $menu) {
                $output[] .="<div class='form-group'><input type='checkbox' id='sub" . $menu['si_main_menu_id'] . "' name='menu[]' value='" . $menu['si_main_menu_id'] . "'><label for='sub" . $menu['si_main_menu_id'] . "'> " . $menu['main_menu'] . "</label></div>";
            }
            echo json_encode($output);
        } else {
            echo json_encode($output);
        }
    }

    public function insert() {
        extract($_POST);
        $sql1 = "select * from si_main_menu where main_menu = '" . $account_type . "' and si_admin_id in ('" . $_SESSION['id'] . "') and status!='B'";
        $query1 = $this->Data_model->Custome_query($sql1);
        if (count($query1) > 0) {
            $this->session->set_flashdata(['msg' => 'The menu name ' . $account_type . ' is already exists. Please try another menu name.', 'cls' => 'btn btn-danger']);
        } else {
            $q = "SELECT si_main_menu_id FROM si_main_menu ORDER BY si_main_menu_id DESC LIMIT 1";
            $res = $this->Data_model->Custome_query($q);

            if (count($res) > 0) {
                $path = $res[0]['si_main_menu_id'] + 1;
            } else {
                $path = 1;
            }


            if ($account_type != '' && $maincat == 0) {
                $data = [
                    "si_admin_id" => $_SESSION['id'],
                    "parent_id" => 0,
                    "id_path" => $path,
                    "level" => 1,
                    "main_menu" => $account_type,
                    "link" => $link,
                    "icon" => $icon,
                    "created_date" => date('Y-m-d H:i:s'),
                ];
            } else {
                $id = explode(",", $maincat);
                $main_id_path = $maincat;

                if (strpos($id[1], "/") !== FALSE) {
                    $level = explode("/", $id[1]);
                    $lvl = count($level);
                } else {
                    $lvl = 1;
                }
                $sql = "select * from si_main_menu where si_main_menu_id='$id[0]'";
                $result = $this->Data_model->Custome_query($sql);

                $data = [
                    "si_admin_id" => $_SESSION['id'],
                    "parent_id" => $result[0]['si_main_menu_id'],
                    "id_path" => $id[1] . "/" . $path,
                    "level" => $lvl + 1,
                    "main_menu" => $account_type,
                    "link" => $link,
                    "icon" => $icon,
                    "created_date" => date('Y-m-d H:i:s'),
                ];
            }

            $this->Data_model->Insert_data("si_main_menu", $data);
            $this->session->set_flashdata(['msg' => 'Menu Succefully Created.', 'cls' => 'btn btn-warning']);
            // Bank book insert account start
            // Bank book insert account end
        }
        redirect(base_url("Admin/MenuAssign"));
    }

    public function insertLeaderMenu() {
        extract($_POST);
        $q = "select * from si_main_menu_assign where si_admin_id='$type' and status!='B'";
        $result = $this->Data_model->Custome_query($q);
//        echo "<pre>";  print_r($_POST);
//        die;
        if (count($result) > 0 || $type == 0) {
            if ($type == 0) {
                $this->session->set_flashdata(['msg' => 'Select team leader to  assign menu.', 'cls' => 'btn btn-danger']);
            } else {
                $this->session->set_flashdata(['msg' => 'This team leader already assign menu.', 'cls' => 'btn btn-danger']);
            }
        } else {

            $menu_id = implode(",", $menu);
//            echo $menu_id; die;
            $data = [
                'si_admin_id' => $type,
                'si_main_menu_id' => $menu_id,
                'created_date' => date('Y-m-d H:i:s'),
            ];
//            $sql = "insert into sai_menu_assign(sai_admin_id,sai_menu_id,create_date) values('$type','$menu_id','$d')";
            //die;
            $this->Data_model->Insert_data("si_main_menu_assign", $data);
            $this->session->set_flashdata(['msg' => 'Menu Succefully Assign.', 'cls' => 'btn btn-warning']);
        }
        redirect(base_url("Admin/MenuAssign"));
    }

    function selectLeaderMenu() {
        $requestData = $_POST;

        $id = $requestData['columns'][1]['search']['value'];
        $dt = explode(' - ', $id);
//        print_r($date);
//        die;

        $columns = array(
// datatable column index  => database column name
            0 => 'ms.si_main_menu_assign_id',
            1 => 'ad.name',
            2 => 'me.main_menu',
        );



        $sql = "SELECT ad.username,ad.name, GROUP_CONCAT(me.main_menu SEPARATOR ',') as menu_name, ms.si_main_menu_assign_id from si_main_menu_assign  ms,si_admin  ad, si_main_menu  me where ms.si_admin_id=ad.si_admin_id and ms.status!='B' and ad.status='A' and ad.role='TL' and FIND_IN_SET(me.si_main_menu_id, ms.si_main_menu_id) group by ad.username";
//        $sql = "SELECT ma.username,GROUP_CONCAT(mp.menu_name SEPARATOR ', ') as menu_name,mma.sai_menu_assign_id "
//                . "from sai_menu_assign mma,sai_admin ma, sai_menu mp "
//                . "where mma.sai_admin_id=ma.sai_admin_id and mma.is_delete='N' and ma.is_delete='N' and ma.status='A' and ma.role='SA' and FIND_IN_SET(mp.sai_menu_id, mma.sai_menu_assign_id) group by ma.username ";

        $query = $this->Data_model->Custome_query($sql);

        $totalData = count($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'" . str_replace(",", "','", $requestData['search']['value']) . "%'"; //wrapping qoutation
            $sql .= " and ( ms.si_main_menu_assign_id  LIKE " . $searchString;
            $sql .= " or ad.name  LIKE " . $searchString;
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

            $action = "<a class='edit_menu' data-id='" . $row["si_main_menu_assign_id"] . "'><i class='btn btn-primary btn-sm fa fa-edit'></i></a>  <a class='delete' data-id='" . $row["si_main_menu_assign_id"] . "'><i class='btn btn-danger btn-sm fa fa-close'></i></a>";
            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row["name"];
            $nestedData[] = $row["menu_name"];
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_main_menu_assign_id'];
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

    public function DeleteAccount($id) {
        $data = ['status' => 'B'];
        $con = ['si_main_menu_assign_id' => $id];
        $this->Data_model->Update_data('si_main_menu_assign', $con, $data);

        echo 1;
    }

    public function EditAccount($id = null) {
        extract($_POST);

        $con = ['si_main_menu_assign_id' => $id];
        $data = $this->Data_model->Get_data_one('si_main_menu_assign', $con);
//        print_r($data);
//        die;
        echo json_encode($data);
    }

    public function update() {
        extract($_REQUEST);
        //echo $edit_id;die;

        if ($e_type == 0) {
            $this->session->set_flashdata(['msg' => 'Select team leader to assign menu.', 'cls' => 'btn btn-danger']);
        } else {
            $id = array("si_main_menu_assign_id" => $edit_id);

            $data = [
                "si_admin_id" => $e_type,
                "si_main_menu_id" => $menu_id = implode(",", $menu),
                "updated_date" => date('Y-m-d H:i:s'),
            ];

            $this->Data_model->Update_data("si_main_menu_assign", $id, $data);
            $this->session->set_flashdata(['msg' => 'Menu Succefully Update.', 'cls' => 'btn btn-warning']);
        }
        redirect(base_url("Admin/MenuAssign"));
    }

    public function select_Menu() {
        $requestData = $_POST;

        $id = $requestData['columns'][1]['search']['value'];
        $dt = explode(' - ', $id);
//        print_r($date);
//        die;

        $columns = array(
// datatable column index  => database column name
            0 => 'mm.si_main_menu_id',
            1 => 'ad.name',
            2 => 'mm.main_menu',
        );



        $sql = "SELECT mm.*,ad.name from si_main_menu mm inner join si_admin ad on mm.si_admin_id=ad.si_admin_id where mm.status!='B'";
//        $sql = "SELECT ma.username,GROUP_CONCAT(mp.menu_name SEPARATOR ', ') as menu_name,mma.sai_menu_assign_id "
//                . "from sai_menu_assign mma,sai_admin ma, sai_menu mp "
//                . "where mma.sai_admin_id=ma.sai_admin_id and mma.is_delete='N' and ma.is_delete='N' and ma.status='A' and ma.role='SA' and FIND_IN_SET(mp.sai_menu_id, mma.sai_menu_assign_id) group by ma.username ";

        $query = $this->Data_model->Custome_query($sql);

        $totalData = count($query);
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'" . str_replace(",", "','", $requestData['search']['value']) . "%'"; //wrapping qoutation
            $sql .= " and ( mm.si_main_menu_id  LIKE " . $searchString;
            $sql .= " or ad.name  LIKE " . $searchString;
            $sql .= " or mm.main_menu  LIKE " . $searchString . ")";
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

            $action = "<a class='edit' data-id='" . $row["si_main_menu_id"] . "'><i class='btn btn-primary btn-sm fa fa-edit'></i></a>  <a class='del' data-id='" . $row["si_main_menu_id"] . "'><i class='btn btn-danger btn-sm fa fa-close'></i></a>";
            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row["name"];
            $nestedData[] = $row["main_menu"];
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_main_menu_id'];
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

    public function EditMenu($id = null) {
        extract($_POST);

        $con = ['si_main_menu_id' => $id];
        $data = $this->Data_model->Get_data_one('si_main_menu', $con);
//        print_r($data);
//        die;
        echo json_encode($data);
    }

    public function DeleteMenu($id) {
        $data = ['status' => 'B'];
        $con = ['si_main_menu_id' => $id];
        $this->Data_model->Update_data('si_main_menu', $con, $data);

        echo 1;
    }

    public function updateMenu() {
        extract($_REQUEST);
        //echo $edit_id;die;

        $id = array("si_main_menu_id" => $menuId);

        $data = [
            "si_admin_id" => $_SESSION['id'],
            "main_menu" => $menu_name,
            "link" => $e_link,
            "icon" => $e_icon,
            "updated_date" => date('Y-m-d H:i:s'),
        ];
        $this->Data_model->Update_data("si_main_menu", $id, $data);
        $this->session->set_flashdata(['msg' => 'Menu Succefully Update.', 'cls' => 'btn btn-warning']);

        redirect(base_url("Admin/MenuAssign"));
    }

}
