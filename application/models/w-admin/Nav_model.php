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
			$this->db->order_by('id', 'DESC');
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
	public function aSave() {
		$this->db->trans_begin();
		// 欄位處理
		$mData = ($this->input->post('mData', TRUE) == NULL) ? serialize(json_decode("[]")) : serialize(json_decode($this->input->post('mData', TRUE)));
		// 檢查是否更新為主選單
		if ($this->input->post('pNav', TRUE) == 0) {
			$data = array(
				'pNav' => '1',
			);
			$this->db->where('pNav', '0');
			$this->db->update('nav', $data);
		}

		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'mData' => $mData,
			'pNav' => $this->common->htmlFilter($this->input->post('pNav')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('nav', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function eSave() {
		$this->db->trans_begin();
		// 欄位處理
		$mData = ($this->input->post('mData', TRUE) == NULL) ? serialize(json_decode("[]")) : serialize(json_decode($this->input->post('mData', TRUE)));
		// 檢查是否更新為主選單
		if ($this->input->post('pNav', TRUE) == 0) {
			$data = array(
				'pNav' => '1',
			);
			$this->db->where('pNav', '0');
			$this->db->update('nav', $data);
		}
		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'mData' => $mData,
			'pNav' => $this->common->htmlFilter($this->input->post('pNav')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('nav', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
		}
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function delete() {
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->delete('nav');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mDelete() {
		// 檢查查詢結果筆數是否與欲查訊id個數相同
		$num = $this->db->from('nav')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
		if ($num != count($this->input->post('id', TRUE))) {
			return FALSE;
		}
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->delete('nav');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
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