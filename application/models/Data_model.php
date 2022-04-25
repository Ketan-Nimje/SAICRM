<?php

class Data_model extends CI_Model {

    function __construct() {
        parent::__construct();
        ini_set('memory_limit', '-1');
        date_default_timezone_set('Asia/Calcutta');
        $this->db->query("set global sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
        $this->db->query("set session sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
    }

    function Get_data($tbl) {
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Get_data_order($tbl, $tblcol, $type) {
        $this->db->order_by($tblcol, $type);
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Insert_data($tbl, $data) {
        $this->db->insert($tbl, $data);
        return $this->db->affected_rows();
    }

    function Insert_batch($tbl, $data) {
        $this->db->insert_batch($tbl, $data);
    }

    function Insert_data_id($tbl, $data) {
        $this->db->insert($tbl, $data);
        $query = $this->db->insert_id();
        return $query;
    }

    function Update_data($tbl, $con, $data) {
        $this->db->where($con);
        $this->db->update($tbl, $data);
        return $this->db->affected_rows();
    }

    function Update_batch($tbl, $data, $con) {
        $this->db->update_batch($tbl, $data, $con);
        return $this->db->affected_rows();
    }

    function Deleta_data($tbl, $con) {
        $this->db->where($con);
        $this->db->delete($tbl);
    }

    function Get_data_all($tbl, $con) {
        $this->db->where($con);
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Get_data_order_all($tbl, $con, $tblcol, $type) {
        $this->db->order_by($tblcol, $type);
        $this->db->where($con);
        $query = $this->db->get($tbl);
        return $query->result_array();
    }

    function Get_data_one($tbl, $con) {
        $this->db->where($con);
        $res = $this->db->get($tbl);
        $query = $res->result_array();
        if (count($query) > 0) {
            return $query[0];
        } else {
            return array();
        }
    }

    function Get_data_one_column($tbl, $con, $col) {
        $this->db->where($con);
        $this->db->select($col);
        $res = $this->db->get($tbl);
        $query = $res->result_array();
        if (count($query) > 0) {
            return $query[0];
        } else {
            return array();
        }
    }

    function Custome_query($str) {
        $query = $this->db->query($str);
        // log_message('custom', "\n --Ishawr Query Response----[ ".json_encode($str)." ] ----\n\n ");		
        return $query->result_array();
    }

    function query($str) {
        $query = $this->db->query($str);
        return $query->result();
    }

    function Custome_query_exe($str) {
        $query = $this->db->query($str);
    }

    function Custom($tbl, $con, $column) {
        $sql = "SELECT $column from $tbl WHERE $con";
        return $this->Custome_query($sql);
    }

    function change_status($id, $table) {
        $this->db->where($table . '_id', $id);
        $ans = $this->db->get($table);
        $data = $ans->result_array();
        if ($data[0]['status'] == 0)
            $info['status'] = 1;
        else
            $info['status'] = 0;
        $this->db->where($table . '_id', $id);
        $this->db->update($table, $info);
        return $info['status'];
    }

    function Process() {

        extract($_POST);
        $con = array(
            'SA', 'A', 'TL'
        );
        $username = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->where('status', 'A');
        $this->db->where_in('role', $con);
        $query = $this->db->get('si_admin');
        $res = $query->result_array();
        if (count($res) == 1) {
            $row = $query->row();
            $data = array(
                'name' => $row->name,
                'password' => $row->password,
                'id' => $row->si_admin_id,
                'role' => $row->role,
            );
            $this->session->set_tempdata('Passcode', 1, 120); /// deletes after 2 min
            $this->session->set_userdata($data);
            if (isset($rmmbr)) {
                setcookie("username", $row->username, time() + (10 * 365 * 24 * 60 * 60));
                setcookie("password", $row->password, time() + (10 * 365 * 24 * 60 * 60));
            }
            return true;
        }
        return false;
    }

    public function sentmail($email, $title, $subject, $msg) {
        $ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.googlemail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "test@test.";
        $config['smtp_pass'] = "";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $ci->email->initialize($config);

        $ci->email->from("lochawalapratik5@gmail.com", $title);
        $list = array($email);
        $ci->email->to($list);
        $ci->email->subject($subject);
        $ci->email->message($msg);
        $ci->email->send();
    }

    public function check_cust_login($username, $password) {
        $this->db->where('userkey', $username);
        $this->db->where('password', $password);
        $this->db->where('account_status', 'A');
        $query = $this->db->get('at_users');
        $res = $query->result_array();
        return $res;
    }

    public function __destruct() {
        $this->db->close();
    }

    function Validation() {
        if ($this->session->userdata('id') == NULL) {
            redirect(base_url());
        }
    }

    function CQ0($str) {
        $R = $this->db->query($str);
        return $R->result_array()[0];
    }

    function convertToIndianCurrency($number) {
        $no = round($number);
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety');
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
            } else {
                $str [] = null;
            }
        }

        $Rupees = implode(' ', array_reverse($str));
        $paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal % 10]) . " " . ($words[$decimal % 10]) : '';
        return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . " Only";
    }

}
