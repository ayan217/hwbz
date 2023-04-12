<?php

defined('BASEPATH') or exit('No direct script access allowed');



function user_login_check()
{
	$CI = &get_instance();
	if (empty($CI->session->userdata('user_log'))) {
		redirect(site_url('Login'), 'refresh');
	}
}

function admin_login_check()
{
	$CI = &get_instance();
	if (empty($CI->session->userdata('admin_log_data'))) {
		redirect(ADMIN_URL, 'refresh');
	}
}

function logged_in_admin_row()
{
	$CI = &get_instance();
	$admin_log_data = $CI->session->userdata('admin_log_data');
	$admin_id = $admin_log_data['user_log_id'];
	$CI->load->model('UserModel');
	return $CI->UserModel->getadmin($admin_id);
}

function loginUserId()
{
	$CI = &get_instance();
	$session_data = $CI->session->userdata('user_log');
	$data['display'] = $session_data;
	return $data;
}


///////////////////////////////////////////////// Sess_id ////////////////////////////////////////////////////
function sess_id_exist($sess_id, $ip)
{
	$CI = &get_instance();
	$existance = $CI->multipleNeedsModel->checkSessIdExistance($sess_id, $ip);
	if ($existance) {
		return true;
	} else {
		return false;
	}
}

function getSoleDetails($table, $field, $value, $getValue)
{
	$CI = &get_instance();
	$details = $CI->multipleNeedsModel->getSoleDetails($table, $field, $value, $getValue);
	if ($details) {
		return $details[0]->$getValue;
	} else {
		return false;
	}
}



function add_last_name_to_database()
{
	$CI = &get_instance();
	$x = $CI->db->query('select * from user')->result();
	foreach ($x as $y) {
		$c = explode(' ', $y->full_name);
		if (count($c) > 1) {
			$CI->db->query('update user set last_name = "' . $c[1] . '" where user_id = ' . $y->user_id);
		} else {
			$CI->db->query('update user set last_name = "" where user_id = ' . $y->user_id);
		}
	}
}

function autologin($email, $password)
{

	$CI = &get_instance();

	$CI->load->model('LoginModel');
	$CI->load->model('multipleNeedsModel');

	$checkThisEmailDetails = $CI->LoginModel->login($email);

	$checkThisAdminEmailDetails = $CI->LoginModel->admin_staff_login($email);

	if ($checkThisEmailDetails) {
		if ($checkThisEmailDetails[0]->mail_status == 1) {
			if (password_verify($password, $checkThisEmailDetails[0]->password)) {

				if ($checkThisEmailDetails[0]->status == 1) {
					$sess_array = array(
						'user_log_id'  => $checkThisEmailDetails[0]->user_id,
						'user_display' => $checkThisEmailDetails[0]->full_name
					);
					$_SESSION['is_admin'] = 0;

					// cookies saved for 4 hours

					setcookie("user_email", $email, time() +
						(14400000), '/');

					setcookie("user_password", $password, time() +
						(14400000), '/');


					// cookies saved for 4 hours

					$CI->session->set_userdata('user_log', $sess_array);
					redirect('Dashboard', 'refresh');
				} else if ($checkThisEmailDetails[0]->deleted_at != null) {
					$CI->session->set_userdata('log_err', 'User Not Found !');
					redirect('Login', 'refresh');
				} else if ($checkThisEmailDetails[0]->status == 0) {
					$CI->session->set_userdata('log_err', 'Account Deactivated');
					redirect('Login', 'refresh');
				}
			} else {
				$CI->session->set_userdata('log_err', 'Invalid Password');
				redirect('Login', 'refresh');
			}
		} else {
			$CI->session->set_userdata('resend', $email);
			redirect('Login', 'refresh');
		}
	} elseif ($checkThisAdminEmailDetails) {
		if (password_verify($password, $checkThisAdminEmailDetails[0]->password)) {

			$sess_array = array(
				'user_log_id'  => $checkThisAdminEmailDetails[0]->id,
				'user_display' => $checkThisAdminEmailDetails[0]->first_name . ' ' . $checkThisAdminEmailDetails[0]->last_name
			);
			$_SESSION['is_admin'] = 1;


			// cookies saved for 4 hours

			setcookie("user_email", $email, time() +
				(14400000), '/');

			setcookie("user_password", $password, time() +
				(14400000), '/');


			// cookies saved for 4 hours

			$CI->session->set_userdata('user_log', $sess_array);
			redirect('Dashboard', 'refresh');
		} else {
			$CI->session->set_userdata('log_err', 'Invalid Password');
			redirect('Login', 'refresh');
		}
	} else {
		$CI->session->set_userdata('log_err', 'Invalid Email');
		redirect('Login', 'refresh');
	}
}
