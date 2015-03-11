<?php
class Category_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getCategoryData($act, $pageNum = '', $offset = '', $q = '') {
		if ($act == 'list' || $act == 'search') {
			$this->db->from('category');
			if ($act == 'search') {
				$where = "`title` LIKE '%" . $q . "%'";
				$this->db->where($where);
			}
			$this->db->order_by('id', 'ASC');
			$this->db->limit($pageNum, $offset);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else if ($act == 'edit') {
			$query = $this->db->from('category')->where('id', $this->uri->segment(4))->limit(1)->get();
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
		$this->db->trans_begin();
		// 欄位處理
		$mData = ($this->input->post('mData', TRUE) == NULL) ? serialize(json_decode("[]")) : serialize(json_decode($this->input->post('mData', TRUE)));
		$data = array(
			'mData' => $mData,
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('category', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function getListTotal() {
		return $this->db->count_all('category');
	}
	public function getSearchTotal($q) {
		$this->db->from('category');
		$where = "`title` LIKE '%" . $q . "%'";
		$this->db->where($where);
		$num = $this->db->count_all_results();

		return $num;
	}
}