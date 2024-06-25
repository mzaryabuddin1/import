<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//CUSTOMER
$route['customer-login-submit'] = 'customer/Customer/login_submit'; 
$route['customer-welcome'] = 'customer/Customer/welcome'; 
$route['customer-dashboard'] = 'customer/Customer/dashboard'; 
$route['customer-users'] = 'customer/Customer/users'; 
$route['customer-logout'] = 'customer/Customer/logout'; 

// ADMIN
