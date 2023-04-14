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

			$user_type_raw = $this->input->post('user_type');
			$user_type = substr($user_type_raw, strpos($user_type_raw, "-") + 1);
			if ($user_type_raw == PATIENT) {
				$prefix = 'p_';
				$this->form_validation->set_rules(
					'p_username',
					'Username',
					'required|min_length[3]|max_length[12]|is_unique[hwbz_user.user_name]',
					array(
						'required'      => 'You have not provided %s.',
						'is_unique'     => 'This %s already exists.'
					)
				);
				$this->form_validation->set_rules('p_fname', 'First Name', 'required');
				$this->form_validation->set_rules('p_lname', 'Last Name', 'required');
				$this->form_validation->set_rules('p_password', 'Password', 'trim|required|min_length[8]');
				$this->form_validation->set_rules('p_cpassword', 'Password Confirmation', 'trim|required|matches[p_password]');
				$this->form_validation->set_rules('p_email', 'Email', 'required|is_unique[hwbz_user.email]');
				
			} elseif ($user_type_raw == ORG) {
				$prefix = 'o_';
			} elseif ($user_type_raw == HCP) {
				$prefix = 'h_';
			}

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
					'status' => 0,
					// 'msg' => var_dump($_POST) . validation_errors()
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

	public function login()
	{
		$data['folder'] = 'general_pages';
		$data['template'] = 'login';
		$data['title'] = 'HWBZ Login';
		$this->load->view('layout', $data);
	}
}
