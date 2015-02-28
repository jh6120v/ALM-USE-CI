<?php
class Group extends CI_Controller {
	public $pageNum = 15;
	public function __construct() {
		parent::__construct();
		$this->load->model('w-admin/group_model');
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
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('group') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('users', 'group');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function search() {
		// 取資料
		$data['content'] = $this->getListContent('search');

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('users', 'group');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function add() {
		// 檢查是否有權限
		if ($this->common->checkLimits('group-add') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('users', 'group');
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
			if ($this->common->checkLimits('group-add') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('title', '群組名稱', 'required');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric');
			if ($this->form_validation->run()) {
				$result = $this->group_model->aSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][5],
						"url" => '/w-admin/group',
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
		if ($this->common->checkLimits('group-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('users', 'group');
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
			if ($this->common->checkLimits('group-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$this->load->library('form_validation');
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('title', '群組名稱', 'required');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric');
			if ($this->form_validation->run()) {
				$result = $this->group_model->eSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/group/' . $this->input->post('page', TRUE),
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
		$this->common->changeStatus('group');
	}
	// 單選刪除
	public function delete() {
		$this->common->delete('group');
	}
	// 多選切換狀態
	public function mChangeStatus() {
		$this->common->mChangeStatus('group');
	}
	// 多選刪除
	public function mDelete() {
		$this->common->mDelete('group');
	}
	// 取全部資料
	private function getListContent($act = 'list') {
		// 分頁設定
		$this->load->library('pagination');
		$q = $this->common->searchQueryHandler($this->input->get('q', TRUE));

		if ($act == 'search') {
			$config['base_url'] = '/w-admin/group/search?q=' . $q;
			$config['total_rows'] = $this->group_model->getSearchTotal($q);
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$page = $this->input->get('page', TRUE);
			$title = '搜尋群組';
		} else {
			$config['base_url'] = '/w-admin/group';
			$config['total_rows'] = $this->group_model->getListTotal();
			$config['uri_segment'] = 3;
			$page = $this->uri->segment(3, 1);
			$title = '群組管理';
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
			'tag' => 'group',
			'q' => $q,
			'result' => $this->group_model->getGroupData($act, $this->pageNum, $offset, $q),
		);
		return $this->load->view('w-admin/group/group-list.tpl.php', $data, TRUE);
	}
	// 取新增表單
	private function getAddFormContent() {
		$data = array(
			'title' => '新增群組',
			'aclList' => $this->group_model->aclList,
		);
		return $this->load->view('w-admin/group/group-add.tpl.php', $data, TRUE);
	}
	// 取修改表單
	private function getEditFormContent() {
		$result = $this->group_model->getGroupData('edit');
		if ($result != FALSE) {
			$data = array(
				'title' => '編輯群組',
				'result' => $result,
				'aclList' => $this->group_model->aclList,
				'acl' => unserialize($result->acl),
				'page' => $this->uri->segment(5),
			);
			return $this->load->view('w-admin/group/group-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
}
