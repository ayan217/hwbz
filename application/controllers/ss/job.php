<?php

use Stripe\Customer;

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
		$this->load->model('jobModel');
	}
	function get_hour_diff($start, $end)
	{
		$start_time = new DateTime($start);
		$end_time = new DateTime($end);

		// Subtract the end time from the start time
		$interval = $start_time->diff($end_time);

		// Get the interval as a formatted string (hours:minutes)
		$interval_string = $interval->format('%H');

		return $interval_string;
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
	public function post_job($form = null)
	{
		$res = array();

		if ($form == 1) {

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('time_from', 'Time From', 'required');
			$this->form_validation->set_rules('time_to', 'Time To', 'required|callback_check_time');
			$this->form_validation->set_rules('address', 'Address', 'required');
			$this->form_validation->set_rules('city', 'City', 'required');
			$this->form_validation->set_rules('zip', 'Zip', 'required');
			$this->form_validation->set_rules('service[]', 'Service', 'required');
			$this->form_validation->set_rules('state', 'State', 'required');

			// Create two DateTime objects representing the start and end times

			$interval_string = $this->get_hour_diff($_POST['time_from'], $_POST['time_to']);
			$hour = $interval_string;
			if ($this->form_validation->run() == TRUE) {
				$hour_rate = 0;
				$services = $_POST['service'];
				foreach ($services as $service) {

					if ($this->SettingsModel->get_hourly_rate_by_service($service, $_POST['state']) !== false) {
						$hour_rate += $this->SettingsModel->get_hourly_rate_by_service($service, $_POST['state'])->amount;
					}
				}
				$net_amount = $hour_rate * $hour;
				$res = [
					'status' => 2,
					'net_amount' => $net_amount
				];
			} else {
				$res = [
					'status' => 0,
					'msg' => validation_errors()
				];
			}
		} else {
			if ($this->input->post('card_id') == null) {
				$this->form_validation->set_rules('card_holder_name', 'Card Holder Name', 'trim|required');
				$this->form_validation->set_rules('card_number', 'Card Number', 'trim|required');
				$this->form_validation->set_rules('expiry_month', 'Expiry Month', 'trim|required');
				$this->form_validation->set_rules('expiry_year', 'Expiry Year', 'trim|required');
				$this->form_validation->set_rules('cvc', 'CVC', 'trim|required');
			}
			$this->form_validation->set_rules('payment_amount', 'Amount', 'required');

			if ($this->form_validation->run() == TRUE) {
				$res = array('val' => 1);
				$amountindoller = $this->input->post('payment_amount');
				$amount = $amountindoller * 100;
				// Set up the Stripe API key and create a Stripe PaymentIntent object
				\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));
				if ($this->input->post('card_id') == null) {
					$intent = \Stripe\PaymentIntent::create([
						'amount' => $amount, // the payment amount in cents
						'currency' => 'usd', // the payment currency
					]);
				} else {
					$intent = \Stripe\PaymentIntent::create([
						'customer' => logged_in_ss_row()->stripe_cust_id, // the payment amount in cents
						'amount' => $amount, // the payment amount in cents
						'currency' => 'usd', // the payment currency
					]);
				}
				// Confirm the PaymentIntent by collecting payment details from the form
				$card_holder_name = $this->input->post('card_holdername');
				$card_number = $this->input->post('card_number');
				$expiry_month = $this->input->post('expiry_month');
				$expiry_year = $this->input->post('expiry_year');
				$cvc = $this->input->post('cvc');

				if ($this->input->post('card_id') == null) {
					$payment_method = \Stripe\PaymentMethod::create([
						'type' => 'card',
						'card' => [
							'number' => $card_number,
							'exp_month' => $expiry_month,
							'exp_year' => $expiry_year,
							'cvc' => $cvc,
						],
						'billing_details' => [
							'name' => $card_holder_name,
						],
					]);
					$payment_id = $payment_method->id;
				} else {
					$payment_id = $this->input->post('card_id');
				}
				$intent->confirm([
					'payment_method' => $payment_id,
				]);

				// Check the status of the payment intent
				$status = $intent->status;
				$payment_trans_id = $intent->id;

				if ($status == 'succeeded') {
					// If the "Save Card" checkbox was checked, save the card to the Stripe customer
					if ($this->input->post('save_stripe_card')) {

						$customer_id = logged_in_ss_row()->stripe_cust_id;

						$token = \Stripe\Token::create([
							'card' => [
								'number' => $card_number,
								'exp_month' => $expiry_month,
								'exp_year' => $expiry_year,
								'cvc' => $cvc,
							],
						]);

						$card = \Stripe\Customer::createSource(
							$customer_id,
							['source' => $token]
						);
					}
					// Payment was successful, process the order

					$where = ['id' => $_POST['state']];
					$state_row = $this->multipleNeedsModel->get_any_table_row('states', $where);
					$state_code = $state_row->Code;
					$services = $_POST['service'];
					foreach ($services as $service) {

						$where2 = ['id' => $service];
						$service_row = $this->multipleNeedsModel->get_any_table_row('hcp_services', $where2);

						$service_names[] = $service_row->name;
					}

					$service_name = implode(', ', $service_names);
					$invoice_html = '<div><div><div>Service(s)</div><div>Location</div><div>Date</div><div>Time</div><div>Amount</div></div><div><div><div>' . $service_name . '</div><div>' . $_POST['address'] . '(' . $state_code . ')</div><div>' . date('m/d/Y', strtotime($_POST['date'])) . '</div><div>' . $_POST['time_from'] . '-' . $_POST['time_to'] . '</div><div>$' . $amountindoller . '</div></div></div><div>';

					$invoice_file_name = $this->multipleNeedsModel->gen_pdf($invoice_html, JOB_INVOICE_PATH, 'F', 'HWBZ_JOB_invoice');

					//save job to the database
					$job_status = 0;
					$job_id = 'HWBZ_JOB_' . logged_in_ss_row()->user_id . mt_rand(1000, 9999);

					$job_data = [
						'job_id' => $job_id,
						'stripe_payment_id' => $payment_trans_id,
						'ss_id' => logged_in_ss_row()->user_id,
						'shift' => $_POST['time_from'] . '-' . $_POST['time_to'],
						'service_ids' => implode(',', $_POST['service']),
						'address' => $_POST['address'],
						'city' => $_POST['city'],
						'zip' => $_POST['zip'],
						'state_id' => $_POST['state'],
						'amount' => $amountindoller,
						'invoice' => $invoice_file_name,
						'job_date' => $_POST['date'],
						'status' => $job_status,
						'created_at' => date('Y-m-d H:i:s'),
					];

					$added_job_id = $this->jobModel->add($job_data);

					if ($added_job_id !== false) {
						$res = [
							'status' => 1,
							'msg' => $status
						];
					} else {
						$res = [
							'status' => 0,
							'msg' => 'database error..!'
						];
					}
					//save job to the database



				} elseif ($status == 'requires_action') {
					// Payment requires additional authentication, handle the authentication flow
				} else {
					// Payment failed or was canceled, handle the error
				}
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

	public function view_job($type)
	{
		if ($type == 'all') {

			$data['title'] = 'HWBZ All Jobs';
			$data['jobs'] = $this->jobModel->get_jobs();
		} elseif ($type == 'open') {
			$data['title'] = 'HWBZ Open Jobs';
			$data['jobs'] = $this->jobModel->get_jobs(0);
		} elseif ($type == 'pending') {
			$data['title'] = 'HWBZ Pending Jobs';
			$data['jobs'] = $this->jobModel->get_jobs(2);
		} elseif ($type == 'completed') {
			$data['title'] = 'HWBZ Completed Jobs';
			$data['jobs'] = $this->jobModel->get_jobs(1);
		}
		$data['template'] = 'jobs';
		$data['type'] = $type;
		$data['user_data'] = logged_in_ss_row();
		$data['folder'] = 'ss';
		$this->load->view('layout', $data);
	}
	public function view_invoice($job_id)
	{
		$job_row = $this->jobModel->get_the_job($job_id);
		$services = explode(',', $job_row->service_ids);
		foreach ($services as $service) {

			$where = ['id' => $service];
			$service_row = $this->multipleNeedsModel->get_any_table_row('hcp_services', $where);

			$service_names[] = $service_row->name;
		}
		$amount_in_text = number_to_words($job_row->amount);

		$dateStr = $job_row->created_at;
		$dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $dateStr);
		$invoice_date = $dateObj->format('F d, Y');

		$pdf_download_link = DOWNLOAD_JOB_INVOICE_PATH . $job_row->invoice;

		$service_name = implode(', ', $service_names);
		$res = [
			'services' => $service_name,
			'location' => $job_row->city . ', ' . $job_row->Code,
			'date' => date('m/d/Y', strtotime($job_row->job_date)),
			'time' => $job_row->shift,
			'amount' => $job_row->amount,
			'amount_in_text' => $amount_in_text,
			'invoice_id' => $job_row->stripe_payment_id,
			'invoice_date' => $invoice_date,
			'pdf_download_link' => $pdf_download_link,

		];
		echo json_encode($res);
	}
	public function refund($payment_id, $refund_amount = null)
	{

		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));
		if ($refund_amount !== null) {
			$refund = \Stripe\Refund::create([
				'payment_intent' => $payment_id,
				'amount' => $refund_amount,
			]);
		} else {
			$refund = \Stripe\Refund::create([
				'payment_intent' => $payment_id,
			]);
		}

		return $refund->status;
	}

	public function cancel_job($job_id)
	{
		$job_row = $this->jobModel->get_the_job($job_id);

		$payment_id = $job_row->stripe_payment_id;
		$amount = $job_row->amount;

		$date_string = $job_row->job_date;
		$time_splits = explode('-', $job_row->shift);
		$start_time_string = trim($time_splits[0]);
		$end_time_ending = trim($time_splits[1]);

		$start_time = DateTime::createFromFormat('Y-m-d H:i:s', $date_string . ' ' . $start_time_string . ':00');

		$current_time = new DateTime();
		$diff_hours = round(($start_time->getTimestamp() - $current_time->getTimestamp()) / 3600);

		if ($start_time > $current_time) {
			// echo "The difference between the start time and the current time is {$diff_hours} hours.";
			$ss_type = 'USER-' . logged_in_ss_row()->acc_type;
			if ($ss_type == PATIENT) {
				$canceletion_fee_hour = 8;
			} elseif ($ss_type == ORG) {
				$canceletion_fee_hour = 24;
			}
			if ($diff_hours >= $canceletion_fee_hour) {
				if ($this->refund($payment_id) == 'succeeded') {
					$cancel_data = [
						'cancel' => 1,
						'cancelation_time' => date('Y-m-d H:i:s'),
						'refunded_amount' => $amount,
					];
					if ($this->jobModel->update_job($cancel_data, $job_id) == true) {
						$this->session->set_flashdata('log_suc', 'Job Canceled');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					} else {
						$this->session->set_flashdata('log_err', 'Database Error..!!');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					}
				} else {
					$this->session->set_flashdata('log_err', 'Refund Failed..!!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			} elseif ($diff_hours < $canceletion_fee_hour) {
				$job_hours = $this->get_hour_diff($start_time_string, $end_time_ending);
				$one_hour_amount = $amount / $job_hours;
				$cancelation_fee = $one_hour_amount * 2;
				$refunded_amount = $amount - $cancelation_fee;
				$refunded_amount_in_cents = ($amount - $cancelation_fee) * 100;
				if ($this->refund($payment_id, $refunded_amount_in_cents) == 'succeeded') {
					$cancel_data = [
						'cancel' => 1,
						'cancelation_time' => date('Y-m-d H:i:s'),
						'refunded_amount' => $refunded_amount,
					];
					if ($this->jobModel->update_job($cancel_data, $job_id) == true) {
						$this->session->set_flashdata('log_suc', 'Job Canceled');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					} else {
						$this->session->set_flashdata('log_err', 'Database Error..!!');
						redirect($_SERVER['HTTP_REFERER'], 'refresh');
					}
				} else {
					$this->session->set_flashdata('log_err', 'Refund Failed..!!');
					redirect($_SERVER['HTTP_REFERER'], 'refresh');
				}
			}
		} else {
			$this->session->set_flashdata('log_err', 'The start time has already passed..!!');
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}
}
