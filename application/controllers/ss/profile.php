<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(FCPATH . 'vendor/stripe/stripe-php/init.php');
class Profile extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		ss_login_check();
		$this->config->load('stripe');
	}
	public function account_settings()
	{
		$this->load->model('SettingsModel');
		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));

		$data['folder'] = 'ss';
		$data['title'] = 'HWBZ SS Account';
		$data['template'] = 'account_settings';
		$data['user_data'] = logged_in_ss_row();
		$data['ss_types'] = $this->SettingsModel->get_all_ss_type();
		$data['all_usa_states'] = $this->multipleNeedsModel->get_all_usa_states();
		$this->load->view('layout', $data);
	}
	public function update_account()
	{
		$ss_id = logged_in_ss_row()->user_id;
		$this->UserModel->update_user($_POST, $ss_id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function stripe_all_cust()
	{

		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));

		// Get a list of all customers
		try {
			$customers = \Stripe\Customer::all();
		} catch (\Stripe\Exception\CardException $e) {
			// Handle card errors
			echo 'Card declined: ' . $e->getMessage();
		} catch (\Stripe\Exception\RateLimitException $e) {
			// Handle rate limit errors
			echo 'Rate limit exceeded: ' . $e->getMessage();
		} catch (\Stripe\Exception\InvalidRequestException $e) {
			// Handle invalid request errors
			echo 'Invalid request: ' . $e->getMessage();
		} catch (\Stripe\Exception\AuthenticationException $e) {
			// Handle authentication errors
			echo 'Authentication error: ' . $e->getMessage();
		} catch (\Stripe\Exception\ApiConnectionException $e) {
			// Handle API connection errors
			echo 'API connection error: ' . $e->getMessage();
		} catch (\Stripe\Exception\ApiErrorException $e) {
			// Handle other API errors
			echo 'API error: ' . $e->getMessage();
		}

		// Display the list of customers and their IDs
?>
		<table>
			<thead>
				<tr>
					<th>Customer ID</th>
					<th>Name</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($customers->data as $customer) { ?>
					<tr>
						<td><?= $customer->id ?></td>
						<td><?= $customer->name ?></td>
						<td><?= $customer->email ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php

	}
	public function stripe_customer_cards()
	{
		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));
		$customer_id = 'cus_NTZsxkgXTDh2yT'; // replace with the customer ID you want to retrieve

		try {
			$customer = \Stripe\Customer::retrieve($customer_id);

			$cards = \Stripe\Customer::allSources(
				$customer->id,
				array("object" => "card")
			);
			if (isset($_POST['card_id'])) {
				\Stripe\Customer::deleteSource(
					$customer->id,
					$_POST['card_id']
				);
			}

		?>
			<ul>
				<?php foreach ($cards->data as $card) : ?>
					<li>
						<?php echo $card->brand . ' ' . $card->last4; ?>
						<form method="post">
							<input type="hidden" name="card_id" value="<?php echo $card->id; ?>">
							<button type="submit" name="delete_card">Delete</button>
						</form>
					</li>
				<?php endforeach; ?>
			</ul>

		<?php
		} catch (\Stripe\Exception\CardException $e) {
			// Handle card errors
			echo 'Card declined: ' . $e->getMessage();
		} catch (\Stripe\Exception\RateLimitException $e) {
			// Handle rate limit errors
			echo 'Rate limit exceeded: ' . $e->getMessage();
		} catch (\Stripe\Exception\InvalidRequestException $e) {
			// Handle invalid request errors
			echo 'Invalid request: ' . $e->getMessage();
		} catch (\Stripe\Exception\AuthenticationException $e) {
			// Handle authentication errors
			echo 'Authentication error: ' . $e->getMessage();
		} catch (\Stripe\Exception\ApiConnectionException $e) {
			// Handle API connection errors
			echo 'API connection error: ' . $e->getMessage();
		} catch (\Stripe\Exception\ApiErrorException $e) {
			// Handle other API errors
			echo 'API error: ' . $e->getMessage();
		}

		?>


<?php
	}
}