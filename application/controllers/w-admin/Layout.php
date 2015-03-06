<?php
class Layout extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
		$this->load->model('w-admin/layout_model');
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('layout') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();
		$data['menu'] = $this->common->getMenuContent('layouts', 'layout');

		$this->load->view('w-admin/page.tpl.php', $data);

	}
	public function edit() {
		// 檢查是否有權限
		if ($this->common->checkLimits('layout-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('layouts', 'layout');
		$content = $this->getEditFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	// 取全部資料
	private function getListContent() {
		$data = array(
			'title' => '版面管理',
			'tag' => 'layout',
			'result' => $this->layout_model->getLayoutData('list'),
		);
		return $this->load->view('w-admin/layout/layout-list.tpl.php', $data, TRUE);
	}
	// 取修改表單
	private function getEditFormContent() {
		$result = $this->layout_model->getLayoutData('edit');
		if ($result != FALSE) {
			$data = array(
				'title' => '編輯版面',
				'result' => $result,
				'nav' => $this->layout_model->getNav(),
				'page' => $this->uri->segment(5),
			);
			return $this->load->view('w-admin/layout/layout-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
}