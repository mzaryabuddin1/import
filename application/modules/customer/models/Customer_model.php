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
        ->where('users.is_delete', 0)
        ->get()
        ->result_array());
    }

    public function get_user($params){
        $res = $this->db->select('users.*')
        ->from('users')
        ->where('users.id', $params)
        ->get()
        ->row_array();
        $_SESSION['customer_modules'] = isset($res['modules']) ? json_decode($res['modules'], true) : [] ;
        return $res;
    }

    public function get_all_users(){
        return ($this->db->select('users.*')
        ->from('users')
        ->where('is_delete', 0)
        ->get()
        ->result_array());
    }

    public function add_user_submit($params){
        return ($this->db->insert('users', $params));
    }

    public function edit_user_submit($params) {
        $this->db->where('id', $params['id']);
        return $this->db->update('users', $params);
    }

    public function delete_user_submit($params) {
        $this->db->where('id', $params['id']);
        return $this->db->update('users', $params);
    }

    public function get_all_stock(){
        return ($this->db->select('stock.*')
        ->from('stock')
        ->get()
        ->result_array());
    }

    public function get_hscode(){
        return ($this->db->select('HScodes.*')
        ->from('HScodes')
        ->get()
        ->result_array());
    }
    
}
