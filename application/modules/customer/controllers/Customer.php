<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/PHPmailer/src/Exception.php';
// require $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/PHPmailer/src/PHPMailer.php';
// require $_SERVER["DOCUMENT_ROOT"] . '/application/third_party/PHPmailer/src/SMTP.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;


class Customer extends MX_Controller
{

	private $data;
	private $allowed_extensions;

	function __construct()
	{
		parent::__construct();

		date_default_timezone_set("Asia/Karachi");
		$this->load->model('Customer_model');
		$this->allowed_extensions = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'docx', 'pdf', 'webp');
		$this->__currentdatetime = date("Y-m-d H:i:s", time());
		
	}


	public function checksession()
	{
		if (empty($_SESSION['customer_id'])) {
			header("Location: " . base_url() . '?err=Please Login First');
			exit;
		}	
	}

	public function dashboard()
	{
		$this->checksession();
		$this->load->view('dashboard_view');
	}
	public function welcome()
	{
		$this->checksession();
		$this->load->view('welcome_view');
	}
	public function users()
	{
		$this->checksession();


		$this->load->view('users_view');
	}

	public function login_submit()
	{
		//VALIDATE FORM
		$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[5]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');

		if ($this->form_validation->run() == false) {
			$errors = array('error' => validation_errors());
			print_r(json_encode($errors));
			exit;
		}

		$this->__currentdatetime = date("Y-m-d H:i:s", time());


		$information = $this->security->xss_clean($this->input->post());
		$this->data['username'] = $information['username'];
		$this->data['password'] = md5($information['password']);


		$isAvailable = $this->Customer_model->login_submit($this->data);

		if (sizeof($isAvailable) > 0) {
			if (!$isAvailable[0]['status']) {
				$errors = array('error' => '<p>Your account is blocked!.</p>');
				print_r(json_encode($errors));
				exit;
			}

			$_SESSION['customer_id'] = $isAvailable[0]['id'];
			$_SESSION['customer_email'] = $isAvailable[0]['email'];
			$_SESSION['customer_username'] = $isAvailable[0]['username'];
			$_SESSION['customer_superadmin'] = $isAvailable[0]['is_superadmin'];
			$_SESSION['customer_avatar'] = $isAvailable[0]['profile_picture'];

			$success = array('success' => 1);
			print_r(json_encode($success));
			exit;
		} else {
			$errors = array('error' => '<p>Combination Does Not Exists!.</p>');
			print_r(json_encode($errors));
			exit;
		}
	}

	public function logout()
	{
		unset($_SESSION['customer_id']);
		unset($_SESSION['customer_email']);
		unset($_SESSION['customer_username']);
		unset($_SESSION['customer_superadmin']);
		unset($_SESSION['customer_avatar']);
		session_destroy();
		header("Location: " . base_url());
	}

}
