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
		echo $this->db->last_query();die();
		$this->load->view('layout', $data);
	}
	public function export_csv($sd, $ed)
	{
		if ((int)$sd !== 0 && (int)$ed !== 0) {
			$filter = TABLE_PREFIX . 'transaction.created_at BETWEEN "' . date('Y-m-d', strtotime($sd)) . '" and "' . date('Y-m-d', strtotime($ed)) . '"';
		} else {
			$filter = null;
		}
		$payments = $this->TransactionModel->get_transactionsfor_ss($filter);
		$csv_data = array(
			array('Job ID', 'TXN.Date', 'TXN.Time', 'TXN.ID', 'Service(s)', 'Amount', 'Payment A/c', 'Status')
		);
		if (!empty($payments)) {
			foreach ($payments as $payment) {
				$service_names_array = array();
				$service_ids = explode(',', $payment->service_ids);
				foreach ($service_ids as $service_id) {
					$service_names_array[] = $this->SettingsModel->get_hcp_service($service_id)->name;
				}
				$service_names = implode(', ', $service_names_array);

				$date_time_str = $payment->created_at;
				$date_str = date('m/d/Y', strtotime(substr($date_time_str, 0, 10)));
				$time_str = substr($date_time_str, 11, 5);
				if ($payment->type == 'job_refund') {
					$amount = '-$' . $payment->amount;
					$status = 'Refunded';
					$ac_no = get_refunded_acc($payment->payment_account);
				} else {
					$amount = '$' . $payment->amount;
					$status = 'Success';
					$acpaymenttype = explode('_', $payment->payment_account);
					if ($acpaymenttype[0] == 'card') {
						// $ac_no = '2';
						$ac_no = get_card($payment->stripe_cust_id, $payment->payment_account);
					} elseif ($acpaymenttype[0] == 'pm') {
						$ac_no = get_payment_card($payment->payment_account);
						// $ac_no = '1';
					} else {
						$ac_no = '3';
					}
				}
				$csv_data[] = array(
					$payment->job_id,
					$date_str,
					$time_str,
					$payment->stripe_payment_id,
					$service_names,
					$amount,
					$ac_no,
					$status
				);
			}

			// Generate the CSV file
			$filename = 'payments_' . date('YmdHis') . '.csv';
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=' . $filename);
			$output = fopen('php://output', 'w');
			foreach ($csv_data as $row) {
				fputcsv($output, $row);
			}
			fclose($output);
			exit;
		} else {
			$this->session->set_flashdata('log_err', 'Empty Table..!!');
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}
}
