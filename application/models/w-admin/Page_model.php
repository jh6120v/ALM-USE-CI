<?php
class Page_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getPageData($act, $pageNum = '', $offset = '', $q = '') {
		if ($act == 'list' || $act == 'search') {
			$this->db->from('page');
			if ($act == 'search') {
				$where = "`title` LIKE '%" . $q . "%'";
				$this->db->where($where);
			}
			$this->db->order_by('id', 'DESC');
			$this->db->limit($pageNum, $offset);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else if ($act == 'edit') {
			$query = $this->db->from('page')->where('id', $this->uri->segment(4))->limit(1)->get();
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
		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'tag' => $this->common->htmlFilter($this->input->post('tag')),
			'seoTitle' => $this->common->htmlFilter($this->input->post('seoTitle')),
			'seoKey' => $this->common->htmlFilter($this->input->post('seoKey')),
			'seoDesc' => $this->common->htmlFilter($this->input->post('seoDesc')),
			'status' => $this->common->htmlFilter($this->input->post('status')),
			'body' => $this->input->post('body'),
			'position' => $this->common->htmlFilter($this->input->post('position')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('locked', TRUE) != NULL || $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		if ($this->input->post('position', TRUE) != NULL && $this->input->post('position', TRUE) != 0 && $this->input->post('position', TRUE) != 1) {
			$data['nav'] = $this->common->htmlFilter($this->input->post('nav'));
			$data['content'] = $this->input->post('content');
		}
		$this->db->insert('page', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function eSave() {
		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'tag' => $this->common->htmlFilter($this->input->post('tag')),
			'seoTitle' => $this->common->htmlFilter($this->input->post('seoTitle')),
			'seoKey' => $this->common->htmlFilter($this->input->post('seoKey')),
			'seoDesc' => $this->common->htmlFilter($this->input->post('seoDesc')),
			'status' => $this->common->htmlFilter($this->input->post('status')),
			'body' => $this->input->post('body'),
			'position' => $this->common->htmlFilter($this->input->post('position')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('locked', TRUE) != NULL && $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		if ($this->input->post('position', TRUE) != NULL && $this->input->post('position', TRUE) != 0 && $this->input->post('position', TRUE) != 1) {
			$data['nav'] = $this->common->htmlFilter($this->input->post('nav'));
			$data['content'] = $this->input->post('content');
		} else {
			$data['nav'] = 0;
			$data['content'] = '';
		}

		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('page', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function changeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('page', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function delete() {
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->delete('page');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mChangeStatus() {
		// 檢查查詢結果筆數是否與欲查訊id個數相同
		$num = $this->db->from('page')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
		if ($num != count($this->input->post('id', TRUE))) {
			return FALSE;
		}
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->update('page', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mDelete() {
		// 檢查查詢結果筆數是否與欲查訊id個數相同
		$num = $this->db->from('page')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
		if ($num != count($this->input->post('id', TRUE))) {
			return FALSE;
		}
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->delete('page');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function getListTotal() {
		return $this->db->count_all('page');
	}
	public function getSearchTotal($q) {
		$this->db->from('page');
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
	public function getTagCheckData($act = 'add') {
		if ($act == 'add') {
			return $this->db->from('page')->where('tag', $this->input->post('tag', TRUE))->limit(1)->count_all_results();
		} else if ($act == 'edit') {
			return $this->db->from('page')->where('tag', $this->input->post('tag', TRUE))->where_not_in('id', $this->input->post('id', TRUE))->limit(1)->count_all_results();
		} else {
			return 1;
		}
	}
	public function getNavCheckData() {
		return $this->db->from('nav')->where('id', $this->input->post('nav', TRUE))->limit(1)->count_all_results();
	}
}