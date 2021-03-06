<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientMaster extends CI_Controller
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
        auth_check();
        $this->module_folder = $this->uri->segment(1);
        $this->module = $this->uri->segment(2);
        $this->module_table_prefix = 'si_clients_';
        $this->module_table = 'si_clients';
        $this->view_data['_controller_path'] = base_url() . $this->module_folder . '/' . $this->module . '/';
        $this->view_data['registed_mobile'] = ['SA' => 'Admin', 'TL' => 'Team Leader', 'A' => 'Staff'];
        $this->load->model($this->module_folder . '/ClientMasterModel', 'ex');
    }

    /**
     * Index method
     */

    function index()
    {
        $this->view_data['_breadcrumb_heading'] = ucwords(str_replace('-', ' ', $this->uri->segment(1)));
        $this->view_data['_view_title'] = ucwords(str_replace('-', ' ', $this->uri->segment(2)));

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
            0 => 'si_clients_id',
            1 => 'contact_person',
            2 => 'firm_name',
            3 => 'registed_mobile',
            4 => 'register_email',
            5 => 'created_at',
            6 => 'updated_at'
        );

        $sql = "select si_clients_id,contact_person,firm_name,registed_mobile,register_email,created_at,updated_at,status from si_clients where status IN ('A', 'D')";
        $query = $this->ex->query($sql);

        $totalData = count($query);


        if (!empty(trim($requestData['search']['value']))) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'%" . str_replace(",", "','", trim($requestData['search']['value'])) . "%'"; //wrapping qoutation
            $sql .= " and ( contact_person  LIKE " . $searchString;
            $sql .= " or registed_mobile  LIKE " . $searchString;
            $sql .= " or register_email  LIKE " . $searchString;
            $sql .= " or firm_name  LIKE " . $searchString . ")";
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
            $action = "<a class='change-status m-1' data-url='" . $this->view_data['_controller_path'] . "change_status' data-id='" . $row["si_clients_id"] . "' data-module='" . $this->module . "' data-status='" . $stts . "'><i class='btn btn-sm btn-rounded " . $icon . "' aria-hidden='true'></i></a>";
            $action .= "<a data-modal='showModal' data-url='" . $this->view_data['_controller_path'] . "edit/" . $row["si_clients_id"] . "' class='edit-row me-1'><i class='btn btn-sm btn-rounded btn-outline-info ri-edit-line'></i></a>";
            $action .= "<a data-url='" . $this->view_data['_controller_path'] . "delete' data-id='" . $row["si_clients_id"] . "' data-module='" . $this->module . "' class='delete-row'><i class='btn btn-outline-danger btn-sm btn-rounded ri-delete-bin-line'></i></a>";

            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = to_title_case($row["contact_person"]);
            $nestedData[] = $row["firm_name"];
            $nestedData[] = $row['registed_mobile'];
            $nestedData[] = $row['register_email'];
            $nestedData[] = display_datetime($row["created_at"]);
            $nestedData[] = display_datetime($row["updated_at"]);
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_clients_id'];
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
            $is_unique =  '|is_unique[si_clients.name]';
        } else {
            $is_unique =  '';
        }
        $this->form_validation->set_rules('contact_person', 'ClientMastername', 'trim|required' . $is_unique);
        $this->form_validation->set_rules('firm_name', 'Phone', 'trim|required|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('register_email', 'Password', 'trim|required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('registed_mobile', 'Role', 'trim|required');

        if (!$this->form_validation->run()) {
            $response['message'] = validation_errors(' ', ' ');
            echo json_encode($response);
            exit;
        }

        // get data
        $qData = [
            'name' => $this->input->post('name'),
            'contact_person' => $this->input->post('contact_person'),
            'firm_name' => $this->input->post('firm_name'),
            'register_email' => $this->input->post('register_email'),
            'registed_mobile' => $this->input->post('registed_mobile')
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
            $sql = "select si_clients_id as id,contact_person,name,firm_name,register_email,registed_mobile from si_clients where status IN ('A', 'D') AND si_clients_id=$id";
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
                        'name' => 'contact_person',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'firm_name',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'register_email',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'confirm_register_email',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'registed_mobile',
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
            $res = $this->ex->update($this->module_table, ['si_clients_id' => $this->input->post('id')], ['status' => 'Y']);
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
            $res = $this->ex->update($this->module_table, ['si_clients_id' => $this->input->post('id')], ['status' => $this->input->post('status')]);
            if ($res) {
                $response['status'] = true;
                $response['message'] = "{$_view_title} has been changed successfully.";
            }
        }
        echo json_encode($response);
    }
}
