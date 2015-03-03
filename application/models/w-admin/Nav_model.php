<?php
class Nav_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getNavData($act, $pageNum = '', $offset = '', $q = '') {
		if ($act == 'list' || $act == 'search') {
			$this->db->from('nav');
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
			$query = $this->db->from('nav')->where('id', $this->uri->segment(4))->limit(1)->get();
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
		return $this->db->count_all('nav');
	}
	public function getSearchTotal($q) {
		$this->db->from('nav');
		$where = "`title` LIKE '%" . $q . "%'";
		$this->db->where($where);
		$num = $this->db->count_all_results();

		return $num;
	}
	public function getPrimaryNavNow() {
		$query = $this->db->select('title')->from('nav')->where('pNav', '0')->limit(1)->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return FALSE;
		}
	}
}