<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		ss_login_check();
	}
	public function index()
	{
		$data['folder'] = 'ss';
		$data['title'] = 'HWBZ SS Dashboard';
		$data['template'] = 'dashboard';
		$data['user_data'] = logged_in_ss_row();
		$this->load->view('layout', $data);
	}
}
