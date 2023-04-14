<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{
		$data['folder'] = 'general_pages';
		$data['template'] = 'home_page';
		$data['title'] = 'HWBZ Home';
		$this->load->view('layout', $data);
	}

	public function signup()
	{
		if ($this->input->post()) {

			$hcp_form_1 = isset($_POST['hcp_form_1']) ? $_POST['hcp_form_1'] : 0;

			$user_type_raw = $this->input->post('user_type');
			$user_type = substr($user_type_raw, strpos($user_type_raw, "-") + 1);
			if ($user_type_raw == PATIENT) {
				$prefix = 'p_';
				$this->form_validation->set_rules($prefix . 'ssn', 'SSN', 'required');
				$this->form_validation->set_rules($prefix . 'emergency_info', 'Emergency Info', 'required');
				$this->form_validation->set_rules($prefix . 'gender', 'Gender', 'required|in_list[M,F,O]');
				$this->form_validation->set_rules($prefix . 'dob', 'Date of Birth', 'required|callback_valid_date');
			} elseif ($user_type_raw == ORG) {
				$prefix = 'o_';
				$this->form_validation->set_rules($prefix . 'org_type', 'Organization Type', 'required|greater_than[0]');
				$this->form_validation->set_rules($prefix . 'org_name', 'Organization Name', 'required');
			} elseif ($user_type_raw == HCP) {
				$prefix = 'h_';
				$this->form_validation->set_rules($prefix . 'gender', 'Gender', 'required|in_list[M,F,O]');
				$this->form_validation->set_rules($prefix . 'ssn', 'SSN', 'required');
				$this->form_validation->set_rules($prefix . 'dob', 'Date of Birth', 'required|callback_valid_date');
				$this->form_validation->set_rules($prefix . 'emergency_info', 'Emergency Info', 'required');
				if($hcp_form_1 == 0){
					
				}
			}

			//common rules
			$this->form_validation->set_rules(
				$prefix . 'username',
				'Username',
				'required|min_length[3]|max_length[12]|is_unique[' . TABLE_PREFIX . 'user.user_name]',
				array(
					'required'      => 'You have not provided %s.',
					'is_unique'     => 'This %s already exists.'
				)
			);
			$this->form_validation->set_rules($prefix . 'password', 'Password', 'trim|required|min_length[8]');
			$this->form_validation->set_rules($prefix . 'cpassword', 'Password Confirmation', 'trim|required|matches[' . $prefix . 'password]');
			$this->form_validation->set_rules($prefix . 'email', 'Email', 'required|valid_email|is_unique[' . TABLE_PREFIX . 'user.email]', array(
				'required'      => 'You have not provided your %s.',
				'valid_email'      => '%s is not valid.',
				'is_unique'     => 'This %s already exists.'
			));
			$this->form_validation->set_rules($prefix . 'fname', 'First Name', 'required');
			$this->form_validation->set_rules($prefix . 'lname', 'Last Name', 'required');
			$this->form_validation->set_rules($prefix . 'address', 'Street Address', 'required');
			$this->form_validation->set_rules($prefix . 'city', 'City', 'required');
			$this->form_validation->set_rules($prefix . 'state', 'State', 'required|greater_than[0]', array(
				'required'      => 'Please select a valid %s for your location.',
				'greater_than'      => 'Please select a valid %s for your location.',
			));
			$this->form_validation->set_rules($prefix . 'zip', 'Zip Code', 'required|numeric|min_length[5]|max_length[10]');
			$this->form_validation->set_rules($prefix . 'phone', 'Phone Number', 'required|numeric|min_length[10]|max_length[15]');
			//common rules

			$user_name = isset($_POST[$prefix . 'username']) ? $_POST[$prefix . 'username'] : '';
			$first_name = isset($_POST[$prefix . 'fname']) ? $_POST[$prefix . 'fname'] : '';
			$last_name = isset($_POST[$prefix . 'lname']) ? $_POST[$prefix . 'lname'] : '';
			$acc_type = $user_type;
			$email = isset($_POST[$prefix . 'email']) ? $_POST[$prefix . 'email'] : '';
			$phone = isset($_POST[$prefix . 'phone']) ? $_POST[$prefix . 'phone'] : '';
			$password_decoded = isset($_POST[$prefix . 'password']) ? $_POST[$prefix . 'password'] : '';
			$cpassword_decoded = isset($_POST[$prefix . 'cpassword']) ? $_POST[$prefix . 'cpassword'] : '';
			$password_encoded = password_hash($password_decoded, PASSWORD_DEFAULT);
			$address = isset($_POST[$prefix . 'address']) ? $_POST[$prefix . 'address'] : '';
			$city = isset($_POST[$prefix . 'city']) ? $_POST[$prefix . 'city'] : '';
			$state = isset($_POST[$prefix . 'state']) ? $_POST[$prefix . 'state'] : '';
			$zip = isset($_POST[$prefix . 'zip']) ? $_POST[$prefix . 'zip'] : '';
			$dob = isset($_POST[$prefix . 'dob']) ? $_POST[$prefix . 'dob'] : '';
			$ssn = isset($_POST[$prefix . 'ssn']) ? $_POST[$prefix . 'ssn'] : '';
			$gender = isset($_POST[$prefix . 'gender']) ? $_POST[$prefix . 'gender'] : '';
			$emergency_info = isset($_POST[$prefix . 'emergency_info']) ? $_POST[$prefix . 'emergency_info'] : '';
			$ss_type_id = isset($_POST['o_org_type']) ? $_POST['o_org_type'] : '';
			$org_name = isset($_POST['o_org_name']) ? $_POST['o_org_name'] : '';
			$suspended_till = '';
			$stricks = 0;
			$notes = '';
			$notification_status = 0;
			$notification_type = '';
			$created_at = date('Y-m-d H:i:s');
			$updated_at = '';

			if ($this->form_validation->run() == TRUE) {

				$data = [
					'user_name' => $user_name,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'acc_type' => $acc_type,
					'email' => $email,
					'phone' => $phone,
					'password' => $password_encoded,
					'city' => $city,
					'state_id' => $state,
					'address' => $address,
					'zip' => $zip,
					'dob' => $dob,
					'ssn' => $ssn,
					'gender' => $gender,
					'emergency_info' => $emergency_info,
					'ss_type_id' => $ss_type_id,
					'org_name' => $org_name,
					'suspended_till' => $suspended_till,
					'stricks' => $stricks,
					'notes' => $notes,
					'notification_status' => $notification_status,
					'notification_type' => $notification_type,
					'created_at' => $created_at,
					'updated_at' => $updated_at,
				];
				if ($hcp_form_1 == 0) {
					if ($this->UserModel->add_user($data) !== false) {
						$res = [
							'status' => 1,
							'msg' => 'User Added.'
						];
					} else {
						$res = [
							'status' => 0,
							'msg' => 'Something Went Wrong..!!'
						];
					}
				} else {
					$res = [
						'status' => 2,
						'msg' => 'Go Next.'
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
			$this->load->model('SettingsModel');
			$data['ss_types'] = $this->SettingsModel->get_all_ss_type();
			$data['all_usa_states'] = $this->multipleNeedsModel->get_all_usa_states();
			$data['folder'] = 'general_pages';
			$data['template'] = 'signup';
			$data['title'] = 'HWBZ Signup';
			$this->load->view('layout', $data);
		}
	}
	// Custom validation callback function for date of birth
	public function valid_date($str)
	{
		// Parse the date string into a timestamp
		$timestamp = strtotime($str);

		// Check if the date string was valid and it's a valid date
		if ($timestamp === false || !checkdate(date('m', $timestamp), date('d', $timestamp), date('Y', $timestamp))) {
			// Date is not valid
			$this->form_validation->set_message('valid_date', 'Please enter a valid date for {field}.');
			return false;
		}

		// Date is valid
		return true;
	}
	public function login()
	{
		$data['folder'] = 'general_pages';
		$data['template'] = 'login';
		$data['title'] = 'HWBZ Login';
		$this->load->view('layout', $data);
	}
}
