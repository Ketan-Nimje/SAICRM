<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Help extends CI_Controller
{
    public $module_folder;
    public $module;
    public $module_table;
    public $controller_path;
    public $view_data;

    function __construct()
    {
        parent::__construct();
        auth_check();
        $this->module_folder = $this->uri->segment(1);
        $this->module = $this->uri->segment(2);
        $this->module_table_prefix = 'si_helpdesk_';
        $this->module_table = 'si_helpdesk';
        $this->view_data['_controller_path'] = base_url() . $this->module_folder . '/' . $this->module . '/';
        $this->view_data['categories'] = [
            0 => 'Other',
            1 => 'Genius',
            6 => 'Payroll',
            42 => 'Complaw Without XBRL',
            57 => 'GST',
        ];
        $this->load->model($this->module_folder . '/HelpModel', 'ex');
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
            0 => 'si_helpdesk_id',
            1 => 'l_name',
            2 => 'up_file',
            3 => 'created_at',
            4 => 'updated_at',
        );

        $sql = "select si_helpdesk_id,l_name, up_file,status,created_at,updated_at from si_helpdesk where status in ('A', 'D')";
        $query = $this->ex->query($sql);

        $totalData = count($query);


        if (!empty(trim($requestData['search']['value']))) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'%" . str_replace(",", "','", trim($requestData['search']['value'])) . "%'"; //wrapping qoutation
            $sql .= " and ( l_name  LIKE " . $searchString . ")";
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

            $action = "<a class='change-status m-1' data-url='" . $this->view_data['_controller_path'] . "change_status' data-id='" . $row["si_helpdesk_id"] . "' data-module='" . $this->module . "' data-status='" . $stts . "'><i class='btn btn-sm btn-rounded " . $icon . "' aria-hidden='true'></i></a>
            <a data-modal='showModal' data-url='" . $this->view_data['_controller_path'] . "edit/" . $row["si_helpdesk_id"] . "' class='edit-row me-1'><i class='btn btn-sm btn-rounded btn-outline-info ri-edit-line'></i></a>
            <a data-url='" . $this->view_data['_controller_path'] . "delete' data-id='" . $row["si_helpdesk_id"] . "' data-module='" . $this->module . "' class='delete-row'><i class='btn btn-outline-danger btn-sm btn-rounded ri-delete-bin-line'></i></a>";

            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = $row["l_name"];
            $nestedData[] = "<a href='".$row['up_file']."' target='_blank'>".$row['up_file']."</a>";
            $nestedData[] = display_date($row["created_at"]);
            $nestedData[] = display_date($row["updated_at"]);
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_helpdesk_id'];
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

        $this->form_validation->set_rules('l_name', 'Product Name', 'trim|required');

        if (!$this->form_validation->run()) {
            $response['message'] = validation_errors(' ', ' ');
            echo json_encode($response);
            exit;
        }

        // get data
        $qData = [
            'l_name' => $this->input->post('l_name'),
            'productid' => $this->input->post('productid'),
            'up_file' => $this->input->post('up_file'),
            'status' => 'A',
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
            $sql = 'select 
            ' . $this->module_table_prefix . 'id as id,
            l_name,
            productid,
            up_file
            from si_helpdesk where status IN ("A", "D") and ' . $this->module_table_prefix . 'id=' . $id;
            $result = $this->ex->query($sql);

            if (!empty($result)) {
                $response['status'] = 'success';
                $response['message'] = 'Record found';
                $response['view_title'] = 'Update ' . ucwords(str_replace('-', ' ', $this->uri->segment(2)));
                $response['form_element'] = [
                    [
                        'name' => 'l_name',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'up_file',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'productid',
                        'type' => 'select',
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
            $res = $this->ex->update($this->module_table, [$this->module_table_prefix . "id" => $this->input->post('id')], ['status' => 'B']);
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
            $res = $this->ex->update($this->module_table, [$this->module_table_prefix . "id" => $this->input->post('id')], ['status' => $this->input->post('status')]);
            if ($res) {
                $response['status'] = true;
                $response['message'] = "{$_view_title} has been changed successfully.";
            }
        }
        echo json_encode($response);
    }
}
