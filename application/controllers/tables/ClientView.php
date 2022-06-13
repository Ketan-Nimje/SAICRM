<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ClientView extends CI_Controller
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
        $this->load->model($this->module_folder . '/ClientViewModel', 'ex');
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
        $status = " sc.status IN ('A','D') ";
        $scd_status = " AND scd.status IN ('A','D') ";

        $columns = array(
            // datatable column index  => database column name
            0 => 'sc.created_at',
            1 => 'sc.contact_person',
            2 => 'sc.firm_name',
            3 => 'sc.registed_mobile',
            4 => 'sc.register_email',
            5 => 'scd.serial_no',
            6 => 'scd.activation_code',
        );

        $sql = "SELECT sc.si_clients_id,
        sc.contact_person,
        sc.firm_name,
    sc.registed_mobile,
    sc.register_email,
    scd.serial_no,
    scd.activation_code,
    sc.status,
    sc.Client_Assigned AS Client_Assigned,
    (
        SELECT
            GROUP_CONCAT(ff.name)
        FROM
            si_admin ff
        WHERE
            sc.Client_Assigned = ff.si_admin_id AND sc.Client_Assigned IS NOT NULL
    ) AS Admin_Name
    FROM
        si_clients sc
    INNER JOIN si_clients_details scd ON (sc.si_clients_id = scd.si_clients_id $scd_status)
    WHERE $status";



        if (!empty(trim($requestData['search']['value']))) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql .= " AND ( " . "sc.contact_person LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.firm_name LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.registed_mobile LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR sc.register_email LIKE '%" . $requestData['search']['value'] . "%' ";
            $sql .= " OR scd.serial_no LIKE '%" . $requestData['search']['value'] . "%') ";
        }
        $sql .= " group by sc.si_clients_id";
        $query = $this->ex->query($sql);

        $totalData = count($query);

        $totalFiltered = $totalData; // when there is a search parameter then we have to modify total number filtered rows as per search result.


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
            $info = "<a class='client_info btn-small' data-id='" . $row[$this->module_table_prefix . 'id'] . "' title='View Client Detail'><i class='btn btn-sm btn-rounded btn-outline-primary ri-article-line'></i></a>";
            $edit = "<a class='edit btn-small' data-id='" . $row[$this->module_table_prefix . 'id'] . "' data-isstatus='" . $row['status'] . "' data-status='" . $row['status'] . "' title='View Product'><i class='btn btn-sm btn-rounded btn-outline-info ri-product-hunt-line'></i></a>";
            $remark = "<a class='remark btn-small' data-id='" . $row[$this->module_table_prefix . 'id'] . "' data-isstatus='" . $row['status'] . "' data-status='B' title='Remark'><i class='btn btn-sm btn-rounded btn-outline-secondary ri-file-edit-line'></i></a>";
            $pay = "<a class='pay btn-small' btn-small' data-id='" . $row[$this->module_table_prefix . 'id'] . "' data-isstatus='" . $row['status'] . "' title='Pay'><i class='btn btn-sm btn-rounded btn-outline-warning ri-paypal-line'></i></a>";
            $mail = "<a class='mail btn-small' btn-small' data-mailid='" . $row['register_email'] . "' data-serial='" . $row['serial_no'] . "' data-isstatus='" . $row['status'] . "' title='Customer mail Inquiry'><i class='btn btn-sm btn-rounded btn-outline-dark ri-mail-line'></i></a>";
            $whatsapp = "<a class='whatsapp btn-small' data-isstatus='" . $row['status'] . "' data-id='" . $row['registed_mobile'] . "' id='" . $row[$this->module_table_prefix . 'id'] . "' title='Send WhatsApp' ><i class='btn btn-sm btn-rounded btn-outline-success ri-whatsapp-line
            '></i></a>";

            $n = $row['Client_Assigned'];
            if ($n) {
                $t = $row['Admin_Name'];
                $style1 = 'background-color: rgb(19, 218, 254);border-color: rgb(19, 218, 254);box-shadow: rgb(19, 218, 254) 0px 0px 0px 11px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;';
                $style2 = 'left:13px;transition: background-color 0.4s ease 0s,left 0.2s ease 0s; background-color:rgb(255, 255, 255);';
            } else {
                $t = 'Turn ON';
                $style1 = 'background-color: rgb(255, 255, 255);border-color: rgb(223, 223, 223);box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;';
                $style2 = 'left: 0px; transition: background-color 0.4s ease 0s, left 0.2s ease 0s;';
            }

            $toggle = '<a class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="' . $row[$this->module_table_prefix . 'id'] . 'ed" onclick="ed(' . $row[$this->module_table_prefix . 'id'] . ');" title="' . $t . '" hb="' . $n . '" by="' . $t . '">
            </a>';

            // $toggle = '<span  id="' . $row[$this->module_table_prefix . 'id'] . 'ed" onclick="ed(' . $row[$this->module_table_prefix . 'id'] . ');" class="switchery switchery-small" 
            // style="' . $style1 . '" title="' . $t . '" hb="' . $n . '" by="' . $t . '"><small id="' . $row[$this->module_table_prefix . 'id'] . 'ed1" style="' . $style2 . '"></small></span>';

            $action = "<a class='change-status m-1' data-url='" . $this->view_data['_controller_path'] . "change_status' data-id='" . $row["si_clients_id"] . "' data-module='" . $this->module . "' data-status='" . $stts . "'><i class='btn btn-sm btn-rounded " . $icon . "' aria-hidden='true'></i></a>";
            $action .= "<a data-modal='showModal' data-url='" . $this->view_data['_controller_path'] . "edit/" . $row["si_clients_id"] . "' class='edit-row me-1'><i class='btn btn-sm btn-rounded btn-outline-info ri-edit-line'></i></a>";
            $action .= "<a data-url='" . $this->view_data['_controller_path'] . "delete' data-id='" . $row["si_clients_id"] . "' data-module='" . $this->module . "' class='delete-row'><i class='btn btn-outline-danger btn-sm btn-rounded ri-delete-bin-line'></i></a>";

            $nestedData = array();
            $nestedData[] = $info." ". $cnts++;
            $nestedData[] = to_title_case($row["contact_person"]);
            $nestedData[] = $row["firm_name"];
            $nestedData[] = $row['registed_mobile'];
            $nestedData[] = $row['register_email'];
            $nestedData[] = $row['serial_no'];
            // $nestedData[] = $action;
            if ($this->session->userdata('id') == 1)
                $nestedData[] = $edit . "&nbsp;" . $remark . "&nbsp;" . $pay . "&nbsp;" . $mail . "&nbsp" . $whatsapp . "&nbsp" . $toggle;
            elseif ($this->session->userdata('id') == 17 || $this->session->userdata('id') == 19)
                $nestedData[] = $edit . "&nbsp;" . $remark . "&nbsp;" . $pay . "&nbsp;" . $mail . "&nbsp" . $whatsapp . "&nbsp" . $toggle;
            else
                $nestedData[] = $edit . "&nbsp;" . $remark . "&nbsp;" . $mail . "&nbsp;" . $whatsapp . "&nbsp" . $toggle;
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
        $this->form_validation->set_rules('contact_person', 'ClientViewname', 'trim|required' . $is_unique);
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
