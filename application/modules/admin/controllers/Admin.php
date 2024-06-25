<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/PHPmailer/src/Exception.php';
// require $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/PHPmailer/src/PHPMailer.php';
// require $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/PHPmailer/src/SMTP.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

class Admin extends MX_Controller {

	private $data;
	private $allowed_extensions;

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set("Asia/Karachi");
		$this->load->model('Admin_model');
		$this->allowed_extensions = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'docx', 'pdf', 'webp');
		$this->__currentdatetime = date("Y-m-d H:i:s", time());

		require_once($_SERVER["DOCUMENT_ROOT"] . '/application/libraries/stripe-php-master/init.php');
	}

	public function checksession()
	{
		if (empty($_SESSION['admin_id'])) {
			header("Location: " . base_url() . 'admin-login?msg=Please Login First');
			exit;
		}
	}

	

}
