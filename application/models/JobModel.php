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
}
