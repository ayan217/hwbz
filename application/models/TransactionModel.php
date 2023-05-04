<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransactionModel extends CI_Model
{
	private $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = TABLE_PREFIX . 'transaction';
	}

	public function add($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function get_transactionsfor_ss($filter)
	{
		$user_id = logged_in_ss_row()->user_id;
		$job_table = TABLE_PREFIX . 'jobs';
		$user_table = TABLE_PREFIX . 'user';
		$this->db->select($this->table_name . '.*, ' . $job_table . '.service_ids, ' . $user_table . '.stripe_cust_id');
		$this->db->from($this->table_name);
		$this->db->join($job_table, $job_table . '.job_id = ' . $this->table_name . '.job_id', 'left');
		$this->db->join($user_table, $user_table . '.user_id = ' . $this->table_name . '.user_id', 'left');
		$this->db->where($this->table_name . '.user_id', $user_id);
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
