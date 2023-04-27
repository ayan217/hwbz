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
	public function get_hcp_service($id)
	{
		$table = TABLE_PREFIX . 'hcp_services';
		$this->db->select();
		$this->db->from($table);
		$this->db->where('id', $id);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->row();
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
	public function add_hourly_rate($data)
	{
		$table = TABLE_PREFIX . 'hourly_rate';
		if ($this->db->insert($table, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	public function get_all_hourly_rates()
	{
		$table = TABLE_PREFIX . 'hourly_rate';
		$state_table = TABLE_PREFIX . 'states';
		$services_table = TABLE_PREFIX . 'hcp_services';
		$this->db->select($table . '.*, ' . $state_table . '.id as state_id, ' . $state_table . '.Name as state_name, ' . $state_table . '.Code as state_code, ' . $services_table . '.id as service_id, ' . $services_table . '.name as service_name');
		$this->db->from($table);
		$this->db->join($state_table, $state_table . '.id = ' . $table . '.state_id', 'left');
		$this->db->join($services_table, $services_table . '.id = ' . $table . '.service_id', 'left');
		$this->db->order_by($table . '.id', 'desc');
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->result();
		}
	}

	public function get_hourly_rate_by_service($service_id, $state_id)
	{
		$table = TABLE_PREFIX . 'hourly_rate';
		$this->db->select();
		$this->db->from($table);
		$this->db->where('state_id', $state_id);
		$this->db->where('service_id', $service_id);
		$query = $this->db->get(); {
			if ($query->num_rows() == 0) {
				return false;
			} else {
				return $query->row();
			}
		}
	}

	public function delete_hourly_rate($id)
	{
		$table = TABLE_PREFIX . 'hourly_rate';
		$this->db->where('id', $id);
		if ($this->db->delete($table)) {
			return true;
		} else {
			return false;
		}
	}
	public function update_hourly_rate($id, $data)
	{
		$table = TABLE_PREFIX . 'hourly_rate';
		$this->db->where('id', $id);
		if ($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}
}
