<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('Auth_model', 'auth_model');
    }

    public function index() {
        auth_check();
        redirect(base_url('dashboard'), 'refresh');
    }

    //--------------------------------------------------------------
    public function login() {

        if ($this->input->post('submit')) {

            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() == FALSE) {
                $data = array(
                    'errors' => validation_errors()
                );
                $this->session->set_flashdata('error', $data['errors']);
                redirect(base_url('auth/login'));
            } else {
                $data = array(
                    'username' => $this->input->post('username'),
                    'password' => $this->input->post('password')
                );
                $result = $this->auth_model->login($data);

                if ($result) {
                    if ($result['status'] != 'A') {
                        $this->session->set_flashdata('error', 'This username "' . $data['username'] . '" account has been disabled by Admin!');
                        redirect(base_url('auth/login'));
                        exit();
                    }
                    $result['is_admin_login'] = true;
                    $this->session->set_userdata($result);
                    redirect(base_url('dashboard'), 'refresh');
                } else {
                    $this->session->set_flashdata('login_username', $data['username']);
                    $this->session->set_flashdata('error', 'Invalid Username or Password!');
                    redirect(base_url('auth/login'));
                }
            }
        } else {
            $data['_view_title'] = 'Sign In | Saiinfotech - Admin';
            $data['navbar'] = true;
            $data['sidebar'] = true;
            $data['footer'] = true;

            // $this->load->view('layouts/template/header', $data);
            $this->load->view('auth/login', $data);
            // $this->load->view('layouts/template/footer', $data);
        }
    }

    //-----------------------------------------------------------------------
    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url('auth/login'), 'refresh');
    }

}

// end class
?>