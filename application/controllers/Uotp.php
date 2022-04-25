<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uotp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->Validation();
    }

    public function Validation() {
        if ($this->session->userdata('id') == NULL) {
            redirect(base_url());
        }
    }

    public function timeout() {
        date_default_timezone_set('Asia/Kolkata');
        $in = $_SESSION['ins'] = 900;
        if (!isset($_SESSION['timeout']))
            $_SESSION['timeout'] = time() + $in;
        $session_life = time() - $_SESSION['timeout'];

        if ($session_life > $in) {
            session_destroy();
            redirect(base_url());
        }
        $_SESSION['timeout'] = time();
    }

    public function index() {


        if (($_SESSION['otp'] ?? "") == true) {
            $d = $this->timeout();
            $this->load->view('uotp', $d);
        } else {
            $this->session->set_userdata(['error' => 'OTP Invalid']);
            $this->load->view('uotp');
        }
    }

    public function Process() {
        extract($_POST);
        if ($_SESSION['name'] != null) {
            $otppsw = $this->security->xss_clean($this->input->post('uotp'));
            $squ_user = "select * from si_admin where si_admin_id='" . $_SESSION['id'] . "' and otp like '" . $otppsw . "'";
            $qry = $this->Data_model->Custome_query($squ_user);
            if ($qry[0]['role'] == 'SA') {
                $con = array('si_admin_id' => $_SESSION['id']);
                $data = array(
                    'update_date' => date('Y-m-d H:i:s'),
                    'ip_config' => $_SERVER['REMOTE_ADDR'],
                );
                $this->Data_model->Update_data('si_admin', $con, $data);
                $datasession = array(
                    'name' => $qry[0]['name'],
                    'password' => $qry[0]['password'],
                    'id' => $qry[0]['si_admin_id'],
                    'role' => $qry[0]['role'],
                    'otp' => $qry[0]['otp'],
                    'validated' => true,
                );
                $this->session->set_userdata($datasession);
                redirect(base_url() . 'Admin/AdminDashboard');
            } else {
                $con = array('si_admin_id' => $_SESSION['id']);
                $data = array(
                    'update_date' => date('Y-m-d H:i:s'),
                    'ip_config' => $_SERVER['REMOTE_ADDR'],
                );
                $datasession = array(
                    'name' => $qry[0]['name'],
                    'password' => $qry[0]['password'],
                    'id' => $qry[0]['si_admin_id'],
                    'role' => $qry[0]['role'],
                    'otp' => $qry[0]['otp'],
                    'validated' => true,
                );
                $this->session->set_userdata($datasession);
                $this->Data_model->Update_data('si_admin', $con, $data);
                redirect(base_url() . 'Dashboard');
            }
        } else {
            $sessdata = array('error' => "<strong>Error!</strong> Invalid opt Enter", 'errorcls' => "alert-danger");
            $this->session->set_userdata($sessdata);
            redirect(base_url() . 'helper/logout');
        }
    }

}
