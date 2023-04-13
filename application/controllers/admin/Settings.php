<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Settings extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		admin_login_check();
		$this->load->model('SettingsModel');
	}
	public function commission()
	{
		if ($this->input->post('update_commission_btn') !== null) {
			$commission_percent = $this->input->post('commission');
			$data = [
				'meta_value' => $commission_percent
			];
			$meta_key = 'site_commission';
			if ($this->multipleNeedsModel->update_site_meta($meta_key, $data) == true) {
				$this->session->set_flashdata('log_suc', 'Commission Percentage Updated.');
			} else {
				$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data['folder'] = 'admin';
			$data['template'] = 'commission';
			$data['title'] = 'HWBZ Site Commission';
			$data['admin_data'] = logged_in_admin_row();
			$data['commission_percentage'] = $this->multipleNeedsModel->get_site_meta('site_commission')->meta_value;
			$this->load->view('layout', $data);
		}
	}
	public function ss_type()
	{
		if ($this->input->post('add_ss_type_btn') !== null) {
			$ss_type = $this->input->post('ss_type');
			$data = [
				'name' => $ss_type
			];
			if ($this->SettingsModel->add_ss_type($data) !== false) {
				$this->session->set_flashdata('log_suc', 'New SS Type Added.');
			} else {
				$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data['folder'] = 'admin';
			$data['template'] = 'ss_type';
			$data['title'] = 'HWBZ SS Type';
			$data['admin_data'] = logged_in_admin_row();
			$data['ss_types'] = $this->SettingsModel->get_all_ss_type();
			$this->load->view('layout', $data);
		}
	}
	public function delete_ss_type($id)
	{
		if ($this->SettingsModel->delete_ss_type($id) == true) {
			$this->session->set_flashdata('log_suc', 'Success.');
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function update_ss_type($id)
	{
		$new_ss_type_name = $this->input->post('ss_type');
		$data = [
			'name' => $new_ss_type_name
		];
		if ($this->SettingsModel->update_ss_type($id, $data) == true) {
			$this->session->set_flashdata('log_suc', 'Updated.');
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
		}
	}
	public function hcp_service()
	{
		if ($this->input->post('add_hcp_service_btn') !== null) {
			$hcp_service = $this->input->post('hcp_service');
			$data = [
				'name' => $hcp_service
			];
			if ($this->SettingsModel->add_hcp_service($data) !== false) {
				$this->session->set_flashdata('log_suc', 'New HCP Service Added.');
			} else {
				$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data['folder'] = 'admin';
			$data['template'] = 'hcp_services';
			$data['title'] = 'HWBZ HCP Services';
			$data['admin_data'] = logged_in_admin_row();
			$data['hcp_services'] = $this->SettingsModel->get_all_hcp_services();
			$this->load->view('layout', $data);
		}
	}
	public function delete_hcp_service($id)
	{
		if ($this->SettingsModel->delete_hcp_service($id) == true) {
			$this->session->set_flashdata('log_suc', 'Success.');
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function update_hcp_service($id)
	{
		$new_hcp_type_name = $this->input->post('hcp_service');
		$data = [
			'name' => $new_hcp_type_name
		];
		if ($this->SettingsModel->update_hcp_service($id, $data) == true) {
			$this->session->set_flashdata('log_suc', 'Updated.');
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
		}
	}
	public function hourly_rates()
	{
		if ($this->input->post('add_hourly_rate_btn') !== null) {
			$hourly_rate = $this->input->post('hourly_rate');
			$hcp_service = $this->input->post('hcp_service');
			$hcp_state = $this->input->post('hcp_state');
			$data = [
				'state_id' => $hcp_state,
				'service_id' => $hcp_service,
				'amount' => $hourly_rate
			];
			if ($this->SettingsModel->add_hourly_rate($data) !== false) {
				$this->session->set_flashdata('log_suc', 'New Hourly Rate Added.');
			} else {
				$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$data['folder'] = 'admin';
			$data['template'] = 'hourly_rates';
			$data['title'] = 'HWBZ Hourly Rates';
			$data['admin_data'] = logged_in_admin_row();
			$data['all_usa_states'] = $this->multipleNeedsModel->get_all_usa_states();
			$data['hcp_services'] = $this->SettingsModel->get_all_hcp_services();
			$data['hourly_rates'] = $this->SettingsModel->get_all_hourly_rates();
			$this->load->view('layout', $data);
		}
	}
	public function delete_hourly_rate($id)
	{
		if ($this->SettingsModel->delete_hourly_rate($id) == true) {
			$this->session->set_flashdata('log_suc', 'Success.');
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function update_hourly_rate($id)
	{
		$new_state = $this->input->post('state');
		$new_service = $this->input->post('service');
		$new_rate = $this->input->post('rate');
		$data = [
			'state_id' => $new_state,
			'service_id' => $new_service,
			'amount' => $new_rate,
		];
		if ($this->SettingsModel->update_hourly_rate($id, $data) == true) {
			$this->session->set_flashdata('log_suc', 'Updated.');
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
		}
	}
}
