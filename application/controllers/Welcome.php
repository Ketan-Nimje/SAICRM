<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public $controll = "Welcome";

    public function __construct() {
        parent::__construct();
        // $this->Validation();
    }

    public function Validation() {
        if ($this->session->userdata('id') != null) {
            redirect(base_url() . 'Dashboard');
        }
    }

    public function index() {
        $this->load->view($this->controll);
    }

    public function Process() {
        extract($_POST);
        $admin = $this->Data_model->Process();

        if ($admin != null) {
            // update on 20 june 
            $singleRecords = $this->Data_model->Get_data_one(SI_ADMIN, ['si_admin_id' => $_SESSION['id']]);
            if ($singleRecords['role'] == 'SA') {
                $con = array('si_admin_id' => $_SESSION['id']);
                $data = array(
                    'update_date' => date('Y-m-d H:i:s'),
                    'ip_config' => $_SERVER['REMOTE_ADDR'],
                );
                $this->Data_model->Update_data('si_admin', $con, $data);
                if ($this->input->ip_address() == '116.72.4.36') {
                    $datasession = array(
                        'name' => $singleRecords['name'],
                        'password' => $singleRecords['password'],
                        'id' => $singleRecords['si_admin_id'],
                        'role' => $singleRecords['role'],
                        'otp' => $singleRecords['otp'],
                        'validated' => true,
                    );
                    $this->session->set_userdata($datasession);
                    redirect(base_url() . 'Admin/AdminDashboard');
                }
            } else {
                $con = array('si_admin_id' => $_SESSION['id']);
                $data = array(
                    'update_date' => date('Y-m-d H:i:s'),
                    'ip_config' => $_SERVER['REMOTE_ADDR'],
                );
                $this->Data_model->Update_data('si_admin', $con, $data);
                if ($this->input->ip_address() == '116.72.4.36') {
                    $datasession = array(
                        'name' => $singleRecords['name'],
                        'password' => $singleRecords['password'],
                        'id' => $singleRecords['si_admin_id'],
                        'role' => $singleRecords['role'],
                        'otp' => $singleRecords['otp'],
                        'validated' => true,
                    );
                    $this->session->set_userdata($datasession);
                    redirect(base_url() . 'Dashboard');
                }
            }
            $ui = $_SESSION['name'];
            $otp = rand(10000, 99999);
            $data = array(
                'otp' => $otp,
                'ip_config' => $this->input->ip_address(),
            );
            $this->db->where('name', $ui);
            $this->db->update('si_admin', $data);
            $sql = 'SELECT mobilenumber FROM si_userlogin_notification_number where is_delete = "N" ';
            $num = $this->Data_model->Custome_query($sql);
            $mobilenumber = array_column($num, 'mobilenumber');
            $mobilenumber = implode(",", $mobilenumber);
            $m = $mobilenumber;
            $smscon = 'Hi ' . $_SESSION['name'] . ' Your Saicrm otp is ' . $otp . ' ip :' . $this->input->ip_address() . ' Thanks & Regards SAI Infotech, Surat.';
            $user = "geniussurat";
            $api_key = "6068391a-5b01-42b3-b449-20f3524b0b68"; //will get from system
            $baseurl = "http://sms.hspsms.com";
            $message = urlencode($smscon);
            $to = $m;
            $sender = "GENIOS";
            $url = "$baseurl/sendSMS?username=$user&message=$message&sendername=$sender&smstype=TRANS&numbers=$to&apikey=$api_key";

            $this->session->unset_userdata(['error', 'errorcls']);
            $this->session->set_userdata('page', '0');
            $this->session->set_userdata('otp', $otp);
            $this->session->set_userdata('validated', true);
            if ($_SESSION['role'] == 'SA') {
                redirect(base_url() . 'Admin/AdminDashboard');
            } else {
                redirect(base_url() . 'Dashboard');
            }
//            redirect(base_url() . 'Uotp');
        } else {
            $sessdata = array('error' => "<strong>Error!</strong> Invalid Username or Password", 'errorcls' => "alert-danger");
            $this->session->set_userdata($sessdata);
            redirect(base_url());
        }
    }

}
