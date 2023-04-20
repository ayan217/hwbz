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

		//common validations
		$this->form_validation->set_rules('date', 'Date', 'required');
		$this->form_validation->set_rules('time_from', 'Time From', 'required');
		$this->form_validation->set_rules('time_to', 'Time To', 'required|callback_check_time');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('zip', 'Zip', 'required');
		$this->form_validation->set_rules('service', 'Service', 'required');
		$this->form_validation->set_rules('state', 'State', 'required');
		//common validations
		if ($form == 1) {
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

		$this->form_validation->set_rules('card_holder_name', 'Card Holder Name', 'trim|required');
		$this->form_validation->set_rules('card_number', 'Card Number', 'trim|required');
		$this->form_validation->set_rules('expiry_month', 'Expiry Month', 'trim|required');
		$this->form_validation->set_rules('expiry_year', 'Expiry Year', 'trim|required');
		$this->form_validation->set_rules('cvc', 'CVC', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'required');

		if ($this->form_validation->run() == TRUE) {
			$amount = $this->input->post('amount');
			// Set up the Stripe API key and create a Stripe PaymentIntent object
			\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));
			$intent = \Stripe\PaymentIntent::create([
				'amount' => $amount, // the payment amount in cents
				'currency' => 'usd', // the payment currency
			]);
			// Confirm the PaymentIntent by collecting payment details from the form
			$card_holder_name = $this->input->post('card_holdername');
			$card_number = $this->input->post('card_number');
			$expiry_month = $this->input->post('expiry_month');
			$expiry_year = $this->input->post('expiry_year');
			$cvc = $this->input->post('cvc');

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

			$intent->confirm([
				'payment_method' => $payment_method->id,
			]);
			// If the "Save Card" checkbox was checked, save the card to the Stripe customer
			if ($this->input->post('save_stripe_card')) {
				$customer = \Stripe\Customer::create([
					'payment_method' => $payment_method->id,
					'email' => logged_in_ss_row()->email, // replace with the customer's email address
				]);

				$card = $customer->sources->data[0];
				$card_id = $card->id;
				$cust_id = $customer->id;
				$stripe_cust_id = [
					'stripe_cust_id' => $cust_id
				];
				$this->userModel->update_user(logged_in_ss_row()->user_id, $stripe_cust_id);
				// Save the card ID to the database or to the customer's account in your application
				// ...
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
