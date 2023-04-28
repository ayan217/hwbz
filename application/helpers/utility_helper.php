<?php

defined('BASEPATH') or exit('No direct script access allowed');


function number_to_words($num)
{
	require_once FCPATH . 'vendor/autoload.php';

	$numberToWords = new \NumberToWords\NumberToWords();
	$numberTransformer = $numberToWords->getNumberTransformer('en');
	return ucwords(strtolower($numberTransformer->toWords($num)));
}

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

function ss_login_check()
{
	$CI = &get_instance();
	if (empty($CI->session->userdata('ss_data'))) {
		redirect('login', 'refresh');
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

function logged_in_ss_row()
{
	$CI = &get_instance();
	$ss_data = $CI->session->userdata('ss_data');
	$ss_id = $ss_data['user_id'];
	$CI->load->model('UserModel');
	return $CI->UserModel->getss($ss_id);
}
