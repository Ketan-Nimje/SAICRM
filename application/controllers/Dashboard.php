<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

        public function __construct()
        {
                parent::__construct();
                auth_check(); // check login auth
                $this->module_folder = $this->uri->segment(1);
                $this->view_data['_controller_path'] = base_url() . $this->module_folder . '/';
                $this->load->model('Dashboard_model');
        }

        public function index()
        {
                $this->view_data['_view_title'] = 'Dashboard';

                $this->view_data['_dash_contact'] = $this->Dashboard_model->get_records_count("contact_us");
                $this->view_data['_dash_quick'] = $this->Dashboard_model->get_records_count("si_quick_inquiry");
                $this->view_data['_dash_pi'] = $this->Dashboard_model->get_records_count("sai_pi");
                $this->view_data['_dash_product'] = $this->Dashboard_model->get_records_count("product", ["is_delete" => 'N', "is_status" => 'A']);
                // $this->view_data['category'] = $this->Dashboard_model->get_records_count('sai_category');
                $this->load->view('dashboard', $this->view_data);
        }

        public function changePassword()
        {
                if ($this->input->post('submit')) {
                        // response json
                        $response = [
                                'status' => 'fail',
                                'message' => '',
                                'is_redirect' => true,
                                'url' => base_url('logout'),
                        ];

                        // load libraries and helpers
                        $this->load->library('form_validation');

                        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
                        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

                        if (!$this->form_validation->run()) {
                                $response['message'] = validation_errors(' ', ' ');
                                echo json_encode($response);
                                exit;
                        }

                        if ($this->input->post('old_password') != $this->session->userdata('password')) {
                                $response['message'] = 'Invalid Old Password.';
                                echo json_encode($response);
                                exit;
                        }

                        // get data
                        $qData = [
                                'password' => $this->input->post('new_password'),
                        ];

                        $response['status'] = 'success';
                        $response['message'] =  "Password has been changed successfully.";

                        $this->Dashboard_model->update('sai_admin', ["sai_admin_id" => $this->session->userdata('sai_admin_id')], $qData);

                        echo json_encode($response);
                } else {
                        $this->view_data['_breadcrumb_heading'] = 'Dashboard';
                        $this->view_data['_view_title'] = 'Change Password';

                        // $this->load->view('layouts/template/header', $data);
                        $this->load->view('change-password', $this->view_data);
                }
        }
}
