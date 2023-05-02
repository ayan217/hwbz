<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(FCPATH . 'vendor/stripe/stripe-php/init.php');
class calender extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		ss_login_check();
		$this->load->model('jobModel');
	}
	public function index()
	{
		$data['folder'] = 'ss';
		$data['title'] = 'HWBZ Calender';
		$data['template'] = 'calender';
		$data['user_data'] = logged_in_ss_row();
		$this->load->view('layout', $data);
	}
	public function get_calendar_data($year = null, $month = null)
	{
		$all_jobs = $this->jobModel->get_jobs();
		foreach ($all_jobs as $job) {
			if ($job->status == 0) {
				$background = '#f78628';
			} elseif ($job->status == 1) {
				$background = '#07d358';
			} elseif ($job->status == 2) {
				$background = '#e72f31';
			}
			$location = $job->city . ',(' . $job->Code . ')';
			$shift_start = explode('-', $job->shift);
			$job_events[] = [
				'title' => $shift_start[0],
				'start' => $job->job_date,
				'end' => $job->job_date,
				'allDay' => true,
				'backgroundColor' => $background,
				'location' => $location
			];
		}

		echo json_encode($job_events);
	}
}
