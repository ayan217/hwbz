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
		$data['folder'] = 'ss';
		$data['title'] = 'HWBZ SS Account';
		$data['template'] = 'account_settings';
		$data['user_data'] = logged_in_ss_row();
		$data['cards'] = $this->multipleNeedsModel->get_user_saved_cards();
		$data['ss_types'] = $this->SettingsModel->get_all_ss_type();
		$data['all_usa_states'] = $this->multipleNeedsModel->get_all_usa_states();
		$this->load->view('layout', $data);
	}
	public function update_account()
	{
		$ss_id = logged_in_ss_row()->user_id;
		if ($this->UserModel->update_user($_POST, $ss_id)) {
			$this->session->set_flashdata('log_suc', 'Account Updated.');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function delete_card()
	{
		$cust_id = $this->input->post('cust_id');
		$card_id = $this->input->post('card_id');

		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));

		$deletedCard = \Stripe\Customer::deleteSource(
			$cust_id,
			$card_id
		);

		if ($deletedCard->isDeleted()) {
			$this->session->set_flashdata('log_suc', 'Card Removed');
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		} else {
			$this->session->set_flashdata('log_err', 'Something Went Wrong !!');
			redirect($_SERVER['HTTP_REFERER'], 'refresh');
		}
	}


	public function change_password()
	{
		if ($this->input->post()) {
			$user_id = logged_in_ss_row()->user_id;
			$this->form_validation->set_rules('old_psw', 'Old Password', 'required');
			$this->form_validation->set_rules('new_psw', 'New Password', 'required');
			$this->form_validation->set_rules('confirm_new_psw', 'Confirm New Password', 'required|matches[new_psw]');
			if ($this->form_validation->run() == TRUE) {
				$old_psw = $this->input->post('old_psw');
				$new_psw = $this->input->post('new_psw');
				$ss = $this->UserModel->getss($user_id);
				if (password_verify($old_psw, $ss->password)) {
					$password_encoded = password_hash($new_psw, PASSWORD_DEFAULT);
					$data = [
						'password' => $password_encoded
					];
					if ($this->UserModel->update_user($data, $user_id) == true) {
						$this->session->set_flashdata('log_suc', 'Password Updated');
						$res = [
							'status' => 1,
						];
					} else {
						$res = [
							'status' => 0,
							'msg' => 'Update Failed.'
						];
					}
				} else {
					$res = [
						'status' => 0,
						'msg' => 'Old Password Doesn\'t Match.'
					];
				}
			} else {
				$res = [
					'status' => 0,
					'msg' => validation_errors()
				];
			}
			echo json_encode($res);
		} else {
			$data['folder'] = 'ss';
			$data['title'] = 'HWBZ SS Change-password';
			$data['template'] = 'change_password';
			$data['user_data'] = logged_in_ss_row();
			$this->load->view('layout', $data);
		}
	}


	//stripe testing=================================================================================================================

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
						<?php echo $card->brand . ' XXXX XXXX XXXX ' . $card->last4; ?>
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
