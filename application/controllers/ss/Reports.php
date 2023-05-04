<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(FCPATH . 'vendor/stripe/stripe-php/init.php');
class Reports extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		ss_login_check();
		$this->config->load('stripe');
		$this->load->model('jobModel');
		$this->load->model('SettingsModel');
		$this->load->model('TransactionModel');
	}
	public function booking_history()
	{
		$data['folder'] = 'ss';
		$data['title'] = 'HWBZ SS Bookings';
		$data['template'] = 'booking_history';
		$data['user_data'] = logged_in_ss_row();
		if ($this->input->post()) {
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$filter = TABLE_PREFIX . 'jobs.job_date BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"';
		} else {
			$filter = null;
		}
		$data['bookings'] = $this->jobModel->get_bookings($filter);
		$this->load->view('layout', $data);
	}
	public function payment_history()
	{
		$data['folder'] = 'ss';
		$data['title'] = 'HWBZ SS Payments';
		$data['template'] = 'payment_history';
		$data['user_data'] = logged_in_ss_row();
		if ($this->input->post()) {
			$start_date = $this->input->post('start_date');
			$end_date = $this->input->post('end_date');
			$filter = TABLE_PREFIX . 'transaction.created_at BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"';
		} else {
			$filter = null;
		}
		$data['payments'] = $this->TransactionModel->get_transactionsfor_ss($filter);
		$this->load->view('layout', $data);
	}
}
