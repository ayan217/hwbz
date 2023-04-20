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
		$this->load->model('SettingsModel');
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
		$data['cards'] = $this->multipleNeedsModel->get_user_saved_cards();
		$this->load->view('layout', $data);
	}
	public function post_job($form)
	{
		if ($form == 1) {
			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('time_from', 'Time From', 'required');
			$this->form_validation->set_rules('time_to', 'Time To', 'required|callback_check_time');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('zip', 'Zip', 'required');
			$this->form_validation->set_rules('service', 'Service', 'required');
			$this->form_validation->set_rules('state', 'State', 'required');

			if ($this->form_validation->run() == TRUE) {
				if ($this->SettingsModel->get_hourly_rate_by_service($_POST['service'], $_POST['state']) !== false) {
					$net_amount = $this->SettingsModel->get_hourly_rate_by_service($_POST['service'], $_POST['state'])->amount;
				} else {
					$net_amount = 0;
				}
				$res = [
					'status' => 1,
					'net_amount' => $net_amount
				];
			} else {
				$res = [
					'status' => 0,
					'msg' => validation_errors()
				];
			}
		}
		echo json_encode($res);
	}
	function check_time($time_to)
	{
		$time_from = $this->input->post('time_from');
		$time_from_unix = strtotime($time_from);
		$time_to_unix = strtotime($time_to);
		if ($time_to_unix <= $time_from_unix) {
			$this->form_validation->set_message('check_time', 'The Time To field must be greater than the Time From field.');
			return false;
		} else {
			return true;
		}
	}
}
