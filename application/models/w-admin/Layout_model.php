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
		if ($this->input->post('position', TRUE) != 0) {
			$nav = $this->common->htmlFilter($this->input->post('nav'));
			$content = $this->input->post('content');
		} else {
			$nav = 0;
			$content = '';
		}
		$data = array(
			'seoTitle' => $this->common->htmlFilter($this->input->post('seoTitle')),
			'seoKey' => $this->common->htmlFilter($this->input->post('seoKey')),
			'seoDesc' => $this->common->htmlFilter($this->input->post('seoDesc')),
			'position' => $this->common->htmlFilter($this->input->post('position')),
			'nav' => $nav,
			'content' => $content,
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
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