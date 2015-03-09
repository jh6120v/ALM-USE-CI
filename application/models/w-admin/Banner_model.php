<?php
class Banner_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getBannerData($act, $pageNum = '', $offset = '', $q = '', $sort = FALSE) {
		if ($act == 'list' || $act == 'search') {
			$this->db->from('banner');
			if ($act == 'search') {
				$where = "`url` LIKE '%" . $q . "%'";
				$this->db->where($where);
			}
			if ($sort != FALSE) {
				$this->db->order_by($sort->sort, $sort->orderBy);
				$this->db->order_by($sort->sort2, $sort->orderBy2);
			} else {
				$this->db->order_by('id', 'DESC');
			}
			$this->db->limit($pageNum, $offset);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else if ($act == 'edit') {
			$query = $this->db->from('banner')->where('id', $this->uri->segment(4))->limit(1)->get();
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	public function getListTotal() {
		return $this->db->count_all('banner');
	}
	public function getSearchTotal($q) {
		$this->db->from('banner');
		$where = "`url` LIKE '%" . $q . "%'";
		$this->db->where($where);
		$num = $this->db->count_all_results();

		return $num;
	}
}