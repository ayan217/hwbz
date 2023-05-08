<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//file names caps

//general pages
$route['default_controller'] = 'Home';
$route['signup'] = 'Home/signup';
$route['thank-you'] = 'Home/thankyou';
$route['login'] = 'Home/login';
$route['logout'] = 'Home/logout';
$route['about'] = 'Home/about';
$route['contact-us'] = 'Home/contact_us';
$route['faq'] = 'Home/faq';
//general pages
//ss pages
$route['ss'] = 'ss/Dashboard';
$route['ss/account-settings'] = 'ss/Profile/account_settings';
$route['ss/job/(:any)'] = 'ss/Job/view_job/$1';
$route['ss/cancel-job/(:num)'] = 'ss/Job/cancel_job/$1';
$route['ss/change-password'] = 'ss/Profile/change_password';
$route['ss/booking-history'] = 'ss/Reports/booking_history';
$route['ss/payment-history'] = 'ss/Reports/payment_history';
//ss pages
// admin pages
$route['admin'] = 'admin/Login';
//settings
$route['admin/commission'] = 'admin/Settings/commission';
$route['admin/ss-type'] = 'admin/Settings/ss_type';
$route['admin/hcp-services'] = 'admin/Settings/hcp_service';
$route['admin/hourly-rates'] = 'admin/Settings/hourly_rates';
//settings
// admin pages
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
