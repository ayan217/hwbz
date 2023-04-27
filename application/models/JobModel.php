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
	public function get_all_job()
	{
		$state_table = TABLE_PREFIX . 'states';
		$this->db->select($this->table_name . '.*, ' . $state_table . '.Code');
		$this->db->from($this->table_name);
		$this->db->join($state_table, $state_table . '.id = ' . $this->table_name . '.state_id', 'left');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->result();
		}
	}
}
