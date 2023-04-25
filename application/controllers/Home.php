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
				if ($hcp_form_1 == 0 && $user_type_raw == HCP) {
					$res = [
						'status' => 2,
						'msg' => 'Go Next.'
					];
				} else {
					$inserted_user_id = $this->UserModel->add_user($data);
					if ($inserted_user_id !== false) {
						//hcp file uploads
						if ($user_type_raw == HCP) {
							$hcp_fields = array('dl' => 'Driver\'s License or State ID', 'acl' => 'Active Professional License', 'abc' => 'Active BLS Card', 'covid' => 'Covid-19 Vaccine Card or exemption letter', 'phy' => 'Physical', 'tb' => 'TB test result or negative chest X-Ray', 'bc' => 'Background Check', 'ssc' => 'Social Security Card', 'fc' => 'Fire Card', 'pli' => 'Professional Liability Card');
							$error = '';
							foreach ($hcp_fields as $hcp_field => $field_name) {

								if (!empty($_FILES[$hcp_field]['name'])) {

									$_FILES['file']['name'] = $_FILES[$hcp_field]['name'];
									$_FILES['file']['type'] = $_FILES[$hcp_field]['type'];
									$_FILES['file']['tmp_name'] = $_FILES[$hcp_field]['tmp_name'];
									$_FILES['file']['error'] = $_FILES[$hcp_field]['error'];
									$_FILES['file']['size'] = $_FILES[$hcp_field]['size'];

									$file_extension = pathinfo($_FILES[$hcp_field]['name'], PATHINFO_EXTENSION);
									$filename = $inserted_user_id . '_' . $hcp_field . '_' . time() . '.' . $file_extension;

									$uploadPath = HCP_SIGNUP_DOCS;
									$config['upload_path'] = $uploadPath;
									$config['allowed_types'] = '*';
									$config['max_size'] = 0;
									$config['file_name'] = $filename;

									$this->upload->initialize($config);

									if ($this->upload->do_upload('file')) {

										$hcp_doc_data = [
											'user_id' => $inserted_user_id,
											'file' => $filename,
											'doc_name' => $field_name
										];
										$this->UserModel->add_hcp_docs($hcp_doc_data);
									} else {
										$error = $this->upload->display_errors();
									}
								}
							}
						}
						//hcp file uploads

						if ($user_type_raw == PATIENT || $user_type_raw == ORG) {
							require_once(FCPATH . 'vendor/stripe/stripe-php/init.php');
							$this->config->load('stripe');
							\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));

							$customer = \Stripe\Customer::create([
								'name' => $first_name . ' ' . $last_name,
								'email' => $email,
							]);

							$cust_id = $customer->id;
							$stripe_cust_id = [
								'stripe_cust_id' => $cust_id
							];
							$this->UserModel->update_user($stripe_cust_id, $inserted_user_id);
						}
						$res = [
							'status' => 1,
							'msg' => 'User Added.',
							// 'error' => $error
						];
					} else {
						$res = [
							'status' => 0,
							'msg' => 'Something Went Wrong..!!'
						];
					}
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
		if ($this->input->post()) {
			$name     = $this->input->post('username');
			$password = $this->input->post('password');
			//0 means non admin 1 means admin
			if ($nameExist = $this->UserModel->checkUsernameExist($name, 0)) {
				if (password_verify($password, $nameExist->password)) {
					$sess_array = array(
						'user_id'  => $nameExist->user_id,
						'user_name' => $nameExist->first_name . ' ' . $nameExist->last_name
					);
					$acc_type = $nameExist->acc_type;
					if ('USER-' . $acc_type == HCP) {
						$this->session->set_userdata('hcp_data', $sess_array);
						redirect('hcp', 'refresh');
					} elseif ('USER-' . $acc_type == ORG or 'USER-' . $acc_type == PATIENT) {
						$this->session->set_userdata('ss_data', $sess_array);
						redirect('ss', 'refresh');
					}
				} else {
					$this->session->set_flashdata('log_err', 'Invalid Password !!');
					redirect($_SERVER['HTTP_REFERER']);
					// echo 'psw galat hay';
				}
			} else {
				$this->session->set_flashdata('log_err', 'Invalid Username !!');
				redirect($_SERVER['HTTP_REFERER']);
				// echo 'username galat hay';
			}
		} else {
			$data['folder'] = 'general_pages';
			$data['template'] = 'login';
			$data['title'] = 'HWBZ Login';
			$this->load->view('layout', $data);
		}
	}
	public function thankyou()
	{
		$data['folder'] = 'general_pages';
		$data['template'] = 'thankyou';
		$data['title'] = 'HWBZ Thank You';
		$this->load->view('layout', $data);
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('login', 'refresh');
	}
}
