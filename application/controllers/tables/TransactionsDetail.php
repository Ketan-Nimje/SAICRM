<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransactionsDetail extends CI_Controller
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
        $this->module_table_prefix = 'si_transactions_detail';
        $this->module_table = 'si_transactions_detail';
        $this->view_data['_controller_path'] = base_url() . $this->module_folder . '/' . $this->module . '/';
        $this->load->model($this->module_folder . '/TransactionsDetailModel', 'ex');
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
            0 => $this->module_table_prefix . '_id',
            1 => 'cd.contact_person',
            2 => 'p_name',
            3 => 'serial_no',
            4 => 'category_id',
            5 => 'for_year',
            6 => 'amount',
            7 => 'costamount',
            8 => 'taxamount',
            9 => 'new_lan',
            10 => 'total_lan_cost_amount',
            11 => 'billnumber',
            12 => 'payment_type',
            13 => 'billremarks',
            14 => 'transaction_date',
            15 => 'updated_at',
        );

        $sql = "SELECT
            cd.contact_person,
            cp.serial_no,
            cp.si_product_id,
            td.si_transactions_detail_id,
            td.p_name,
            td.category_id,
            td.for_year,
            td.amount,
            td.costamount,
            td.taxamount,
            td.new_lan,
            td.total_lan_cost_amount,
            td.billnumber,
            td.payment_type,
            td.billremarks,
            td.transaction_date,
            td.status
        FROM " . $this->module_table . " as td 
        inner join si_clients as cd on cd.si_clients_id=td.si_clients_id 
        inner join si_clients_details as cp on cp.si_clients_details_id=td.si_clients_details_id 
        where td.status IN ('A', 'D')";
        $query = $this->ex->query($sql);

        $totalData = count($query);

        if (!empty(trim($requestData['search']['value']))) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'%" . str_replace(",", "','", trim($requestData['search']['value'])) . "%'"; //wrapping qoutation
            $sql .= " AND ( cd.contact_person LIKE '" . $searchString . "%' ";
            $sql .= " OR p_name LIKE '" . $searchString . "%' ";
            $sql .= " OR cp.serial_no LIKE '" . $searchString . "%' ";
            $sql .= " OR td.amount LIKE '" . $searchString . "%' ";
            $sql .= " OR td.for_year LIKE '" . $searchString . "%' ";
            $sql .= " OR td.payment_type LIKE '" . $searchString . "%' ";
            $sql .= " OR td.billremarks LIKE '" . $searchString . "%' ";
            $sql .= " OR td.created_at LIKE '" . $searchString . "%' )";
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
            $action = "<a class='change-status m-1' data-url='" . $this->view_data['_controller_path'] . "change_status' data-id='" . $row["si_transactions_detail_id"] . "' data-module='" . $this->module . "' data-status='" . $stts . "'><i class='btn btn-sm btn-rounded " . $icon . "' aria-hidden='true'></i></a>";
            $action .= "<a data-modal='showModal' data-url='" . $this->view_data['_controller_path'] . "edit/" . $row["si_transactions_detail_id"] . "' class='edit-row me-1'><i class='btn btn-sm btn-rounded btn-outline-info ri-edit-line'></i></a>";
            $action .= "<a data-url='" . $this->view_data['_controller_path'] . "delete' data-id='" . $row["si_transactions_detail_id"] . "' data-module='" . $this->module . "' class='delete-row'><i class='btn btn-outline-danger btn-sm btn-rounded ri-delete-bin-line'></i></a>";

            if ($row['category_id'] == 0)
                $fre_value = 'selected';
            else if ($row['category_id'] == 1)
                $fre_value = "Installation";
            else if ($row['category_id'] == 2)
                $fre_value = "Updatation";
            else if ($row['category_id'] == 3)
                $fre_value = "Lan";
            else if ($row['category_id'] == 4)
                $fre_value = "Conversion";
            else
                $fre_value = "not geting";

            $nestedData = array();
            $nestedData[] = $cnts++;
            $nestedData[] = to_title_case($row["contact_person"]);
            $nestedData[] = $row["p_name"];
            if (strlen($row['serial_no']) > 14) {
                $nestedData[] =  chunk_split($row['serial_no'], 14, "\n");
            } else {
                $nestedData[] = $row['serial_no'];
            }
            $nestedData[] = $fre_value;
            $nestedData[] = $row['for_year'];
            $nestedData[] = $row['amount'];
            $nestedData[] = $row['costamount'];
            $nestedData[] = $row['taxamount'];
            $nestedData[] = $row['new_lan'];
            $nestedData[] = $row['total_lan_cost_amount'];
            $nestedData[] = $row['billnumber'];
            $nestedData[] = $row['payment_type'];
            $nestedData[] = $row['billremarks'];
            if ($row['transaction_date'] == NULL) {
                $nestedData[] = '';
            } else {
                $nestedData[] = display_date($row["transaction_date"]);
            }
            $nestedData[] = $action;
            $nestedData['DT_RowId'] = "r" . $row['si_transactions_detail_id'];
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
            $is_unique =  '|is_unique[si_transactions_detail.name]';
        } else {
            $is_unique =  '';
        }
        $this->form_validation->set_rules('contact_person', 'TransactionsDetailname', 'trim|required' . $is_unique);
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
            $sql = "select si_transactions_detail_id as id,contact_person,name,firm_name,register_email,registed_mobile from si_transactions_detail where status IN ('A', 'D') AND si_transactions_detail_id=$id";
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
            $res = $this->ex->update($this->module_table, ['si_transactions_detail_id' => $this->input->post('id')], ['status' => 'Y']);
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
            $res = $this->ex->update($this->module_table, ['si_transactions_detail_id' => $this->input->post('id')], ['status' => $this->input->post('status')]);
            if ($res) {
                $response['status'] = true;
                $response['message'] = "{$_view_title} has been changed successfully.";
            }
        }
        echo json_encode($response);
    }
}
