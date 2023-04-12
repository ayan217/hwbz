<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		admin_login_check();
	}
	public function index()
	{
		$data['folder'] = 'admin';
		$data['template'] = 'dashboard';
		$data['title'] = 'HWBZ Admin Dashboard';
		$data['admin_data'] = logged_in_admin_row();
		$this->load->view('layout', $data);
	}
}
