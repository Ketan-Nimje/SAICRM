<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    public $tbl = "si_clients";
    public $controll = "Client";
    private $clientdetailtbl = "si_clients_details";

    public function __construct() {
        parent::__construct();  $this->Data_model->Validation();
    }

    public function index() {
        $data['product'] = $this->Data_model->Custome_query("select * from si_product where status like 'A'");
        $data['for_year'] = $this->Data_model->Custome_query("select * from si_for_year where status like 'A'");
        $data['gstkey'] = $this->Data_model->Custome_query("select * from si_gstkey where status like 'A'");
        $data['states'] = $this->Data_model->Custome_query("select * from si_state where status like 'A'");
        $data['admin'] = $this->Data_model->Custome_query("select name from si_admin where status='A'");
        $this->load->view('Admin/' . $this->controll, $data);
    }

    public function addData() {
        extract($_REQUEST);
        if (!isset($_REQUEST) || empty($_REQUEST)) {
            redirect(base_url() . 'Admin/' . $this->controll . '');
        }
        if ($hid == '' || $hid == 0) {
            if (empty($si_product_id) || $si_product_id[0] == 0) {
                $sessdata = array('error' => '<strong>Error!</strong> Product Not Selected.', 'errorcls' => 'alert-danger');
                $this->session->set_flashdata($sessdata);
                redirect(base_url() . 'Admin/' . $this->controll . '');
            }
        }

        $data = array(
            'contact_person' => $contact_person,
            'firm_name' => $firm_name,
            'address' => $address,
            'address1' => $address1,
            'area' => $area,
            'si_state_id' => $si_state_id,
            'city' => $city,
            'pincode' => $pincode,
            'registed_mobile' => $registed_mobile,
            'register_email' => $register_email,
            'mobile1' => $mobile1,
            'mobile2' => $mobile2,
            'mobile3' => $mobile3,
            'phone1' => $phone1,
            'phone2' => $phone2,
            'gstin_no' => $gstin_no,
            'created_at' => date('Y-m-d H:s:i'),
            'updated_at' => date('Y-m-d H:s:i')
        );
        if (isset($hid) && $hid != "") {
            $con = array($this->tbl . '_id' => $hid);
            $clients_id = $this->Data_model->Update_data($this->tbl, $con, $data);
            $clients_id = $this->Data_model->Update_data('si_clients_details',$con,['p_email'=>$register_email]);
            $sessdata = array('error' => '<strong>Success!</strong> Update Client.', 'errorcls' => 'alert-success');
        } else {
            $clients_id = $this->Data_model->Insert_data_id($this->tbl, $data);
            $sessdata = ['error' => '<strong>Success!</strong> Add New Client.', 'errorcls' => 'alert-success'];
        }

        if ($hid == "" || $hid == 0) {
            $hid = $clients_id;
        }
        $p_items = [];

        for ($i = 0; $i < count($si_product_id); $i++) {
            if (!empty($si_gstkey_id[$i])) {
                $gstkeyid = $this->add_gst_id($si_gstkey_id[$i]);
            } else {
                $gstkeyid = 0;
            }
            if ($category_id[$i] == 1):
                $p_items = array(
                    'si_clients_id' => $hid,
                    'si_product_id' => $si_product_id[$i],
                    'si_conversion_product_id' => $si_conversion_product_id[$i],
                    'laptop' => $laptop[$i],
                    'category_id' => $category_id[$i],
                    'reg_type' => $reg_type[$i],
                    'si_for_year_id' => $si_for_year_id[$i],
                    'serial_no' => $serial_no[$i],
                    'activation_code' => $activation_code[$i],
                    'lan_type' => $s_pc[$i],
                    'total_lan' => $total_lan[$i],
                    'si_gstkey_id' => $gstkeyid,
                    'referby' => $referby,
                    'created_at' => date('Y-m-d H:s:i'),
                    'updated_at' => date('Y-m-d H:s:i')
                );

            endif;
        }

        if (!empty($p_items)) {
            $p_id = $this->Data_model->Insert_data_id('si_clients_details', $p_items);
            for ($j = 0; $j < count($si_for_year_id); $j++) {
                $product = array(
                    'si_clients_details_id' => $p_id,
                    'purchase_year' => $si_for_year_id[$j],
                    'purchase_date' => date('Y-m-d', strtotime($purchase_date[$j])),
                    'renewal_date' => date('Y-m-d', strtotime($last_renewal_date[$j])),
                    'created_at' => date('Y-m-d H:s:i'),
                    'updated_at' => date('Y-m-d H:s:i')
                );
            }
            if (!empty($product)) {
                $purchase_id = $this->Data_model->Insert_data_id('si_product_purchase', $product);
            }
        }
        $this->session->set_flashdata($sessdata);
        redirect(base_url() . 'Admin/' . $this->controll . '');
    }

    public function add_gst_id($gstkey) {
        $gstdata = [];
        $gstdata = array(
            "gstkey" => $gstkey,
            "status" => "U"
        );
        $gstinsertid = $this->Data_model->Insert_data_id('si_gstkey', $gstdata);
        return $gstinsertid;
    }

    public function get_client_product_by_id() {
        extract($_REQUEST);
        $data['product_detail'] = $this->Data_model->Custome_query("select * from si_clients_details where si_clients_id = " . $si_clients_id . " and status like 'A'");
        echo json_encode($data);
    }

    public function edit_client_product_detail_by_id() {
        extract($_REQUEST);
        $data["productdetails"] = $this->Data_model->Custome_query("select *,date_format(p.purchase_date,'%d/%m/%Y') as purchase_date,date_format(renewal_date,'%d/%m/%Y') as renewal_date from si_clients_details as c left join si_product_purchase as p on p.si_clients_details_id=c.si_clients_details_id left join si_gstkey as g on g.si_gstkey_id=c.si_gstkey_id where c.si_clients_details_id = " . $id . " and c.status like 'A'");
        echo json_encode($data);
    }

    public function update_client_product_detail_by_id() {
        extract($_REQUEST);

        if ($edit_si_gstkey_id != "" || $edit_si_gstkey_id != NULL) {
            $gstkeyid = $this->Data_model->Get_data_one('si_gstkey', ['gstkey' => $edit_si_gstkey_id]);
            if (empty($gstkeyid)) {
                $edit_gstkeyid = $this->add_gst_id($edit_si_gstkey_id);
            } else {
                $edit_gstkeyid = $gstkeyid['gstkey'];
            }
        } else {
            $edit_gstkeyid = 0;
        }

        $p_item = array(           
            'laptop' => $edit_laptop,
            'category_id' => $edit_category_id,
			'si_product_id' => $edit_si_product_id,
            'reg_type' => $edit_reg_type,
            'si_for_year_id' => $edit_si_for_year_id,
            'serial_no' => $edit_searial_no,
            'activation_code' => $edit_activation_code,
            'lan_type' => $edit_s_pc,
            'total_lan' => $edit_total_lan,
            'si_gstkey_id' => $edit_gstkeyid,
            'updated_at' => date('Y-m-d H:s:i')
        );

        $productpurchasedetail = array(
            'si_clients_details_id' => $productid,
            'purchase_year' => $edit_si_for_year_id,
            'purchase_date' => date('Y-m-d', strtotime($edit_purchase_date)),
            'renewal_date' => date('Y-m-d', strtotime($edit_last_renewal_date)),
        );

        $con = ['si_clients_details' => $productid];
        if ($productid == 0 || $productid == "") {
            //insert Product
        } else {
            //update Product
            $con = ['si_clients_details_id' => $productid];
            $this->Data_model->Update_data('si_clients_details', $con, $p_item);


            $prchid = $this->Data_model->Custome_query('select si_clients_details_id from si_product_purchase where si_clients_details_id="' . $productid . '" and status="A"');
            if (!empty($prchid)) {
                $this->Data_model->Update_data('si_product_purchase', $con, $productpurchasedetail);
            } else {
                $purchase_id = $this->Data_model->Insert_data_id('si_product_purchase', $productpurchasedetail);
            }
            echo "success";
        }
    }

    public function get_client_all_product() {
        extract($_REQUEST);
        $requestData = $_REQUEST;
        $columns = array(
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
		/*$Convertion="SELECT si_conversion_product_id as p_id FROM `si_clients_details` WHERE si_clients_id = ".$id;
        $convertionquery = $this->Data_model->Custome_query($Convertion);
        if($convertionquery[0]['p_id']!= 0)
            $c_pid="inner join si_product as p on p.si_product_id=cd.si_conversion_product_id";
        else*/
            $c_pid="inner join si_product as p on p.si_product_id=cd.si_product_id";
        $sql = "select cd.si_clients_details_id as si_clients_details_id,cd.si_conversion_product_id,fy.yearname as foryear, p.p_name as productname, pp.purchase_year as purchyear,pp.purchase_date as purchasedate,pp.renewal_date as renewdate,cd.activation_code as activationcode,cd.serial_no as serialno,cd.lan_type as lantype,cd.total_lan as lantotal,cd.reg_type as regtype,cd.status as status,cd.attach_file
				 from " . $this->clientdetailtbl . " as cd 
				".$c_pid."
				left join si_product_purchase as pp on pp.si_clients_details_id=cd.si_clients_details_id
				left join si_for_year as fy on pp.purchase_year=fy.si_for_year_id
				where cd.si_clients_id='" . $id . "' and cd.status!='B' group by p.p_name,cd.serial_no";


        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( cd." . $this->clientdetailtbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR p.p_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR fy.yearname LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR pp.renewal_date LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR pp.purchase_date LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.activation_code LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.serial_no LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.reg_type LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR cd.total_lan LIKE '" . $requestData['search']['value'] . "%' ) ";
        }

        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";  // adding length

        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;
        foreach ($query as $dt) {
            $nestedData = array();
            if ($dt['status'] == "A"):
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            endif;
            $edit = "<a class='edit small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-target='#productadd' data-toggle='modal'><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-pencil fa-stack-1x fa-inverse'></i></span></button></a>";
            $dlt = "<a class='dlt small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";
            $st = $dt['attach_file'] != "" ? "Y" : "N";

            $file = $dt['attach_file'] != "" ? "<a href='" . base_url('assetss/upload/files/') . $dt['attach_file'] . "' download>Download File</a>" : "Not Yet Attached!";

            if ($dt['lantype'] == 0) {
                $lantype = "Decl Without Srv";
                $attach = "<a class='attach small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-status='" . $st . "'><button class='btn btn-xs btn-primary'><span class='fa-stack'><i class='fa fa-files-o fa-stack-1x fa-inverse'></i></span></button></a>";
            } else if ($dt['lantype'] == 1) {
                $lantype = "Decl With Srv";
                $attach = "<a class='attach small-btn' data-id='" . $dt[$this->clientdetailtbl . '_id'] . "' data-status='" . $st . "'><button class='btn btn-xs btn-primary'><span class='fa-stack'><i class='fa fa-files-o fa-stack-1x fa-inverse'></i></span></button></a>";
            } else if ($dt['lantype'] == 2) {
                $lantype = "Lan";
                $file = "-";
                $attach = "";
            }
			if ($dt['si_conversion_product_id'] != 0):
                $sql_p= "Select p.p_name from si_clients_details as cd inner join si_product as p on p.si_product_id=cd.si_conversion_product_id where serial_no like '".$dt['serialno']."'";
             $p_nm = $this->Data_model->Custome_query($sql_p);
             $dt['productname']=$p_nm[0]['p_name'];    
            endif; 
            $nestedData[] = $cnt++;
            $nestedData[] = $dt['productname'];
            $nestedData[] = $dt['foryear'];
            $nestedData[] = $dt['activationcode'];
            $nestedData[] = $dt['serialno'];
            $nestedData[] = date('d-m-Y', strtotime($dt['purchasedate']));
            $nestedData[] = date('d-m-Y', strtotime($dt['renewdate']));
            $nestedData[] = $lantype;
            $nestedData[] = $dt['lantotal'];
            $nestedData[] = $dt['regtype'] == "O" ? $dt['regtype'] = "Online" : $dt['regtype'] = "H Lock";
            $nestedData[] = $file;
            $nestedData[] = $sts . "&nbsp" . $edit . "&nbsp" . $dlt . "&nbsp" . $attach;
            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function GetData() {
        $requestData = $_REQUEST;
        $columns = array(
            0 => $this->tbl . '_id',
            1 => 'contact_person',
            2 => 'firm_name',
            3 => 'registed_mobile',
            4 => 'register_email',
            5 => 'pincode',
            6 => 'address',
            7 => 'city',
            8 => 'status',
            9 => 'created_at',
            10 => $this->tbl . '_id',
        );

        $sql = "select * from " . $this->tbl . " where status!='B'";
        $query = $this->Data_model->Custome_query($sql);
        $totalData = count($query);
        $totalFiltered = $totalData;

        if (!empty($requestData['search']['value'])) {
            $sql .= " AND ( " . $this->tbl . "_id LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR contact_person LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR firm_name LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR registed_mobile LIKE '" . $requestData['search']['value'] . "%'";
            $sql .= " OR  register_email LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR pincode LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR address LIKE '" . $requestData['search']['value'] . "%' ";
            $sql .= " OR city LIKE '" . $requestData['search']['value'] . "%' ) ";
            //$sql .= " OR created_at LIKE '" . $requestData['search']['value'] . "%' )";            
        } else {
            $c = count($columns);
            for ($i = 0; $i < $c; $i++) {

                if (!empty($requestData['columns'][$i]['search']['value'])) {
                    $sql .= " AND " . $columns[$i] . " LIKE '%" . $requestData['columns'][$i]['search']['value'] . "%'  ";
                }
            }
        }
        $query = $this->Data_model->Custome_query($sql);
        $totalFiltered = count($query);
        if ($requestData['length'] != '-1')
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "   LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";        
        else
            $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'];
        $query = $this->Data_model->Custome_query($sql);

        $data = array();
        $cnt = $requestData['start'] + 1;


        foreach ($query as $dt) {
            $nestedData = array();
            if ($dt['status'] == "A"):
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='D' ><button class='btn btn-xs btn-success'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            else:
                $sts = "<a class='status small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='A' ><button class='btn btn-xs btn-default'><span class='fa-stack'><i class='fa fa-flag fa-stack-1x fa-inverse'></i></span></button></a>";
            endif;
            $edit = "<a class='edit small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='" . $dt['status'] . "' ><button class='btn btn-xs btn-info'><span class='fa-stack'><i class='fa fa-plus fa-stack-1x fa-inverse'></i></span></button></a>";
            $delete = "<a class='delete small-btn' data-id='" . $dt[$this->tbl . '_id'] . "' data-status='B' data-isstatus='" . $dt['status'] . "' ><button class='btn btn-xs btn-danger'><span class='fa-stack'><i class='fa fa-trash-o fa-stack-1x fa-inverse'></i></span></button></a>";

            $nestedData[] = $cnt++;
            $nestedData[] = $dt['contact_person'];
            $nestedData[] = $dt['firm_name'];
            //$nestedData[] = $dt['address'];
            //$nestedData[] = $dt['city'];
            //$nestedData[] = $dt['pincode'];
            $nestedData[] = $dt['registed_mobile'];
            $nestedData[] = $dt['register_email'];
            //$nestedData[] = $dt['created_at'];
            $nestedData[] = $sts . "&nbsp" . $edit . "&nbsp" . $delete;
            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => intval($requestData['draw']),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function get_client_edit_data() {
        extract($_POST);
        $con = array($tbl . '_id' => $id);
        $data['contact'] = $this->Data_model->Get_data_one($tbl, $con);
		$Convertion="SELECT si_conversion_product_id as p_id FROM `si_clients_details` WHERE si_clients_id = ".$id;
        $convertionquery = $this->Data_model->Custome_query($Convertion);
        if($convertionquery[0]['p_id']!= 0)
            $c_pid="inner join si_product as dp on dp.si_product_id=dc.si_conversion_product_id";
        else
            $c_pid="inner join si_product as dp on dp.si_product_id=dc.si_product_id";
        $data['product'] = $this->Data_model->Custome_query("select dc.si_product_id,dp.p_name from si_clients_details dc ".$c_pid." where dc.si_clients_id=" . $id . " AND dc.status like 'A'");
        echo json_encode($data);
    }

    public function get_conversion_data() {
        extract($_POST);
		$sql = '';
		if(isset($category_id) && $category_id==1) {
		$sql = " AND category_id=".$category_id."";
		}
        if (isset($all_p) && $all_p == "All")
            $data['product'] = $this->Data_model->Custome_query("SELECT * FROM `si_product` WHERE status like 'A' $sql");
        else
            $data['product'] = $this->Data_model->Custome_query("SELECT * FROM `si_product` WHERE `is_conversion_id` = 1 AND status like 'A' $sql");
        echo json_encode($data);
    }

    function file_upload() {
        extract($_REQUEST);

        if (isset($_FILES["image_file"]["name"])) {
            $config['upload_path'] = './assetss/upload/files';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image_file')) {
                echo $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                $filename = $data["file_name"];
//                echo '<img src="'.base_url().'upload/'.$data["file_name"].'" width="300" height="225" class="img-thumbnail" />';
                $con = array($tbl . '_id' => $id);
                $datas = [
                    'attach_file' => $filename
                ];
                $d = $this->Data_model->Update_data('si_clients_details', $con, $datas);
                if ($d > 0) {
                    echo 1;
                } else {
                    echo 0;
                }
            }
        }
    }

}

?>