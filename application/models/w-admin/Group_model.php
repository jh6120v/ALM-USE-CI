<?php
class Group_model extends CI_Model {
	public $aclList = array(
		"控制台" => array(
			"acl" => "console",
			"action" => array(
				array(
					"name" => "首頁",
					"acl" => "home",
					"list_acl" => array(

					),
				),
				array(
					"name" => "備註板",
					"acl" => "remark",
					"list_acl" => array(
						"修改" => "remark-edit",
					),
				),
			),
		),
		"系統設置" => array(
			"acl" => "system",
			"action" => array(
				array(
					"name" => "基本設置",
					"acl" => "setting",
					"list_acl" => array(
						"修改" => "setting-edit",
					),
				),
				array(
					"name" => "排序設定",
					"acl" => "sort",
					"list_acl" => array(
						"修改" => "sort-edit",
					),
				),
			),
		),
		"版面設置" => array(
			"acl" => "layouts",
			"action" => array(
				array(
					"name" => "側欄設定",
					"acl" => "sidebar",
					"list_acl" => array(
						"新增" => "sidebar-add",
						"修改" => "sidebar-edit",
						"刪除" => "sidebar-del",
					),
				),
				array(
					"name" => "選單管理",
					"acl" => "nav",
					"list_acl" => array(
						"新增" => "nav-add",
						"修改" => "nav-edit",
						"刪除" => "nav-del",
					),
				),
			),
		),
		"使用者" => array(
			"acl" => "users",
			"action" => array(
				array(
					"name" => "帳號管理",
					"acl" => "account",
					"list_acl" => array(
						"新增" => "account-add",
						"修改" => "account-edit",
						"刪除" => "account-del",
					),
				),
				array(
					"name" => "登入紀錄",
					"acl" => "account-record",
					"list_acl" => array(),
				),
				array(
					"name" => "群組管理",
					"acl" => "group",
					"list_acl" => array(
						"新增" => "group-add",
						"修改" => "group-edit",
						"刪除" => "group-del",
					),
				),
			),
		),
		"頁面" => array(
			"acl" => "pages",
			"action" => array(
				array(
					"name" => "頁面管理",
					"acl" => "page",
					"list_acl" => array(
						"新增" => "page-add",
						"修改" => "page-edit",
						"刪除" => "page-del",
					),
				),
			),
		),
		"功能" => array(
			"acl" => "function",
			"action" => array(
				array(
					"name" => "橫幅廣告",
					"acl" => "banner",
					"list_acl" => array(
						"新增" => "banner-add",
						"修改" => "banner-edit",
						"刪除" => "banner-del",
					),
				),
				array(
					"name" => "分類管理",
					"acl" => "category",
					"list_acl" => array(
						"修改" => "category-edit",
					),
				),
				array(
					"name" => "設計作品",
					"acl" => "works",
					"list_acl" => array(
						"新增" => "works-add",
						"修改" => "works-edit",
						"刪除" => "works-del",
					),
				),
			),
		),
		"BETA" => array(
			"acl" => "beta",
			"action" => array(
				array(
					"name" => "相簿分類",
					"acl" => "album-category",
					"list_acl" => array(
						"新增" => "album-category-add",
						"修改" => "album-category-edit",
						"刪除" => "album-category-del",
					),
				),
				array(
					"name" => "相簿",
					"acl" => "album",
					"list_acl" => array(
						"新增" => "album-add",
						"修改" => "album-edit",
						"刪除" => "album-del",
					),
				),
			),
		),
	);
	public function __construct() {
		parent::__construct();
	}
	public function getGroupData($act, $pageNum = '', $offset = '', $q = '') {
		if ($act == 'list' || $act == 'search') {
			$this->db->from('account_group');
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
			$query = $this->db->from('account_group')->where('id', $this->uri->segment(4))->limit(1)->get();
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
		$acl = ($this->input->post('acl', TRUE) == NULL) ? serialize(array()) : serialize($this->input->post('acl', TRUE));
		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'acl' => $acl,
			'status' => $this->common->htmlFilter($this->input->post('status')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->insert('account_group', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function eSave() {
		// 欄位處理
		$acl = ($this->input->post('acl', TRUE) == NULL) ? serialize(array()) : serialize($this->input->post('acl', TRUE));
		$data = array(
			'title' => $this->common->htmlFilter($this->input->post('title')),
			'acl' => $acl,
			'status' => $this->common->htmlFilter($this->input->post('status')),
			'ip' => $this->input->ip_address(),
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('account_group', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function changeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('account_group', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function delete() {
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->delete('account_group');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mChangeStatus() {
		$data = array(
			'status' => $this->message->status[$this->uri->segment(3)][0],
			'updateTime' => date('Y-m-d H:i:s'),
		);
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->update('account_group', $data);

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function mDelete() {
		$this->db->where_in('id', $this->input->post('id', TRUE));
		$this->db->delete('account_group');

		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	public function getListTotal() {
		return $this->db->count_all('account_group');
	}
	public function getSearchTotal($q) {
		$this->db->from('account_group');
		$where = "`title` LIKE '%" . $q . "%'";
		$this->db->where($where);
		$num = $this->db->count_all_results();

		return $num;
	}
}
