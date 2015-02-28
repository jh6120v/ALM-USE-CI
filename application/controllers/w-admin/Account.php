<?php
class Account extends CI_Controller {
	public $pageNum = 15;
	public function __construct() {
		parent::__construct();
		$this->load->model('w-admin/account_model');
		// 判斷是否為登入狀態
		if ($this->common->checkLoginStatus() == FALSE) {
			if ($this->input->is_ajax_request()) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][1],
				));
			} else {
				redirect('/w-admin', 'refresh');
			}
		}
		// 非搜尋頁面註銷keywords
		if ($this->uri->segment(3) != 'search') {
			$this->session->unset_userdata('keywords');
		}
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('account') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('users', 'account');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function search() {
		// 取資料
		$data['content'] = $this->getListContent('search');

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('users', 'account');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function add() {
		// 檢查是否有權限
		if ($this->common->checkLimits('account-add') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('users', 'account-add');
		$content = $this->getAddFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	// 新增儲存
	public function aSave() {
		$this->load->library('form_validation');
		if ($this->input->is_ajax_request()) {
			//檢查是否有權限
			if ($this->common->checkLimits('account-add') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('username', '使用者名稱', 'required|min_length[5]|callback_usernameCheck');
			$this->form_validation->set_rules('pass1', '密碼', 'required|min_length[5]|matches[pass2]');
			$this->form_validation->set_rules('pass2', '確認密碼', 'required|min_length[5]');
			$this->form_validation->set_rules('name', '名稱', 'required');
			$this->form_validation->set_rules('groups', '群組', 'required|numeric|callback_groupsCheck');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric');
			if ($this->session->userdata('acl') == 'administration') {
				$this->form_validation->set_rules('locked', '鎖定', 'required|numeric');
			}
			if ($this->form_validation->run()) {
				$result = $this->account_model->aSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][5],
						"url" => '/w-admin/account',
					));
				} else {
					$this->message->getAjaxMsg(array(
						"success" => FALSE,
						"msg" => $this->message->msg['public'][8],
					));
				}
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => validation_errors(),
				));
			}
		}
	}
	public function edit() {
		// 檢查是否有權限
		if ($this->common->checkLimits('account-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('users', 'account');
		$content = $this->getEditFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	// 修改儲存
	public function eSave() {
		if ($this->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->common->checkLimits('account-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$this->load->library('form_validation');
			// 檢查必要欄位是否填寫
			if ($this->input->post('pass4', TRUE) != '') {
				$this->form_validation->set_rules('pass4', '密碼', 'required|min_length[5]|matches[pass5]');
				$this->form_validation->set_rules('pass5', '確認密碼', 'required|min_length[5]');
			}
			$this->form_validation->set_rules('name', '名稱', 'required');
			$this->form_validation->set_rules('groups', '群組', 'required|numeric|callback_groupsCheck');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric');
			if ($this->session->userdata('acl') == 'administration') {
				$this->form_validation->set_rules('locked', '鎖定', 'required|numeric');
			}
			if ($this->form_validation->run()) {
				$result = $this->account_model->eSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/account/' . $this->input->post('page', TRUE),
					));
				} else {
					$this->message->getAjaxMsg(array(
						"success" => FALSE,
						"msg" => $this->message->msg['public'][8],
					));
				}
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => validation_errors(),
				));
			}
		}
	}
	public function personal() {
		// 取資料
		$menu = $this->common->getMenuContent('', '');
		$content = $this->getPersonalFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	public function pSave() {
		if ($this->input->is_ajax_request()) {
			$this->load->library('form_validation');
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('pass3', '舊密碼', 'required|min_length[5]|callback_oldPassCheck');
			if ($this->input->post('pass4', TRUE) != '') {
				$this->form_validation->set_rules('pass4', '密碼', 'required|min_length[5]|matches[pass5]');
				$this->form_validation->set_rules('pass5', '確認密碼', 'required|min_length[5]');
			}
			$this->form_validation->set_rules('name', '名稱', 'required');

			if ($this->form_validation->run()) {
				$result = $this->account_model->pSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['account'][11],
						"url" => '/w-admin/logout',
					));
				} else {
					$this->message->getAjaxMsg(array(
						"success" => FALSE,
						"msg" => $this->message->msg['public'][8],
					));
				}
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => validation_errors(),
				));
			}
		}
	}
	// 單選切換狀態
	public function changeStatus() {
		if ($this->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->common->checkLimits('account-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$result = $this->account_model->changeStatus();
			if ($result == TRUE) {
				$this->message->getAjaxMsg(array(
					"success" => TRUE,
					'act' => $this->account_model->status[$this->uri->segment(3)][1],
					'name' => $this->account_model->status[$this->uri->segment(3)][2],
					"msg" => $this->message->msg['public'][$this->account_model->status[$this->uri->segment(3)][3]],
				));
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => $this->message->msg['public'][8],
				));
			}
		}
	}
	// 單選刪除
	public function delete() {
		if ($this->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->common->checkLimits('account-del') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$result = $this->account_model->delete();
			if ($result == TRUE) {
				$this->message->getAjaxMsg(array(
					"success" => TRUE,
					"msg" => $this->message->msg['public'][7],
				));
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => $this->message->msg['public'][8],
				));
			}
		}
	}
	// 多選切換狀態
	public function mChangeStatus() {
		if ($this->input->method(TRUE) == 'POST') {
			// 檢查是否有權限
			if ($this->common->checkLimits('account-edit') == FALSE) {
				$this->message->getMsg($this->message->msg['public'][2]);
			}
			if ($this->input->post('id[]') != NULL) {
				$result = $this->account_model->mChangeStatus();
				if ($result == TRUE) {
					$this->message->getMsg($this->message->msg['public'][$this->account_model->status[$this->uri->segment(3)][1]]);
				} else {
					$this->message->getMsg($this->message->msg['public'][8]);
				}
			} else {
				$this->message->getMsg($this->message->msg['public'][3]);
			}
		}
	}
	// 多選刪除
	public function mDelete() {
		if ($this->input->method(TRUE) == 'POST') {
			// 檢查是否有權限
			if ($this->common->checkLimits('account-del') == FALSE) {
				$this->message->getMsg($this->message->msg['public'][2]);
			}
			if ($this->input->post('id[]') != NULL) {
				$result = $this->account_model->mDelete();
				if ($result == TRUE) {
					$this->message->getMsg($this->message->msg['public'][7]);
				} else {
					$this->message->getMsg($this->message->msg['public'][8]);
				}
			} else {
				$this->message->getMsg($this->message->msg['public'][3]);
			}
		}
	}
	public function record() {
		// 檢查是否有權限
		if ($this->common->checkLimits('account-record') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getRecordContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('users', 'account-record');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	// 取全部資料
	private function getListContent($act = 'list') {
		// 分頁設定
		$this->load->library('pagination');
		$q = $this->common->searchQueryHandler($this->input->get('q', TRUE));

		if ($act == 'search') {
			$config['base_url'] = '/w-admin/account/search?q=' . $q;
			$config['total_rows'] = $this->account_model->getSearchTotal($q);
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$page = $this->input->get('page', TRUE);
			$title = '搜尋帳號';
		} else {
			$config['base_url'] = '/w-admin/account';
			$config['total_rows'] = $this->account_model->getListTotal();
			$config['uri_segment'] = 3;
			$page = $this->uri->segment(3, 1);
			$title = '全部帳號';
		}
		$config['per_page'] = $this->pageNum;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<div class="pages">';
		$config['full_tag_close'] = '</div>';
		$config['cur_tag_open'] = '<a class="page now">';
		$config['cur_tag_close'] = '</a>';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['attributes'] = array('class' => 'page');
		$this->pagination->initialize($config);

		// 計算總分頁
		$totalPages = ceil($config['total_rows'] / $this->pageNum);
		if ($page < 1 || $page > $totalPages) {
			$page = 1;
		}
		$offset = $this->pageNum * ($page - 1);

		$data = array(
			'title' => $title,
			'tag' => 'account',
			'q' => $q,
			'result' => $this->account_model->getAccountData($act, $this->pageNum, $offset, $q),
		);
		return $this->load->view('w-admin/account/account-list.tpl.php', $data, TRUE);
	}
	// 取新增表單
	private function getAddFormContent() {
		$data = array(
			'title' => '新增帳號',
			'groups' => $this->account_model->getGroupsData(),
		);
		return $this->load->view('w-admin/account/account-add.tpl.php', $data, TRUE);
	}
	// 檢查帳號是否存在
	public function userCheck() {
		if ($this->input->is_ajax_request()) {
			$num = $this->account_model->getUserCheckData();
			if ($num > 0) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['account'][8],
				));
			} else {
				$this->message->getAjaxMsg(array(
					'success' => TRUE,
					'msg' => '此帳號可用',
				));
			}
		}
	}
	// 驗證callback函數 -> 帳號是否存在
	public function usernameCheck() {
		$num = $this->account_model->getUserCheckData();
		if ($num > 0) {
			$this->form_validation->set_message('usernameCheck', $this->message->msg['account'][8]);
			return FALSE;
		} else {
			return TRUE;
		}
	}
	// 驗證callback函數 -> 群組是否存在
	public function groupsCheck() {
		$num = $this->account_model->getGroupsCheckData();
		if ($num <= 0) {
			$this->form_validation->set_message('groupsCheck', $this->message->msg['account'][10]);
			return FALSE;
		} else {
			return TRUE;
		}
	}
	// 驗證callback函數 -> 舊密碼是否正確
	public function oldPassCheck() {
		$num = $this->account_model->getOldPassCheckData();
		if ($num <= 0) {
			$this->form_validation->set_message('oldPassCheck', $this->message->msg['account'][6]);
			return FALSE;
		} else {
			return TRUE;
		}
	}
	// 取修改表單
	private function getEditFormContent() {
		$result = $this->account_model->getAccountData('edit');
		if ($result != FALSE) {
			$data = array(
				'title' => '編輯帳號',
				'result' => $result,
				'groups' => $this->account_model->getGroupsData(),
				'page' => $this->uri->segment(5),
			);
			return $this->load->view('w-admin/account/account-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
	// 取個人資訊修改表單
	private function getPersonalFormContent() {
		$result = $this->account_model->getAccountData('personal');
		if ($result != FALSE) {
			$data = array(
				'title' => '個人資訊',
				'result' => $result,
			);
			return $this->load->view('w-admin/account/account-personal.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
	private function getRecordContent() {
		// 分頁設定
		$this->load->library('pagination');

		$config['base_url'] = '/w-admin/account/record';
		$config['total_rows'] = $this->account_model->getRecordTotal();
		$config['per_page'] = $this->pageNum;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<div class="pages">';
		$config['full_tag_close'] = '</div>';
		$config['cur_tag_open'] = '<a class="page now">';
		$config['cur_tag_close'] = '</a>';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['attributes'] = array('class' => 'page');
		$this->pagination->initialize($config);

		// 計算總分頁
		$totalPages = ceil($config['total_rows'] / $this->pageNum);
		$page = $this->uri->segment(4, 1);
		if ($page < 1 || $page > $totalPages) {
			$page = 1;
		}
		$offset = $this->pageNum * ($page - 1);

		$data = array(
			'title' => '登入紀錄',
			'result' => $this->account_model->getRecordData($this->pageNum, $offset),
		);
		return $this->load->view('w-admin/account/account-record.tpl.php', $data, TRUE);
	}
}