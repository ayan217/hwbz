<?php
defined('BASEPATH') or exit('No direct script access allowed');

class userModel extends CI_Model
{
	private $table_name;

	function __construct()
	{
		parent::__construct();
		$this->table_name = TABLE_PREFIX . 'user';
	}

	public function add_user($data)
	{
		if ($this->db->insert($this->table_name, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function add_hcp_docs($data)
	{
		$table = TABLE_PREFIX . 'hcp_docs';

		if ($this->db->insert($table, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function checkUsernameExist($name)
	{
		$this->db->select();
		$this->db->from($this->table_name);
		$this->db->where('user_name', $name);
		$this->db->where('acc_type', 0)->or_where('acc_type', 1);

		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->row();
		}
	}
	public function getadmin($id)
	{
		$this->db->select();
		$this->db->from($this->table_name);
		$this->db->where('user_id', $id);
		$this->db->where('acc_type', 0)->or_where('acc_type', 1);

		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->row();
		}
	}
}
