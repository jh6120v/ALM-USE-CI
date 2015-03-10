<?php
define("salt", "cb65b779772a8edb4c62a1b32e2ab673"); //原始CuZ1fho8n7xm
class Account_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getAccountData($act, $pageNum = '', $offset = '', $q = '') {
		if ($act == 'list' || $act == 'search') {
			$this->db->select('a.*, b.title');
			$this->db->from('account AS a');
			$this->db->join('account_group AS b', 'a.groups = b.id');
			if ($act == 'search') {
				$where = "(`a`.`username` LIKE '%" . $q . "%' OR `a`.`name` LIKE '%" . $q . "%')";
				$this->db->where($where);
			}
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
		// 欄位處理
		$password = hash_hmac('md5', $this->input->post('pass1', TRUE), salt);

		$data = array(
			'username' => $this->common->htmlFilter($this->input->post('username')),
			'password' => $password,
			'name' => $this->common->htmlFilter($this->input->post('name')),
			'groups' => $this->common->htmlFilter($this->input->post('groups')),
			'status' => $this->common->htmlFilter($this->input->post('status')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('locked', TRUE) != NULL && $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		$this->db->insert('account', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function eSave() {
		$data = array(
			'name' => $this->common->htmlFilter($this->input->post('name')),
			'groups' => $this->common->htmlFilter($this->input->post('groups')),
			'status' => $this->common->htmlFilter($this->input->post('status')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		// 欄位處理
		if ($this->input->post('pass4', TRUE) != '') {
			$data['password'] = hash_hmac('md5', $this->input->post('pass4', TRUE), salt);
		}
		if ($this->input->post('locked', TRUE) != NULL && $this->session->userdata('acl') == "administration") {
			$data['locked'] = $this->input->post('locked', TRUE);
		}
		$this->db->where(array('groups !=' => 'administration', 'id' => $this->input->post('id', TRUE)));
		$this->db->update('account', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function pSave() {
		$data = array(
			'name' => $this->common->htmlFilter($this->input->post('name')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		if ($this->input->post('pass4', TRUE) != '') {
			$data['password'] = hash_hmac('md5', $this->input->post('pass4', TRUE), salt);
		}
		$this->db->where('id', $this->session->userdata('pID'));
		$this->db->update('account', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function changeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('account', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function delete() {
		$this->db->where(array('locked' => '1', 'id' => $this->input->post('id', TRUE)));
		$this->db->delete('account');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mChangeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->update('account', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mDelete() {
		$this->db->where('locked', '1')->where_in('id', $this->input->post('id', TRUE));
		$this->db->delete('account');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
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
		$password = hash_hmac('md5', $this->input->post('pass3', TRUE), salt);
		return $this->db->from('account')->where(array('password' => $password, 'id' => $this->session->userdata('pID')))->limit(1)->count_all_results();
	}
	public function getRecordTotal() {
		return $this->db->count_all('account_record');
	}
	public function getSearchTotal($q) {
		$this->db->from('account');
		$where = "(`username` LIKE '%" . $q . "%' OR `name` LIKE '%" . $q . "%')";
		$this->db->where($where);
		$this->db->where_not_in('id', $this->session->userdata('pID'));
		$this->db->where('groups!=', 'administration');
		$num = $this->db->count_all_results();

		return $num;
	}
}
