<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserPrivilige extends CI_Controller
{
    public $module_folder;
    public $module;
    public $module_table_prefix;
    public $module_table;
    public $controller_path;
    public $view_data;

    function __construct()
    {

        parent::__construct();
        // auth_check();
        $this->module_folder = $this->uri->segment(1);
        $this->module = $this->uri->segment(2);
        $this->module_table_prefix = 'si_menu_assign_';
        $this->module_table = 'si_menu_assign';
        $this->view_data['_controller_path'] = base_url() . $this->module_folder . '/' . $this->module . '/';
        $this->view_data['roles'] = ['SA' => 'Admin', 'TL' => 'Team Leader', 'A' => 'Staff'];
        $this->load->model($this->module_folder . '/UserPriviligeModel', 'ex');
    }

    /**
     * Index method
     */

    function index()
    {
        $this->view_data['_breadcrumb_heading'] = ucwords(str_replace('-', ' ', $this->uri->segment(1)));
        $this->view_data['_view_title'] = ucwords(str_replace('-', ' ', $this->uri->segment(2)));
        $this->view_data['users'] = $this->ex->query("select si_admin_id,name from si_admin where status='A'");
        $this->view_data['menus'] = $this->ex->query("select si_menu_id,parent_id,menu_name from si_menu where status='A'");
        
        $this->load->view($this->module_folder . '/' . $this->module, $this->view_data);
    }

    /**
     * 
     */
    function get_data()
    {
        $requestData = $_REQUEST;

        $columns = array(
            // datatable column index  => database column name
            0 => 'si_menu_assign_id',
            1 => 'name',
            2 => 'menu_name',
            3 => 'timestamp'
        );

        $sql = "select si_menu_assign_id,username,name,phone,role,otp,create_date,update_date,status from si_menu_assign where status IN ('A', 'D')";
        $sql = "SELECT 
        ad.username, 
        GROUP_CONCAT(me.menu_name SEPARATOR ',') as menu_name,
        ms.client_form,
        ms.contact_form,
        ms.product_form,
        ms.si_menu_assign_id
        FROM si_menu_assign  ms,
        JOIN si_admin ad ON (ms.si_admin_id = ad.si_admin_id) 
        JOIN si_menu me ON FIND_IN_SET(me.si_menu_id, ms.si_menu_id) != -1
        WHERE ms.status IN ('A', 'D') AND ad.status = 'A' AND ad.si_admin_id != " . $this->session->userdata('si_admin_id') . " 
        GROUP BY ad.username";
        $query = $this->ex->query($sql);

        $totalData = count($query);


        if (!empty(trim($requestData['search']['value']))) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'%" . str_replace(",", "','", trim($requestData['search']['value'])) . "%'"; //wrapping qoutation
            $sql .= " and ( ad.username  LIKE " . $searchString;
            $sql .= " or me.menu_name  LIKE " . $searchString . ")";
        }
        $query = $this->ex->query($sql);

        $totalFiltered = count($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.


        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length
        $query = $this->ex->query($sql);

        $data = array();

        $cnts = $requestData['start'] + 1;
        foreach ($query as $row) {

            if ($row['status'] == 'A') {
                $stts = 'D';
                $icon = 'btn-outline-success ri-eye-line';
            } else {
                $stts = 'A';
                $icon = 'btn-outline-warning ri-eye-off-line';
            }

            $action = '';
            if ($row['role'] == 'A' || $row['role'] == 'TL') {
                $action .= "<a class='change-status m-1' data-url='" . $this->view_data['_controller_path'] . "change_status' data-id='" . $row["si_menu_assign_id"] . "' data-module='" . $this->module . "' data-status='" . $stts . "'><i class='btn btn-sm btn-rounded " . $icon . "' aria-hidden='true'></i></a>";
            }

            $action .= "<a data-modal='showModal' data-url='" . $this->view_data['_controller_path'] . "edit/" . $row["si_menu_assign_id"] . "' class='edit-row me-1'><i class='btn btn-sm btn-rounded btn-outline-info ri-edit-line'></i></a>";

            if ($row['role'] == 'A' || $row['role'] == 'TL') {
                $action .= "<a data-url='" . $this->view_data['_controller_path'] . "delete' data-id='" . $row["si_menu_assign_id"] . "' data-module='" . $this->module . "' class='delete-row'><i class='btn btn-outline-danger btn-sm btn-rounded ri-delete-bin-line'></i></a>";
            }

            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row["name"];
            $nestedData[] = $row["username"];
            $nestedData[] = $row["phone"];
            $nestedData[] = $this->view_data['roles'][$row["role"]];
            $nestedData[] = $row["otp"];
            $nestedData[] = display_datetime($row["create_date"]);
            $nestedData[] = display_datetime($row["update_date"]);
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_menu_assign_id'];
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data,   // total data array
            "sql" => $sql   // query
        );
        echo json_encode($json_data);
    }

    /**
     * Add or Update records
     */
    function add_update()
    {
        // response json
        $response = [
            'status' => 'fail',
            'message' => '',
            'is_redirect' => false,
            'is_table' => true
        ];

        // load libraries and helpers
        $this->load->library('form_validation');

        $id = $this->input->post('id');
        $action = ($id > 0) ? 'updated' : 'added';
        $_view_title = ucwords(str_replace('-', ' ', $this->uri->segment(2)));

        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        if ($action == 'added') {
            $is_unique =  '|is_unique[si_menu_assign.name]';
        } else {
            $is_unique =  '';
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required' . $is_unique);
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required');

        if (!$this->form_validation->run()) {
            $response['message'] = validation_errors(' ', ' ');
            echo json_encode($response);
            exit;
        }

        // get data
        $qData = [
            'name' => $this->input->post('name'),
            'username' => $this->input->post('username'),
            'phone' => $this->input->post('phone'),
            'password' => $this->input->post('password'),
            'role' => $this->input->post('role')
        ];

        $response['status'] = 'success';
        $response['message'] =  "{$_view_title} has been {$action} successfully.";

        if ($action == 'added') {
            $this->ex->add($this->module_table, $qData);
        } elseif ($action == 'updated') {
            $this->ex->update($this->module_table, [$this->module_table_prefix . "id" => $this->input->post('id')], $qData);
        }

        echo json_encode($response);
    }

    /**
     * Display a record
     */
    function show()
    {
    }

    /**
     * Display a record
     */
    function edit($id = 0)
    {
        $response = [
            'status' => 'fail',
            'message' => 'Record not found',
            'data' => [],
        ];

        if ($id > 0) {
            $sql = "select si_menu_assign_id as id,username,name,phone,password,role from si_menu_assign where status IN ('A', 'D') AND si_menu_assign_id=$id";
            $result = $this->ex->query($sql);

            if (!empty($result)) {
                $response['status'] = 'success';
                $response['message'] = 'Record found';
                $response['view_title'] = 'Update ' . ucwords(str_replace('-', ' ', $this->uri->segment(2)));
                $response['form_element'] = [
                    [
                        'name' => 'name',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'username',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'phone',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'password',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'confirm_password',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'role',
                        'type' => 'select',
                    ],
                ];
                $response['data'] = $result[0];
            }
        }
        echo json_encode($response);
    }

    /**
     * Delete the records
     */
    function delete()
    {
        $_view_title = ucwords(str_replace('-', ' ', $this->uri->segment(2)));
        $response = [
            'status' => false,
            'message' => "{$_view_title} does not exist.",
            'is_redirect' => false,
        ];
        if ($this->input->post('id')) {
            $res = $this->ex->update($this->module_table, ['si_menu_assign_id' => $this->input->post('id')], ['status' => 'Y']);
            if ($res) {
                $response['status'] = true;
                $response['message'] = "{$_view_title} has been deleted successfully.";
            }
        }
        echo json_encode($response);
    }

    /**
     * Update a status
     */
    function change_status()
    {
        $_view_title = ucwords(str_replace('-', ' ', $this->uri->segment(2)));
        $response = [
            'status' => false,
            'message' => "{$_view_title} does not exist.",
            'is_redirect' => false,
        ];
        if ($this->input->post('id')) {
            $res = $this->ex->update($this->module_table, ['si_menu_assign_id' => $this->input->post('id')], ['status' => $this->input->post('status')]);
            if ($res) {
                $response['status'] = true;
                $response['message'] = "{$_view_title} has been changed successfully.";
            }
        }
        echo json_encode($response);
    }
}
