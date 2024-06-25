<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Karachi");
        $this->__currentdatetime = date("Y-m-d h:i:s", time());
    }

    public function login_submit($params)
    {
        return ($this->db->select('users.*')
        ->from('users')
        ->where('users.username', $params['username'])
        ->where('users.password', $params['password'])
        ->get()
        ->result_array());
    }
    
}