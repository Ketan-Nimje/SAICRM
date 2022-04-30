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
        $this->view_data['users'] = $this->ex->query("select si_admin_id,name,username from si_admin where status='A'");
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

        $sql = "SELECT si_menu_assign_id,
        ms.si_admin_id,
        ad.name,
        ad.username,
        GROUP_CONCAT( DISTINCT m1.menu_name SEPARATOR ', ') client_form_menu,
        GROUP_CONCAT(DISTINCT m2.menu_name SEPARATOR ', ') contact_form_menu,
        GROUP_CONCAT(DISTINCT m3.menu_name SEPARATOR ', ') product_form_menu,
        ms.status,
        ms.create_date
        FROM si_admin ad
        JOIN si_menu_assign ms ON (ms.si_admin_id = ad.si_admin_id) 
        JOIN si_menu m1 ON FIND_IN_SET(m1.si_menu_id, ms.client_form) > 0
        JOIN si_menu m2 ON FIND_IN_SET(m2.si_menu_id, ms.contact_form) > 0
        JOIN si_menu m3 ON FIND_IN_SET(m3.si_menu_id, ms.product_form) > 0
        WHERE ms.status IN ('A','D') AND ad.status = 'A' AND ad.si_admin_id != " . $this->session->userdata('id');

        if (empty(trim($requestData['search']['value']))) {
            $sql .= ' GROUP BY ad.username';
        }
        $query = $this->ex->query($sql);

        $totalData = count($query);


        if (!empty(trim($requestData['search']['value']))) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'%" . str_replace(",", "','", trim($requestData['search']['value'])) . "%'"; //wrapping qoutation
            $sql .= " and ( ad.username  LIKE " . $searchString;
            $sql .= " or ad.name  LIKE " . $searchString . ")";
            $sql .= ' GROUP BY ad.username';
        }
        $query = $this->ex->query($sql);

        $totalFiltered = count($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.


        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . " LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length
        $query = $this->ex->query($sql);

        $data = array();

        $cnts = $requestData['start'] + 1;
        foreach ($query as $row) {
            $action = '';

            $action .= "<a data-modal='showModal' data-url='" . $this->view_data['_controller_path'] . "edit/" . $row["si_menu_assign_id"] . "' class='edit-row me-1'><i class='btn btn-sm btn-rounded btn-outline-info ri-edit-line'></i></a><a data-url='" . $this->view_data['_controller_path'] . "delete' data-id='" . $row["si_menu_assign_id"] . "' data-module='" . $this->module . "' class='delete-row'><i class='btn btn-outline-danger btn-sm btn-rounded ri-delete-bin-line'></i></a>";

            $menu = '';

            if ($row['client_form_menu'] != '') {
                $menu .= '<div class="card ribbon-box border-bottom shadow-none mb-lg-0" style="background:none;">
                            <div class="card-body">
                                <div class="ribbon ribbon-primary round-shape">Client Form</div>
                                <div class="ribbon-content mt-4 text-muted">
                                    <p class="mb-0">'. $row['client_form_menu'] .'</p>
                                </div>
                            </div>
                        </div>';
            }
            if ($row['contact_form_menu'] != '') {
                $menu .= '<div class="card ribbon-box border-bottom shadow-none mb-lg-0" style="background:none;">
                            <div class="card-body">
                                <div class="ribbon ribbon-info round-shape">Contact Form</div>
                                <div class="ribbon-content mt-4 text-muted">
                                    <p class="mb-0">'. $row['contact_form_menu'] .'</p>
                                </div>
                            </div>
                        </div>';
            }
            if ($row['product_form_menu'] != '') {
                $menu .= '<div class="card ribbon-box shadow-none mb-lg-0" style="background:none;">
                            <div class="card-body">
                                <div class="ribbon ribbon-secondary round-shape">Product Form</div>
                                <div class="ribbon-content mt-4 text-muted">
                                    <p class="mb-0">'. $row['product_form_menu'] .'</p>
                                </div>
                            </div>
                        </div>';
            }

            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row['name'] . '<br />('. strtolower($row["username"]) .')';
            $nestedData[] = $menu;
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

        if ($action == 'added') {
            $is_unique =  '|is_unique[si_menu_assign.si_admin_id]';
        } else {
            $is_unique =  '';
        }
        $this->form_validation->set_rules('user', 'User', 'trim|required'. $is_unique);
        $this->form_validation->set_rules('client_form[]', 'Client Form', 'trim|required');
        $this->form_validation->set_rules('contact_form[]', 'Contact Form', 'trim|required');
        $this->form_validation->set_rules('product_form[]', 'Product Form', 'trim|required');

        if (!$this->form_validation->run()) {
            $response['message'] = validation_errors(' ', ' ');
            echo json_encode($response);
            exit;
        }

        $menu_id = '';
        $client = '';
        $contact = '';
        $product = '';
        if (count($_POST['client_form']) > 0) {
            $menu_id .= implode(",", $_POST['client_form']);
            $client = implode(",", $_POST['client_form']);
        }
        if (count($_POST['contact_form']) > 0) {
            $menu_id .= "," . implode(",", $_POST['contact_form']);
            $contact = implode(",", $_POST['contact_form']);
        }

        if (count($_POST['product_form']) > 0) {
            $menu_id .= "," . implode(",", $_POST['product_form']);
            $product = implode(",", $_POST['product_form']);
        }

        // get data
        $qData = [
            'si_admin_id' => $this->input->post('user'),
            'si_menu_id' => $menu_id,
            'client_form' => $client,
            'contact_form' => $contact,
            'product_form' => $product
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
            $sql = "select si_menu_assign_id as id,si_admin_id as user,client_form,contact_form,product_form from si_menu_assign where si_menu_assign_id=$id";
            $result = $this->ex->query($sql);

            if (!empty($result)) {
                $response['status'] = 'success';
                $response['message'] = 'Record found';
                $response['view_title'] = 'Update ' . ucwords(str_replace('-', ' ', $this->uri->segment(2)));
                $response['form_element'] = [
                    [
                        'name' => 'user',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'client_form',
                        'type' => 'multi-select',
                    ],
                    [
                        'name' => 'contact_form',
                        'type' => 'multi-select',
                    ],
                    [
                        'name' => 'product_form',
                        'type' => 'multi-select',
                    ]
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
