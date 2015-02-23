<?php
class Home_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function recordsData() {
		$query = $this->db->from('account_record')->where('pID', $this->session->userdata('pID'))->order_by('loginTime', 'DESC')->limit(4)->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
}