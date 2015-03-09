<?php
class Sidebar_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getSidebarData($act, $pageNum = '', $offset = '', $q = '') {
		if ($act == 'list' || $act == 'search') {
			$this->db->from('sidebar');
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
			$query = $this->db->from('sidebar')->where('id', $this->uri->segment(4))->limit(1)->get();
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	public function aSave() {
		// 欄位處理
		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'position' => $this->common->htmlFilter($this->input->post('position')),
			'nav' => $this->common->htmlFilter($this->input->post('nav')),
			'content' => $this->input->post('content'),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('locked', TRUE) != NULL && $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		$this->db->insert('sidebar', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function eSave() {
		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'position' => $this->common->htmlFilter($this->input->post('position')),
			'nav' => $this->common->htmlFilter($this->input->post('nav')),
			'content' => $this->input->post('content'),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('locked', TRUE) != NULL || $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('sidebar', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function delete() {
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->delete('sidebar');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mDelete() {
		// 檢查查詢結果筆數是否與欲查訊id個數相同
		$num = $this->db->from('sidebar')->where('locked', '1')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
		if ($num != count($this->input->post('id', TRUE))) {
			return FALSE;
		}
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->delete('sidebar');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function getListTotal() {
		return $this->db->count_all('sidebar');
	}
	public function getSearchTotal($q) {
		$this->db->from('sidebar');
		$where = "`title` LIKE '%" . $q . "%'";
		$this->db->where($where);
		$num = $this->db->count_all_results();

		return $num;
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