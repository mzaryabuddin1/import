<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Karachi");
        $this->__currentdatetime = date("Y-m-d h:i:s", time());
    }

    public function application_configs(){
        // echo "HY";
    }

    public function login_submit($params){
        return ($this->db->select('`id`, `status`, username, email')->from('admin_users')->where('email', $params['email'])->where('password', $params['password'])->get()->result_array());

    }


}