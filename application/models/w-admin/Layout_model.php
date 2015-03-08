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
	public function eSave() {
		$data = array(
			'position' => $this->common->htmlFilter($this->input->post('position')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('position', TRUE) != 1) {
			$data['nav'] = $this->common->htmlFilter($this->input->post('nav'));
			$data['content'] = $this->input->post('content');
		} else {
			$data['nav'] = 0;
			$data['content'] = '';
		}
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('layout', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function getNav() {
		$query = $this->db->select('id,title')->from('nav')->order_by('id', 'DESC')->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function getNavCheckData() {
		return $this->db->from('nav')->where('id', $this->input->post('nav', TRUE))->limit(1)->count_all_results();
	}
}