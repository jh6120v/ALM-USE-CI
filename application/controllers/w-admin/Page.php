<?php
class Page extends CI_Controller {
	public $pageNum = 15;
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
		$this->load->model('w-admin/page_model');
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('page') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('pages', 'page');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function search() {
		// 檢查是否有權限
		if ($this->common->checkLimits('page') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent('search');

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('pages', 'page');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function add() {
		// 檢查是否有權限
		if ($this->common->checkLimits('page-add') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('pages', 'page-add');
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
			if ($this->common->checkLimits('page-add') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('title', '頁面名稱', 'required');
			$this->form_validation->set_rules('tag', '標籤', 'required|callback_tagCheck');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric');
			if ($this->session->userdata('acl') == 'administration') {
				$this->form_validation->set_rules('locked', '鎖定', 'required|numeric');
			}
			if ($this->common->checkLimits('layout-edit') == TRUE) {
				$this->form_validation->set_rules('position', '側欄位置', 'required|numeric|in_list[0,1,2,3]');
				if ($this->input->post('position', TRUE) != 0 && $this->input->post('position', TRUE) != 1) {
					$this->form_validation->set_rules('nav', '選單', 'required|numeric|callback_navCheck');
				}
			}
			if ($this->form_validation->run()) {
				$result = $this->page_model->aSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][5],
						"url" => '/w-admin/page',
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
		if ($this->common->checkLimits('page-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('pages', 'page');
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
			if ($this->common->checkLimits('page-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$this->load->library('form_validation');
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('title', '頁面名稱', 'required');
			$this->form_validation->set_rules('tag', '標籤', 'required|callback_tagCheck2');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric');
			if ($this->session->userdata('acl') == 'administration') {
				$this->form_validation->set_rules('locked', '鎖定', 'required|numeric');
			}
			if ($this->common->checkLimits('layout-edit') == TRUE) {
				$this->form_validation->set_rules('position', '側欄位置', 'required|numeric|in_list[0,1,2,3]');
				if ($this->input->post('position', TRUE) != 0 && $this->input->post('position', TRUE) != 1) {
					$this->form_validation->set_rules('nav', '選單', 'required|numeric|callback_navCheck');
				}
			}
			if ($this->form_validation->run()) {
				$result = $this->page_model->eSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/page/' . $this->input->post('page', TRUE),
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
		$this->common->changeStatus('page');
	}
	// 單選刪除
	public function delete() {
		$this->common->delete('page');
	}
	// 多選切換狀態
	public function mChangeStatus() {
		$this->common->mChangeStatus('page');
	}
	// 多選刪除
	public function mDelete() {
		$this->common->mDelete('page');
	}
	// 取全部資料
	private function getListContent($act = 'list') {
		// 分頁設定
		$this->load->library('pagination');
		$q = $this->common->searchQueryHandler($this->input->get('q', TRUE));

		if ($act == 'search') {
			$config['base_url'] = '/w-admin/page/search?q=' . $q;
			$config['total_rows'] = $this->page_model->getSearchTotal($q);
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$page = $this->input->get('page', TRUE);
			$title = '搜尋頁面';
		} else {
			$config['base_url'] = '/w-admin/page';
			$config['total_rows'] = $this->page_model->getListTotal();
			$config['uri_segment'] = 3;
			$page = $this->uri->segment(3, 1);
			$title = '全部頁面';
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
			'tag' => 'page',
			'q' => $q,
			'result' => $this->page_model->getPageData($act, $this->pageNum, $offset, $q),
		);
		return $this->load->view('w-admin/page/page-list.tpl.php', $data, TRUE);
	}
	// 取新增表單
	private function getAddFormContent() {
		$nav = $this->page_model->getNav();
		$data = array(
			'title' => '新增頁面',
			'nav' => $nav,
		);
		return $this->load->view('w-admin/page/page-add.tpl.php', $data, TRUE);
	}
	// 取修改表單
	private function getEditFormContent() {
		$nav = $this->page_model->getNav();
		$result = $this->page_model->getPageData('edit');
		if ($result != FALSE) {
			$data = array(
				'title' => '編輯頁面',
				'result' => $result,
				'nav' => $nav,
				'page' => $this->uri->segment(5),
			);
			return $this->load->view('w-admin/page/page-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
	// 驗證callback函數 -> 標籤是否重複
	public function tagCheck() {
		$num = $this->page_model->getTagCheckData();
		if ($num > 0) {
			$this->form_validation->set_message('tagCheck', '標籤重複!');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	// 驗證callback函數 -> 標籤是否重複
	public function tagCheck2() {
		$num = $this->page_model->getTagCheckData('edit');
		if ($num > 0) {
			$this->form_validation->set_message('tagCheck', '標籤重複!');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	// 驗證callback函數 -> 選單是否存在
	public function navCheck($str) {
		if ($str != 0) {
			$num = $this->page_model->getNavCheckData();
			if ($num <= 0) {
				$this->form_validation->set_message('navCheck', '選單不存在!');
				return FALSE;
			} else {
				return TRUE;
			}
		}
	}
}