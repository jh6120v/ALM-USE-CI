<?php
class Banner extends CI_Controller {
	public $pageNum = 15;
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
		$this->load->model('w-admin/banner_model');
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('banner') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('function', 'banner');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function search() {
		// 檢查是否有權限
		if ($this->common->checkLimits('banner') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent('search');

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('function', 'banner');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	// 取全部資料
	private function getListContent($act = 'list') {
		// 分頁設定
		$this->load->library('pagination');
		$q = $this->common->searchQueryHandler($this->input->get('q', TRUE));

		if ($act == 'search') {
			$config['base_url'] = '/w-admin/banner/search?q=' . $q;
			$config['total_rows'] = $this->banner_model->getSearchTotal($q);
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$page = $this->input->get('page', TRUE);
			$title = '搜尋橫幅廣告';
		} else {
			$config['base_url'] = '/w-admin/banner';
			$config['total_rows'] = $this->banner_model->getListTotal();
			$config['uri_segment'] = 3;
			$page = $this->uri->segment(3, 1);
			$title = '橫幅廣告';
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

		// 取排序
		$this->load->model('w-admin/sort_model');
		$sort = $this->sort_model->getSingleSort('banner');

		$data = array(
			'title' => $title,
			'tag' => 'banner',
			'q' => $q,
			'sort' => $sort,
			'result' => $this->banner_model->getBannerData($act, $this->pageNum, $offset, $q, $sort),
		);
		return $this->load->view('w-admin/banner/banner-list.tpl.php', $data, TRUE);
	}
}