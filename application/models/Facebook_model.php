<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Facebook_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Karachi");
        $this->__currentdatetime = date("Y-m-d h:i:s", time());
    }

    public function saveSubscription($subscriptionId, $customerId) {
        // Save subscription details in your database
        // You may want to store $subscriptionId and $customerId in your database
        // for future reference or for linking the subscription to a user in your system

        // return $this->db->insert('email_log', $params);

        $filename = 'subscriptions.txt';

        $data = "Subscription ID: $subscriptionId, Customer ID: $customerId\n";

        // Use the FILE_APPEND flag to append to the file if it already exists
        file_put_contents($filename, $data, FILE_APPEND);


    }

    public function get_package_via_prod_price($price, $product) {
        return $this->db->select('*')->from('packages')->where('stripe_price_id', $price)->where('stripe_product_id', $product)->get()->row_array();
    }

    public function get_projects() {
        return $this->db->select('*')->from('projects')->where('facebook_access_token IS NOT NULL')->where('token_expire_date >=', $this->__currentdatetime)->get()->result_array();
    }

    public function get_customer_via_email($email) {
        return $this->db->select('*')->from('customers_users')->where('email', $email)->get()->row_array();
    }

    public function update_project_balance($update, $customer, $subscription) {
        $sql = 'UPDATE `projects` SET `email_balance`='. $update['email_balance'] .',`call_balance`='. $update['call_balance'] .',`sms_balance`='. $update['sms_balance'] .',`no_of_agents`='. $update['no_of_agents'] .' WHERE `stripe_customer_id` = "'.$customer.'" AND `stripe_subscription` = "'.$subscription.'" AND `id` = "'.$update['id'].'" ';
        return $this->db->query($sql);
    }

    public function update_project_sell_log($sell_log) {
        return $this->db->insert('packages_sell_logs', $sell_log);
    }

    public function insert_leads($insert) {
        return $this->db->insert_batch('leads', $insert);
    }

    public function subscribed_user_check($subscription) {
        return $this->db->select('*')->from('projects')->where('stripe_subscription', $subscription)->get()->num_rows();
    }

    public function get_form_ids($projects) {
        $projectIds = array_column($projects, 'id');
        return $this->db->select('project_id, form_id')->from('facebook_form_ids')->where_in('project_id', $projectIds)->where('status', 1)->get()->result_array();
    }

    public function get_leads_via_form_id($form_id) {
        return $this->db->select('facebook_lead_id')->from('leads')->where('facebook_form_id', $form_id)->get()->result_array();
    }
}
