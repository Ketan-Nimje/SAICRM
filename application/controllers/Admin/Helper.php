<?php

/**
 * Created by PhpStorm.
 * User: prati
 * Date: 9/24/2017
 * Time: 8:01 PM
 */
class Helper extends CI_Controller{
	
    public function __construct(){
        parent::__construct();
    }
	
    public function GetEditData(){
        extract($_POST);
        $con = array($tbl . '_id' => $id);
        $data = $this->Data_model->Get_data_one($tbl, $con);
        echo json_encode($data);
    }
	
	public function Logout(){
        $data = array(
                'name' =>NULL,
                'password' => NULL,
                'id' =>NULL,
                'role' =>NULL,
                'otp'=>NULL,
                'validated' => true,              
                );            
        $this->session->set_userdata($data);
        session_destroy();
        unset($_SESSION);
        unset($_COOKIE);
        redirect(base_url());
    }

}