<?php
class Nav extends CI_Controller {
	public $pageNum = 15;
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
		$this->load->model('w-admin/nav_model');
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('nav') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('layouts', 'nav');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function search() {
		// 檢查是否有權限
		if ($this->common->checkLimits('nav') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent('search');

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('layouts', 'nav');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function add() {
		// 檢查是否有權限
		if ($this->common->checkLimits('nav-add') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('layouts', 'nav');
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
			if ($this->common->checkLimits('nav-add') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('title', '選單名稱', 'required');
			$this->form_validation->set_rules('pNav', '主選單', 'required|numeric');
			if ($this->form_validation->run()) {
				$result = $this->nav_model->aSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][5],
						"url" => '/w-admin/nav',
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
		if ($this->common->checkLimits('nav-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('layouts', 'nav');
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
			if ($this->common->checkLimits('nav-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$this->load->library('form_validation');
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('title', '選單名稱', 'required');
			$this->form_validation->set_rules('pNav', '主選單', 'required|numeric');
			if ($this->form_validation->run()) {
				$result = $this->nav_model->eSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/nav/' . $this->input->post('page', TRUE),
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
	// 單選刪除
	public function delete() {
		$this->common->delete('nav');
	}
	// 多選刪除
	public function mDelete() {
		$this->common->mDelete('nav');
	}
	// 取全部資料
	private function getListContent($act = 'list') {
		// 分頁設定
		$this->load->library('pagination');
		$q = $this->common->searchQueryHandler($this->input->get('q', TRUE));

		if ($act == 'search') {
			$config['base_url'] = '/w-admin/nav/search?q=' . $q;
			$config['total_rows'] = $this->nav_model->getSearchTotal($q);
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$page = $this->input->get('page', TRUE);
			$title = '搜尋選單';
		} else {
			$config['base_url'] = '/w-admin/nav';
			$config['total_rows'] = $this->nav_model->getListTotal();
			$config['uri_segment'] = 3;
			$page = $this->uri->segment(3, 1);
			$title = '選單管理';
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
			'tag' => 'nav',
			'q' => $q,
			'mStatus' => 'close',
			'result' => $this->nav_model->getNavData($act, $this->pageNum, $offset, $q),
		);
		return $this->load->view('w-admin/nav/nav-list.tpl.php', $data, TRUE);
	}
	// 取新增表單
	private function getAddFormContent() {
		$primary = $this->nav_model->getPrimaryNavNow();
		$primary = ($primary != FALSE) ? "(目前設定：" . $primary->title . ")" : "";
		$data = array(
			'title' => '新增選單',
			'pNav' => $primary,
		);
		return $this->load->view('w-admin/nav/nav-add.tpl.php', $data, TRUE);
	}
	// 取修改表單
	private function getEditFormContent() {
		$primary = $this->nav_model->getPrimaryNavNow();
		$primary = ($primary != FALSE) ? "(目前設定：" . $primary->title . ")" : "";
		$result = $this->nav_model->getNavData('edit');
		if ($result != FALSE) {
			$mData = unserialize($result->mData);
			$data = array(
				'title' => '編輯選單',
				'pNav' => $primary,
				'result' => $result,
				'nav' => $this->getNavTree($mData),
				'page' => $this->uri->segment(5),
			);
			return $this->load->view('w-admin/nav/nav-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
	// 選單遞迴處理
	private function getNavTree($mData = array()) {
		$nav = '';
		foreach ($mData as $v) {
			if (isset($v->children)) {
				$subMenu = $this->getNavTree($v->children);
			} else {
				$subMenu = '';
			}
			$data = array(
				'id' => $v->id,
				'name' => $v->name,
				'link' => $v->link,
				'target' => $v->target,
				'subMenu' => $subMenu,
			);
			$nav .= $this->load->view('w-admin/nav/nav-tree.tpl.php', $data, TRUE);
		}
		return $nav;
	}
}