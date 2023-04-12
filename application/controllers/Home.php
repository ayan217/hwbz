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
		$data['folder'] = 'general_pages';
		$data['template'] = 'signup';
		$data['title'] = 'HWBZ Signup';
		$this->load->view('layout', $data);
	}

	public function login()
	{
		$data['folder'] = 'general_pages';
		$data['template'] = 'login';
		$data['title'] = 'HWBZ Login';
		$this->load->view('layout', $data);
	}
}
