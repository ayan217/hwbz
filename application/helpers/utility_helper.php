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

function get_refunded_acc($refund_id)
{
	require_once FCPATH . 'vendor/autoload.php';
	$CI = &get_instance();
	$CI->config->load('stripe');
	// Set your Stripe API key
	\Stripe\Stripe::setApiKey($CI->config->item('stripe_secret_key'));

	try {

		$refund = \Stripe\Refund::retrieve($refund_id);

		$charge = \Stripe\Charge::retrieve($refund->charge);

		// Retrieve the card object from the charge object
		$card = $charge->payment_method_details->card;

		$card_details = $card->brand . ' || XXXX XXXX ' . $card->last4;
		return $card_details;
	} catch (\Stripe\Exception\ApiErrorException $e) {
		// Handle any errors
		echo 'Error: ' . $e->getMessage();
	}
}

function get_card($cust_id, $card_id)
{
	require_once FCPATH . 'vendor/autoload.php';
	$CI = &get_instance();
	$CI->config->load('stripe');
	// Set your Stripe API key
	\Stripe\Stripe::setApiKey($CI->config->item('stripe_secret_key'));

	$card = \Stripe\Customer::retrieveSource($cust_id, $card_id);

	// Retrieve the last 4 digits of the card
	$card_details = $card->brand . ' || XXXX ' . $card->last4;
	return $card_details;
}

function get_payment_card($pm_id)
{
	require_once FCPATH . 'vendor/autoload.php';
	$CI = &get_instance();
	$CI->config->load('stripe');
	// Set your Stripe API key
	\Stripe\Stripe::setApiKey($CI->config->item('stripe_secret_key'));

	// Retrieve the PaymentMethod object associated with the Payment Method ID
	$payment_method = \Stripe\PaymentMethod::retrieve($pm_id);

	// Retrieve the Card object from the PaymentMethod object
	$card = $payment_method->card;

	// Retrieve the last 4 digits of the card
	$last4 = $card->last4;


	// Retrieve the last 4 digits of the card
	$card_details = $card->brand . ' || XXXX XXXX ' . $card->last4;
	return $card_details;
}

