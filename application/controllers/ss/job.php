<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(FCPATH . 'vendor/stripe/stripe-php/init.php');
class Job extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		ss_login_check();
		$this->config->load('stripe');
	}
	public function index()
	{
		$this->load->model('SettingsModel');
		$data['folder'] = 'ss';
		$data['title'] = 'HWBZ Job Posting';
		$data['template'] = 'post_job';
		$data['user_data'] = logged_in_ss_row();
		$data['services'] = $this->SettingsModel->get_all_hcp_services();
		$data['all_usa_states'] = $this->multipleNeedsModel->get_all_usa_states();
		$this->load->view('layout', $data);
	}
}
