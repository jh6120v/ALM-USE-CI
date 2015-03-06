<?php
class Layout_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getLayoutData($act) {
		if ($act == 'list') {
			$this->db->from('layout');
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else if ($act == 'edit') {
			$query = $this->db->from('layout')->where('id', $this->uri->segment(4))->limit(1)->get();
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	public function getNav() {
		$query = $this->db->select('id,title')->from('nav')->order_by('id', 'DESC')->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
}