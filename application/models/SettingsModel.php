<?php
defined('BASEPATH') or exit('No direct script access allowed');
class SettingsModel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	public function add_ss_type($data)
	{
		$table = TABLE_PREFIX . 'ss_type';
		if ($this->db->insert($table, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function get_all_ss_type()
	{
		$table = TABLE_PREFIX . 'ss_type';
		$this->db->select();
		$this->db->from($table);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->result();
		}
	}
	public function delete_ss_type($id)
	{
		$table = TABLE_PREFIX . 'ss_type';
		$this->db->where('id', $id);
		if ($this->db->delete($table)) {
			return true;
		} else {
			return false;
		}
	}
	public function update_ss_type($id, $data)
	{
		$table = TABLE_PREFIX . 'ss_type';
		$this->db->where('id', $id);
		if ($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}
	public function add_hcp_service($data)
	{
		$table = TABLE_PREFIX . 'hcp_services';
		if ($this->db->insert($table, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function get_all_hcp_services()
	{
		$table = TABLE_PREFIX . 'hcp_services';
		$this->db->select();
		$this->db->from($table);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->result();
		}
	}
	public function update_hcp_service($id, $data)
	{
		$table = TABLE_PREFIX . 'hcp_services';
		$this->db->where('id', $id);
		if ($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}
	public function delete_hcp_service($id)
	{
		$table = TABLE_PREFIX . 'hcp_services';
		$this->db->where('id', $id);
		if ($this->db->delete($table)) {
			return true;
		} else {
			return false;
		}
	}
}
