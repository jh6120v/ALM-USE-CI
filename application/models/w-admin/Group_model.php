<?php
class Group_model extends CI_Model {
	public $aclList = array(
		"控制台" => array(
			"acl" => "console",
			"action" => array(
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
					"name" => "版面管理",
					"acl" => "layout",
					"list_acl" => array(
						"修改" => "layout-edit",
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
			),
		),
		"頁面" => array(
			"acl" => "main",
			"action" => array(
				array(
					"name" => "頁面管理",
					"acl" => "pages",
					"list_acl" => array(
						"新增" => "pages-add",
						"修改" => "pages-edit",
						"刪除" => "pages-del",
					),
				),
				array(
					"name" => "分類管理",
					"acl" => "category",
					"list_acl" => array(
						"新增" => "category-add",
						"修改" => "category-edit",
						"刪除" => "category-del",
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
					"name" => "設計作品分類",
					"acl" => "works-category",
					"list_acl" => array(
						"新增" => "works-category-add",
						"修改" => "works-category-edit",
						"刪除" => "works-category-del",
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
		try {
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
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function eSave() {
		try {
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
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function changeStatus() {
		try {
			$data = array(
				'status' => $this->message->status[$this->uri->segment(3)][0],
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $this->input->post('id', TRUE));
			$this->db->update('account_group', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function delete() {
		try {
			$this->db->where('id', $this->input->post('id', TRUE));
			$this->db->delete('account_group');

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function mChangeStatus() {
		try {
			// 檢查查詢結果筆數是否與欲查訊id個數相同
			$num = $this->db->from('account_group')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
			if ($num != count($this->input->post('id', TRUE))) {
				return FALSE;
			}
			$data = array(
				'status' => $this->message->status[$this->uri->segment(3)][0],
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where_in('id', $this->input->post('id', TRUE));
			$this->db->update('account_group', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function mDelete() {
		try {
			// 檢查查詢結果筆數是否與欲查訊id個數相同
			$num = $this->db->from('account_group')->where_in('id', $this->input->post('id', TRUE))->count_all_results();
			if ($num != count($this->input->post('id', TRUE))) {
				return FALSE;
			}
			$this->db->where_in('id', $this->input->post('id', TRUE));
			$this->db->delete('account_group');

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
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
