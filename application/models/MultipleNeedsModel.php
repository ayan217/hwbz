<?php
defined('BASEPATH') or exit('No direct script access allowed');
class multipleNeedsModel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	public function update_site_meta($meta_key, $data)
	{
		$table = TABLE_PREFIX . 'site_meta';
		$this->db->where('meta_key', $meta_key);
		if ($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}
	public function get_site_meta($meta_key)
	{
		$table = TABLE_PREFIX . 'site_meta';
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('meta_key', $meta_key);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->row();
		}
	}
	public function get_all_usa_states()
	{
		$table = TABLE_PREFIX . 'states';
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
		if ($query->num_rows() == 0) {
			return false;
		} else {
			return $query->result();
		}
	}
	public function get_user_saved_cards()
	{
		$this->config->load('stripe');
		require_once(FCPATH . 'vendor/stripe/stripe-php/init.php');
		\Stripe\Stripe::setApiKey($this->config->item('stripe_secret_key'));

		$customer_id = logged_in_ss_row()->stripe_cust_id;
		if ($customer_id !== null) {

			$customer = \Stripe\Customer::retrieve($customer_id);
			$cards_data = \Stripe\Customer::allSources(
				$customer->id,
				array("object" => "card")
			);
			$cards = $cards_data->data;
		} else {
			$cards = array();
		}
		return $cards;
	}
}
