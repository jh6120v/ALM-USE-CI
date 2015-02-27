<?php
class Remark_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getRemarkData() {
		$query = $this->db->select('id, body')->from('remark')->limit(1)->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return FALSE;
		}
	}
	public function eSave() {
		try {
			$data = array(
				'body' => $this->input->post('content'),
				'ip' => $this->input->ip_address(),
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $this->input->post('id', TRUE));
			$this->db->update('remark', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
}