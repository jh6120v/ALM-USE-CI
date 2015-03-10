<?php
class WorksCategory_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getWorksCategoryData($act, $pageNum = '', $offset = '', $q = '', $sort = FALSE) {
		if ($act == 'list' || $act == 'search') {
			$this->db->from('works_category');
			if ($act == 'search') {
				$where = "`catName` LIKE '%" . $q . "%'";
				$this->db->where($where);
			}
			if ($sort != FALSE) {
				$this->db->order_by($sort->sort, $sort->orderBy);
				$this->db->order_by($sort->sort2, $sort->orderBy2);
			} else {
				$this->db->order_by('catID', 'DESC');
			}
			$this->db->limit($pageNum, $offset);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else if ($act == 'edit') {
			$query = $this->db->from('works_category')->where('catID', $this->uri->segment(4))->limit(1)->get();
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
		if ($this->input->post('sort', TRUE) == 0) {
			$query = $this->db->select_max('sort')->from('works_category')->get();
			if ($query->num_rows() > 0) {
				$result = $query->row();
				$sort = $result->sort + 1;
			} else {
				$sort = 1;
			}
		} else {
			$sort = $this->input->post('sort', TRUE);
		}
		$data = array(
			'catName' => $this->common->htmlFilter($this->input->post('catName')),
			'sort' => $sort,
			'status' => $this->input->post('status', TRUE),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('locked', TRUE) != NULL && $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		$this->db->insert('works_category', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function eSave() {
		$data = array(
			'catName' => $this->common->htmlFilter($this->input->post('catName')),
			'sort' => $this->common->htmlFilter($this->input->post('sort')),
			'status' => $this->input->post('status', TRUE),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('locked', TRUE) != NULL && $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		$this->db->where('catID', $this->input->post('catID', TRUE));
		$this->db->update('works_category', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function changeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('catID', $this->input->post('id', TRUE));
		$this->db->update('works_category', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function delete() {
		$this->db->where(array('locked' => '1', 'catID' => $this->input->post('id', TRUE)));
		$this->db->delete('works_category');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mChangeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where_in('catID', $this->input->post('id', TRUE));
		$this->db->update('works_category', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mDelete() {
		$this->db->where('locked', '1')->where_in('catID', $this->input->post('id', TRUE));
		$this->db->delete('works_category');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mSave($orderBy, $sort = FALSE, $id = array()) {
		if ($sort != FALSE) {
			$this->db->trans_begin();

			foreach ($id as $v) {
				$data = array(
					'sort' => $sort,
				);
				$this->db->where('catID', substr($v, strrpos($v, "-") + 1));
				$this->db->update('works_category', $data);

				$sort = ($orderBy == "ASC") ? ($sort + 1) : ($sort - 1);
			}

			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				return FALSE;
			} else {
				$this->db->trans_commit();
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}
	public function getListTotal() {
		return $this->db->count_all('works_category');
	}
	public function getSearchTotal($q) {
		$this->db->from('works_category');
		$where = "`catName` LIKE '%" . $q . "%'";
		$this->db->where($where);
		$num = $this->db->count_all_results();

		return $num;
	}
}