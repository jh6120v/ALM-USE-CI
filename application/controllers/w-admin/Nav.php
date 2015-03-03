<?php
class Nav extends CI_Controller {
	public $pageNum = 15;
	public function __construct() {
		parent::__construct();
		$this->load->model('w-admin/nav_model');
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
}