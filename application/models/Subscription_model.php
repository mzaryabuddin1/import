<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscription_model extends CI_Model
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

    public function get_project_via_customer_subscription($customer, $subscription) {
        return $this->db->select('*')->from('projects')->where('stripe_customer_id', $customer)->where('stripe_subscription', $subscription)->get()->row_array();
    }

    public function update_project_balance($update, $customer, $subscription) {
        $sql = 'UPDATE `projects` SET `email_balance`='. $update['email_balance'] .',`call_balance`='. $update['call_balance'] .',`sms_balance`='. $update['sms_balance'] .',`no_of_agents`='. $update['no_of_agents'] .' WHERE `stripe_customer_id` = "'.$customer.'" AND `stripe_subscription` = "'.$subscription.'" AND `id` = "'.$update['id'].'" ';
        return $this->db->query($sql);
    }

    public function update_project_sell_log($sell_log) {
        return $this->db->insert('packages_sell_logs', $sell_log);
    }

    
    public function subscribed_user_check($subscription) {
        return $this->db->select('*')->from('projects')->where('stripe_subscription', $subscription)->get()->num_rows();
    }
}
