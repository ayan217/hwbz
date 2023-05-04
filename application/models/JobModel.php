<?php
defined('BASEPATH') or exit('No direct script access allowed');

class jobModel extends CI_Model
{
	private $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = TABLE_PREFIX . 'jobs';
	}

	public function add($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function get_jobs($type = null)
	{
		$user_id = logged_in_ss_row()->user_id;
		$state_table = TABLE_PREFIX . 'states';
		$this->db->select($this->table_name . '.*, ' . $state_table . '.Code');
		$this->db->from($this->table_name);
		$this->db->join($state_table, $state_table . '.id = ' . $this->table_name . '.state_id', 'left');
		if ($type !== null) {
			$this->db->where($this->table_name . '.status', $type);
		}
		// $this->db->where($this->table_name . '.cancel', 0);
		$this->db->where($this->table_name . '.ss_id', $user_id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->result();
		}
	}
	public function get_the_job($job_id)
	{
		$state_table = TABLE_PREFIX . 'states';
		$this->db->select($this->table_name . '.*, ' . $state_table . '.Code');
		$this->db->from($this->table_name);
		$this->db->where($this->table_name . '.id', $job_id);
		$this->db->join($state_table, $state_table . '.id = ' . $this->table_name . '.state_id', 'left');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->row();
		}
	}
	public function update_job($data, $id)
	{
		$this->db->where('id', $id);
		if ($this->db->update($this->table_name, $data)) {
			return true;
		} else {
			return false;
		}
	}
	public function get_bookings($filter)
	{
		$user_id = logged_in_ss_row()->user_id;
		$state_table = TABLE_PREFIX . 'states';
		$user_table = TABLE_PREFIX . 'user';
		$this->db->select($this->table_name . '.*, ' . $state_table . '.Code, ' . $user_table . '.first_name, ' . $user_table . '.last_name');
		$this->db->from($this->table_name);
		$this->db->join($state_table, $state_table . '.id = ' . $this->table_name . '.state_id', 'left');
		$this->db->join($user_table, $user_table . '.user_id = ' . $this->table_name . '.hcp_id', 'left');
		$this->db->where($this->table_name . '.hcp_id IS NOT NULL');
		$this->db->where($this->table_name . '.ss_id', $user_id);
		if ($filter !== null) {
			$this->db->where($filter);
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->result();
		}
	}
	
}
