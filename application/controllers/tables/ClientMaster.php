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
        $this->view_data['laptop_devices'] = ['NL' => 'No Laptop', 'OL' => 'Only Laptop', 'WL' => 'With Laptop'];
        $this->view_data['reg_types'] = ['O' => 'Online', 'H' => 'H Lock'];
        $this->view_data['lan_types'] = ['Decl Without Srv', 'Decl With Srv', 'Lan'];
        $this->load->model($this->module_folder . '/ClientMasterModel', 'ex');
    }

    /**
     * Index method
     */

    function index()
    {
        $this->view_data['_breadcrumb_heading'] = ucwords(str_replace('-', ' ', $this->uri->segment(1)));
        $this->view_data['_view_title'] = ucwords(str_replace('-', ' ', $this->uri->segment(2)));
        $this->view_data['states'] = $this->ex->query("select si_state_id,name from si_state where status='A' order by name");
        $this->view_data['users'] = $this->ex->query("select si_admin_id,name from si_admin where status='A' order by name");
        $this->view_data['products'] = $this->ex->query("select si_product_id,p_name from si_product where status='A' order by p_name");
        $this->view_data['for_years'] = $this->ex->query("select si_for_year_id,yearname from si_for_year where status='A' order by yearname DESC");
        $this->view_data['gstkeys'] = $this->ex->query("select si_gstkey_id,gstkey from si_gstkey where status='A' order by gstkey");
        
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

        $sql = "select si_clients_id,contact_person,firm_name,registed_mobile,register_email,status from si_clients where status IN ('A', 'D')";
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
                $status = 'Deactive';
                $icon = 'btn-outline-success ri-eye-line';
            } else {
                $stts = 'A';
                $status = 'Active';
                $icon = 'btn-outline-warning ri-eye-off-line';
            }

            $action = '';
            $action = "<li><a href='#' class='dropdown-item change-status m-1' data-url='" . $this->view_data['_controller_path'] . "change_status' data-id='" . $row["si_clients_id"] . "' data-module='" . $this->module . "' data-status='" . $stts . "'><i class='btn-sm " . $icon . "' aria-hidden='true'></i> Mark as ".$status."</a></li>";
            $action .= "<li><a href='#' data-modal='showModal' data-url='" . $this->view_data['_controller_path'] . "edit/" . $row["si_clients_id"] . "' class='dropdown-item edit-row me-1'><i class='btn-sm btn-outline-info ri-edit-line'></i> Edit</a></li>";
            $action .= "<li><a href='#' data-url='" . $this->view_data['_controller_path'] . "delete' data-id='" . $row["si_clients_id"] . "' data-module='" . $this->module . "' class='dropdown-item delete-row'><i class='btn-outline-danger btn-sm ri-delete-bin-line'></i> Delete</a></li>";
            $action .= "<li><button type='button' data-id='" . $row["si_clients_id"] . "' class='dropdown-item client-product-row me-1' data-bs-toggle='modal' data-bs-target='#showProductModal'><i class='btn-sm btn-outline-secondary  ri-product-hunt-fill'></i> View Product</button></li>";

            $action_btn = '<div class="btn-group dropend">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu">
                    '. $action .'
                </ul>
            </div>';

            $nestedData = array();
            $nestedData[] = to_title_case($row["contact_person"]);
            $nestedData[] = $row["firm_name"];
            $nestedData[] = $row['registed_mobile'];
            $nestedData[] = $row['register_email'];
            $nestedData[] = $action_btn;
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

        if ($action == 'added') {
            $is_unique =  '|is_unique[si_clients.register_email]';
        } else {
            $is_unique =  '';
        }

        // contact information validation
        $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
        $this->form_validation->set_rules('firm_name', 'Firm Name', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile No', 'trim|required|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email' . $is_unique);
        $this->form_validation->set_rules('address1', 'Address 1', 'trim|required');
        $this->form_validation->set_rules('area', 'Area', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|min_length[5]|max_length[8]');

        if (!$this->form_validation->run()) {
            $response['message'] = validation_errors(' ', ' ');
            echo json_encode($response);
            exit;
        }
        
        // file validation
        $filename = '';
        if (!empty($_FILES['change_email_form']['name'])) {
            $fres = move_file('change_email_form', '/assetss/upload/files', $id, 'pdf');
            if ($fres['status'] == 'fail') {
                $response['message'] = $fres['message'];
                echo json_encode($response);
                exit;
            } else {
                $filename = $fres['message'];
            }
        }

        // add client info
        $qData = [
            'contact_person' => $this->input->post('contact_person'),
            'firm_name' => $this->input->post('firm_name'),
            'registed_mobile' => $this->input->post('mobile'),
            'register_email' => $this->input->post('email'),
            'address' => $this->input->post('address1'),
            'address1' => $this->input->post('address2'),
            'area' => $this->input->post('area'),
            'city' => $this->input->post('city'),
            'si_state_id' => $this->input->post('state'),
            'pincode' => $this->input->post('pincode'),
            'mobile1' => $this->input->post('mobile1'),
            'mobile2' => $this->input->post('mobile2'),
            'mobile3' => $this->input->post('mobile3'),
            'phone1' => $this->input->post('phone1'),
            'phone2' => $this->input->post('phone2'),
            'gstin_no' => $this->input->post('gstno'),
        ];

        $response['status'] = 'success';
        $response['message'] =  "{$_view_title} has been {$action} successfully.";

        $client_id = 0;
        if ($action == 'added') {
            $client_id = $this->ex->add($this->module_table, $qData);            
        } elseif ($action == 'updated') {
            $this->ex->update($this->module_table, [$this->module_table_prefix . "id" => $this->input->post('id')], $qData);
            $client_id = $this->input->post('id');
        }

        // client ID > 0 & add client product info
        if ($client_id > 0 && in_array($action, ['added', 'updated'])) {
            $pData = [
                'si_clients_id' => $client_id,
                'p_email' => $this->input->post('email'),
                'si_product_id' => $this->input->post('product'),
                'si_conversion_product_id' => $this->input->post('conversion_product'),
                'laptop' => $this->input->post('laptop'),
                'category_id' => $this->input->post('category'),
                'referby' => $this->input->post('referby'),
                'reg_type' => $this->input->post('reg_type'),
                'si_for_year_id' => $this->input->post('for_year'),
                'serial_no' => $this->input->post('serial_no'),
                'activation_code' => $this->input->post('activation_code'),
                'lan_type' => $this->input->post('srv_lan'),
                'total_lan' => $this->input->post('srv_lan_no'),
                'si_gstkey_id' => 0,
                'attach_file' => $filename,
            ];
            $client_detail_id = $this->ex->add('si_clients_details', $pData);

            // $client_detail_id > 0 & product purchase info
            if ($client_detail_id > 0) {
                $product = array(
                    'si_clients_details_id' => $client_detail_id,
                    'purchase_year' => $this->input->post('for_year'),
                    'purchase_date' => date('Y-m-d', strtotime($this->input->post('purchase_date'))),
                    'renewal_date' => date('Y-m-d', strtotime($this->input->post('renewal_date'))),
                );

                $this->ex->add('si_product_purchase', $product);
            }
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
            $sql = "select si_clients_id as id,
            contact_person,
            firm_name,
            register_email as email,
            registed_mobile as mobile,
            address as address1,
            address as address2,
            area,
            city,
            si_state_id as state,
            pincode,
            mobile1,
            mobile2,
            mobile3,
            phone1,
            phone2,
            gstin_no as gstno,
            2 as category,
            0 as srv_lan,
            (SELECT GROUP_CONCAT(scd.si_product_id) FROM si_clients_details scd WHERE scd.si_clients_id = sc.si_clients_id AND status='A') as product
            from si_clients sc
            where status IN ('A', 'D') AND si_clients_id=$id";
            $result = $this->ex->query($sql);

            if (!empty($result)) {
                $response['status'] = 'success';
                $response['message'] = 'Record found';
                $response['view_title'] = 'Update ' . ucwords(str_replace('-', ' ', $this->uri->segment(2)));
                $response['form_element'] = [
                    [
                        'name' => 'contact_person',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'firm_name',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'email',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'mobile',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'address1',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'address2',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'area',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'city',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'state',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'pincode',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'mobile1',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'mobile2',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'mobile3',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'phone1',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'phone2',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'gstno',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'category',
                        'type' => 'select',
                        'event' => 'change',
                    ],
                    [
                        'name' => 'srv_lan',
                        'type' => 'select',
                        'event' => 'change',
                    ],
                    [
                        'name' => 'product',
                        'type' => 'visible-select-option',
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
        $_view_title = $this->input->get('table') ? 'Product' : ucwords(str_replace('-', ' ', $this->uri->segment(2)));
        $response = [
            'status' => false,
            'message' => "{$_view_title} does not exist.",
            'is_redirect' => false,
        ];
        if ($this->input->post('id')) {
            $table = $this->input->get('table') ? $this->input->get('table') : $this->module_table; 
            $res = $this->ex->update($table, [$table.'_id' => $this->input->post('id')], ['status' => 'B']);
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
        $_view_title = $this->input->get('table') ? 'Product' : ucwords(str_replace('-', ' ', $this->uri->segment(2)));
        $response = [
            'status' => false,
            'message' => "{$_view_title} does not exist.",
            'is_redirect' => false,
        ];
        if ($this->input->post('id')) {
            $table = $this->input->get('table') ? $this->input->get('table') : $this->module_table; 
            $res = $this->ex->update($table, [$table.'_id' => $this->input->post('id')], ['status' => $this->input->post('status')]);
            if ($res) {
                $response['status'] = true;
                $response['message'] = "{$_view_title} has been changed successfully.";
            }
        }
        echo json_encode($response);
    }

    /**
     * Get client products by client id
     */
    function client_product($id = 0)
    {
        $requestData = $_REQUEST;

        $columns = array(
            // datatable column index  => database column name
            0 => 'cd.si_clients_details_id',
            1 => 'p.p_name',
            2 => 'pp.purchase_year',
            3 => 'pp.purchase_date',
            4 => 'pp.renewal_date',
            5 => 'cd.activation_code',
            6 => 'cd.serial_no',
            7 => 'cd.lan_type',
            8 => 'cd.total_lan',
            9 => 'cd.reg_type',
            10 => 'cd.status',
        );

        $sql = "SELECT 
                cd.si_clients_details_id,
                cd.si_conversion_product_id,
                fy.yearname,
                p.p_name,
                pp.purchase_year,
                pp.purchase_date,
                pp.renewal_date,
                cd.activation_code,
                cd.serial_no,
                cd.lan_type,
                cd.total_lan,
                cd.reg_type,
                cd.status,
                cd.attach_file
            FROM si_clients_details AS cd
            INNER JOIN si_product AS p ON (p.si_product_id = cd.si_product_id)
            INNER JOIN si_product_purchase AS pp ON (pp.si_clients_details_id = cd.si_clients_details_id)
            INNER JOIN si_for_year AS fy ON (pp.purchase_year = fy.si_for_year_id)
            WHERE cd.si_clients_id = {$id} AND cd.status IN ('A', 'D')";
        $query = $this->ex->query($sql);

        $totalData = count($query);


        if (!empty(trim($requestData['search']['value']))) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchString = "'%" . str_replace(",", "','", trim($requestData['search']['value'])) . "%'"; //wrapping qoutation
            $sql .= " and ( p.p_name  LIKE " . $searchString;
            $sql .= " or pp.purchase_year  LIKE " . $searchString;
            $sql .= " or cd.activation_code  LIKE " . $searchString;
            $sql .= " or cd.serial_no  LIKE " . $searchString;
            $sql .= " or cd.lan_type  LIKE " . $searchString;
            $sql .= " or cd.total_lan  LIKE " . $searchString;
            $sql .= " or cd.reg_type  LIKE " . $searchString . ")";
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
                $status = 'Deactive';
                $icon = 'btn-outline-success ri-eye-line';
            } else {
                $stts = 'A';
                $status = 'Active';
                $icon = 'btn-outline-warning ri-eye-off-line';
            }

            $action = '';
            $action = "<li><a href='#' class='dropdown-item change-status m-1' data-url='" . $this->view_data['_controller_path'] . "change_status?table=si_clients_details' data-id='" . $row["si_clients_details_id"] . "' data-module='product' data-status='" . $stts . "'><i class='btn-sm " . $icon . "' aria-hidden='true'></i> Mark as ".$status."</a></li>";
            $action .= "<li><a href='#' data-modal='showEditProductModal' data-url='" . $this->view_data['_controller_path'] . "edit-product/" . $row["si_clients_details_id"] . "' class='dropdown-item edit-row me-1'><i class='btn-sm btn-outline-info ri-edit-line'></i> Edit</a></li>";
            $action .= "<li><a href='#' data-url='" . $this->view_data['_controller_path'] . "delete?table=si_clients_details' data-id='" . $row["si_clients_details_id"] . "' data-module='product' class='dropdown-item delete-row'><i class='btn-outline-danger btn-sm ri-delete-bin-line'></i> Delete</a></li>";
            
            $action_btn = '<div class="btn-group dropend">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu">
                    '. $action .'
                </ul>
            </div>';

            $nestedData = array();
            $nestedData[] = to_title_case($row["p_name"]);
            $nestedData[] = $row["yearname"];
            $nestedData[] = display_date($row["purchase_date"]) . '<br>'. display_date($row["renewal_date"]);
            $nestedData[] = $row["lan_type"] . ' / '. $row["total_lan"];
            $nestedData[] = '<span class="badge rounded-pill bg-'.($row["reg_type"] == 'O' ? 'success' : 'info').'">'.$this->view_data['reg_types'][$row["reg_type"]].'</span>';
            $nestedData[] = $row['serial_no'];
            $nestedData[] = $row['activation_code'];
            $nestedData[] = empty($row["attach_file"]) ? '--' : "<a href='" . base_url('assetss/upload/files/') . $row['attach_file'] . "' download>Download File</a>";
            $nestedData[] = $action_btn;
            $nestedData['DT_RowId'] = "r" . $row['si_clients_details_id'];
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
     * Display a record
     */
    function edit_product($id = 0)
    {
        $response = [
            'status' => 'fail',
            'message' => 'Record not found',
            'data' => [],
        ];

        if ($id > 0) {
            $sql = "select cd.si_clients_details_id as id,
            cd.category_id as category,
            cd.si_product_id as product,
            cd.si_conversion_product_id as conversion_product,
            cd.laptop,
            cd.reg_type,
            cd.si_for_year_id as for_year,
            cd.serial_no,
            cd.activation_code,
            cd.lan_type as srv_lan,
            cd.total_lan as srv_lan_no,
            cd.referby,
            pp.purchase_date,
            pp.renewal_date
            from si_clients_details cd
            left join si_product_purchase pp on (cd.si_clients_details_id = pp.si_clients_details_id)
            where cd.status IN ('A', 'D') AND cd.si_clients_details_id=$id";
            $result = $this->ex->query($sql);

            if (!empty($result)) {
                $response['status'] = 'success';
                $response['message'] = 'Record found';
                $response['view_title'] = 'Update Product';
                $response['form_element'] = [
                    [
                        'name' => 'category',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'product',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'conversion_product',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'laptop',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'reg_type',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'for_year',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'serial_no',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'activation_code',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'srv_lan',
                        'type' => 'select',
                    ],
                    [
                        'name' => 'srv_lan_no',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'purchase_date',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'renewal_date',
                        'type' => 'input',
                    ],
                    [
                        'name' => 'referby',
                        'type' => 'select',
                    ],
                ];
                $response['data'] = $result[0];
            }
        }
        echo json_encode($response);
    }

    /**
     * Add or Update records
     */
    function add_update_product()
    {
        // response json
        $response = [
            'status' => 'fail',
            'message' => '',
            'is_redirect' => true,
            'is_table' => false,
            'url' => trim($this->view_data['_controller_path'], '/'),
        ];

        // load libraries and helpers
        $this->load->library('form_validation');

        $id = $this->input->post('id');
        $action = ($id > 0) ? 'updated' : 'added';
        $_view_title = 'Product';

        // contact information validation
        $this->form_validation->set_rules('product', 'Product', 'trim|required');
        $this->form_validation->set_rules('serial_no', 'Serial No', 'trim|required');
        $this->form_validation->set_rules('activation_code', 'Activation Code', 'trim|required');

        if (!$this->form_validation->run()) {
            $response['message'] = validation_errors(' ', ' ');
            echo json_encode($response);
            exit;
        }

        // add client info
        $qData = [
            'si_product_id' => $this->input->post('product'),
            'si_conversion_product_id' => $this->input->post('conversion_product'),
            'laptop' => $this->input->post('laptop'),
            'category_id' => $this->input->post('category'),
            'reg_type' => $this->input->post('reg_type'),
            'si_for_year_id' => $this->input->post('for_year'),
            'serial_no' => $this->input->post('serial_no'),
            'activation_code' => $this->input->post('activation_code'),
            'lan_type' => $this->input->post('srv_lan'),
            'total_lan' => $this->input->post('srv_lan_no'),
        ];

        $response['status'] = 'success';
        $response['message'] =  "{$_view_title} has been {$action} successfully.";

        $client_detail_id = 0;
        if ($action == 'added') {
            $client_detail_id = $this->ex->add('si_clients_details', $qData);            
        } elseif ($action == 'updated') {
            $this->ex->update('si_clients_details', ["si_clients_details_id" => $this->input->post('id')], $qData);
            $client_detail_id = $this->input->post('id');
        }

        // client ID > 0 & add client product info
        if ($client_detail_id > 0 && in_array($action, ['added', 'updated'])) {
            $product = array(
                'si_clients_details_id' => $client_detail_id,
                'purchase_year' => $this->input->post('for_year'),
                'purchase_date' => date('Y-m-d', strtotime($this->input->post('purchase_date'))),
                'renewal_date' => date('Y-m-d', strtotime($this->input->post('renewal_date'))),
            );

            $this->ex->update('si_product_purchase', ["si_clients_details_id" => $client_detail_id ], $product);
        }

        echo json_encode($response);
    }
}
