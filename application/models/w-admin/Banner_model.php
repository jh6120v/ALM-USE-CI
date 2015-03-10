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
	public function aSave($fInfo) {
		if ($this->input->post('sort', TRUE) == 0) {
			$query = $this->db->select_max('sort')->from('banner')->get();
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
			'url' => $this->common->htmlFilter($this->input->post('url')),
			'fileName' => $fInfo['file_name'],
			'sort' => $sort,
			'status' => $this->input->post('status', TRUE),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('banner', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function eSave($fInfo) {
		$data = array(
			'url' => $this->common->htmlFilter($this->input->post('url')),
			'sort' => $this->common->htmlFilter($this->input->post('sort')),
			'status' => $this->input->post('status', TRUE),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($fInfo != FALSE) {
			$data['fileName'] = $fInfo['file_name'];
		}
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('banner', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function changeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('banner', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function delete() {
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->delete('banner');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mChangeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->update('banner', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mDelete() {
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->delete('banner');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mSave($orderBy, $sort = FALSE, $id = array()) {
		if ($sort != FALSE) {
			$this->db->trans_begin();

			foreach ($id as $v) {
				$data = array(
					'sort' => $sort,
				);
				$this->db->where('id', substr($v, strrpos($v, "-") + 1));
				$this->db->update('banner', $data);

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
		return $this->db->count_all('banner');
	}
	public function getSearchTotal($q) {
		$this->db->from('banner');
		$where = "`url` LIKE '%" . $q . "%'";
		$this->db->where($where);
		$num = $this->db->count_all_results();

		return $num;
	}
	public function getOldFileName() {
		$query = $this->db->select('fileName')->from('banner')->where('id', $this->input->post('id', TRUE))->limit(1)->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return FALSE;
		}
	}
	public function getMultipleOldFileName() {
		$query = $this->db->select('fileName')->from('banner')->where_in('id', $this->input->post('id', TRUE))->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
}