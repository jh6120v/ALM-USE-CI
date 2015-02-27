<?php
define("salt", "cb65b779772a8edb4c62a1b32e2ab673"); //原始CuZ1fho8n7xm
class Account_model extends CI_Model {
	public $status = array(
		"open" => array(0, "close", "已開啟", 11),
		"close" => array(1, "open", "已關閉", 10),
		"mOpen" => array(0, 11),
		"mClose" => array(1, 10),
	);
	public function __construct() {
		parent::__construct();
	}
	public function getAccountData($act, $pageNum = '', $offset = '') {
		if ($act == 'list') {
			$this->db->select('a.*, b.title');
			$this->db->from('account AS a');
			$this->db->join('account_group AS b', 'a.groups = b.id');
			$this->db->where_not_in('a.id', $this->session->userdata('pID'));
			$this->db->where('a.groups!=', 'administration');
			$this->db->order_by('a.id', 'ASC');
			$this->db->limit($pageNum, $offset);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else if ($act == 'edit') {
			$query = $this->db->from('account')->where(array('groups !=' => 'administration', 'id' => $this->uri->segment(4)))->limit(1)->get();
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return FALSE;
			}
		} else if ($act == 'personal') {
			$query = $this->db->from('account')->where('id', $this->session->userdata('pID'))->limit(1)->get();
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
		try {
			// 欄位處理
			$password = hash_hmac('md5', $this->input->post('pass1', TRUE), salt);
			$locked = ($this->input->post('locked', TRUE) == NULL || $this->session->userdata('acl') != "administration") ? "1" : $this->input->post('locked', TRUE);

			$data = array(
				'username' => $this->common->htmlFilter($this->input->post('username')),
				'password' => $password,
				'name' => $this->common->htmlFilter($this->input->post('name')),
				'groups' => $this->common->htmlFilter($this->input->post('groups')),
				'status' => $this->common->htmlFilter($this->input->post('status')),
				'locked' => $locked,
				'ip' => $this->input->ip_address(),
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('account', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function eSave() {
		try {
			// 取原資料
			$query = $this->db->select('password, locked')->from('account')->where(array('groups !=' => 'administration', 'id' => $this->input->post('id', TRUE)))->limit(1)->get();
			if ($query->num_rows() > 0) {
				$result = $query->row();
			} else {
				return FALSE;
			}
			// 欄位處理
			$password = ($this->input->post('pass4') != NULL) ? hash_hmac('md5', $this->input->post('pass4', TRUE), salt) : $result->password;
			$locked = ($this->input->post('locked', TRUE) == NULL || $this->session->userdata('acl') != "administration") ? $result->locked : $this->input->post('locked', TRUE);
			$data = array(
				'password' => $password,
				'name' => $this->common->htmlFilter($this->input->post('name')),
				'groups' => $this->common->htmlFilter($this->input->post('groups')),
				'status' => $this->common->htmlFilter($this->input->post('status')),
				'locked' => $locked,
				'ip' => $this->input->ip_address(),
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $this->input->post('id', TRUE));
			$this->db->update('account', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function pSave() {
		try {
			// 取原資料
			$query = $this->db->select('password')->from('account')->where('id', $this->session->userdata('pID'))->limit(1)->get();
			if ($query->num_rows() > 0) {
				$result = $query->row();
			} else {
				return FALSE;
			}
			// 欄位處理
			$password = ($this->input->post('pass4') != NULL) ? hash_hmac('md5', $this->input->post('pass4', TRUE), salt) : $result->password;
			$data = array(
				'password' => $password,
				'name' => $this->common->htmlFilter($this->input->post('name')),
				'ip' => $this->input->ip_address(),
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $this->session->userdata('pID'));
			$this->db->update('account', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function changeStatus() {
		try {
			$data = array(
				'status' => $this->status[$this->uri->segment(3)][0],
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $this->input->post('id', TRUE));
			$this->db->update('account', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function delete() {
		try {
			$this->db->where(array('locked' => '1', 'id' => $this->input->post('id', TRUE)));
			$this->db->delete('account');

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function mChangeStatus() {
		try {
			// 檢查查詢結果筆數是否與欲查訊id個數相同
			$num = $this->db->from('account')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
			if ($num != count($this->input->post('id', TRUE))) {
				return FALSE;
			}
			$data = array(
				'status' => $this->status[$this->uri->segment(3)][0],
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where_in('id', $this->input->post('id', TRUE));
			$this->db->update('account', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function mDelete() {
		try {
			// 檢查查詢結果筆數是否與欲查訊id個數相同
			$num = $this->db->from('account')->where('locked', '1')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
			if ($num != count($this->input->post('id', TRUE))) {
				return FALSE;
			}
			$this->db->where_in('id', $this->input->post('id', TRUE));
			$this->db->delete('account');

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function getRecordData($pageNum = '', $offset = '') {
		$query = $this->db->from('account_record')->order_by('loginTime', 'DESC')->limit($pageNum, $offset)->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function getListTotal() {
		return $this->db->from('account')->where('groups !=', 'administration')->count_all_results();
	}
	public function getGroupsData() {
		$query = $this->db->select('id, title')->from('account_group')->where('status', '0')->order_by('id', 'ASC')->get();
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return FALSE;
		}
	}
	public function getUserCheckData() {
		return $this->db->from('account')->where('username', $this->input->post('username', TRUE))->limit(1)->count_all_results();
	}
	public function getGroupsCheckData() {
		return $this->db->from('account_group')->where(array('id' => $this->input->post('groups', TRUE), 'status' => '0'))->limit(1)->count_all_results();
	}
	public function getOldPassCheckData() {
		// 密碼轉換
		$password = hash_hmac('md5', $this->input->post('pass3'), salt);
		return $this->db->from('account')->where(array('password' => $password, 'id' => $this->session->userdata('pID')))->limit(1)->count_all_results();
	}
	public function getRecordTotal() {
		return $this->db->count_all('account_record');
	}
}