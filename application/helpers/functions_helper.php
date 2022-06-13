<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


// -----------------------------------------------------------------------------
//check auth
if (!function_exists('auth_check')) {

    function auth_check() {
        // Get a reference to the controller object
        $ci = &get_instance();
        if (!$ci->session->has_userdata('id')) {
            redirect(base_url(), 'refresh');
        }
    }

}

// Check if the function does not exists
if (!function_exists('url_slug')) {

    // Slug a string
    function url_slug($string) {
        // Get an instance of $this
        $CI = &get_instance();

        $CI->load->helper('text');
        $CI->load->helper('url');

        // Replace unsupported characters (add your owns if necessary)
        $string = str_replace("'", '-', $string);
        $string = str_replace(".", '-', $string);
        $string = str_replace("²", '2', $string);

        // Slug and return the string
        return url_title(convert_accented_characters($string), 'dash', true);
    }

}

//convert db insert datetime
if (!function_exists('db_datetime')) {

    function db_datetime($user_datetime) {
        return date('Y-m-d H:i:s', strtotime($user_datetime));
    }

}

//convert db insert date
if (!function_exists('db_date')) {

    function db_date($user_date) {
        return date('Y-m-d', strtotime($user_date));
    }

}

//convert db insert datetime
if (!function_exists('display_datetime')) {

    function display_datetime($udatetime) {
        if ($udatetime != '' && $udatetime != '0000-00-00 00:00:00') {
            return date('d M Y h:i A', strtotime($udatetime));
        } else {
            return "-";
        }
    }

}

//convert db insert date
if (!function_exists('display_date')) {

    function display_date($udate) {
        if ($udate != '' && $udate != '0000-00-00') {
            return date('d M Y', strtotime($udate));
        } else {
            return "-";
        }
    }

}

// get header counts
if (!function_exists('get_header_counts')) {

    function get_header_counts() {
        $ci = &get_instance();
        $ci->load->model('Dashboard_model');
        $data = [];

//        $data['contact'] = $ci->Dashboard_model->get_records("contact_us", ['read_status' => 'U'], 100);
//        $data['quick'] = $ci->Dashboard_model->get_records("si_quick_inquiry", ['read_status' => 'U'], 100);
//        $data['pi'] = $ci->Dashboard_model->get_records("sai_pi", ["read_status" => 'U'], 100);
//        $data['down_inq'] = $ci->Dashboard_model->get_records("sai_download_inquiry", ['read_status' => 'U'], 100);

        return $data;
    }

}

// title case 
if (!function_exists('to_title_case')) {

    function to_title_case($string) {
        return ucwords(strtolower($string));
    }

}

// read more and less 
if (!function_exists('to_read_more')) {

    function to_read_more($string) {
        return ucfirst(strtolower(strlen($string) > 50 ? substr($string, 0, 50) . "..." : $string));
    }

}

//get active and inactive status
if (!function_exists('get_status')) {

    function get_status($status) {
        if ($status == 'A') {
            return 'Active';
        } else {
            return "Deactive";
        }
    }

}

//get active and inactive status
if (!function_exists('get_inquiry_status')) {

    function get_inquiry_status($status) {
        if ($status == 'P') {
            $action = "Pending";
        } else if ($status == 'R') {
            $action = "Running";
        } else {
            $action = "Completed";
        }
        return $action;
    }

}

// file upload code
if (!function_exists('move_file')) {

    function move_file($post_name = 'image', $path_name = 'image', $new_name = 'image') {
        $ci = &get_instance();

        $ci->load->library('upload');
        $path = $_FILES['image']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $config['upload_path'] = FCPATH . '/assets/Uploads/' . $path_name;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '1024000'; // Can be set to particular file size , here it is 1 MB(1024 Kb)
        $config['file_name'] = strtolower($new_name) . "_" . time() . "." . $ext;

        $ci->upload->initialize($config);
        if (!$ci->upload->do_upload($post_name)) {
            return array('status' => 'fail', 'message' => $ci->upload->display_errors(' ', ' '));
        } else {
            $data = $ci->upload->data();
            return array('status' => 'success', 'message' => $data['file_name']);
        }
    }

}
