<?php
class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function index() {
		// 判斷是否為登入狀態
		if ($this->common->checkLoginStatus() == FALSE) {
			redirect('/w-admin', 'refresh');
		}
	}
}