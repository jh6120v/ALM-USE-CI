<?php
class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
	}
	public function index() {
		$menu = $this->common->getMenuContent('console', 'home');
		$content = $this->getHomeContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	private function getHomeContent() {
		$terms = $this->getTermsContent();
		$records = $this->getRecordsContent();
		$data = array(
			'title' => '控制台',
			'records' => $records,
			'terms' => $terms,
		);
		return $this->load->view('w-admin/home/home.tpl.php', $data, TRUE);
	}
	private function getRecordsContent() {
		$this->load->model('w-admin/home_model');
		$data['result'] = $this->home_model->getRecordsData();

		return $this->load->view('w-admin/home/home-records.tpl.php', $data, TRUE);
	}
	private function getTermsContent() {
		return $this->load->view('w-admin/home/home-terms.tpl.php', '', TRUE);
	}
}