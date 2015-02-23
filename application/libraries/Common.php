<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common {
	protected $CI;
	public function __construct() {
		$this->CI = &get_instance();
		$this->CI->load->library('session');
	}
	// 檢查登入狀態
	public function checkLoginStatus() {
		if ($this->CI->session->userdata('status') && $this->CI->session->userdata('status') == "success") {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	public function getMenuContent($open = '', $subOpen = '') {
		$this->CI->load->model('w-admin/menu_model');
		$menu = $this->CI->menu_model->menuData();
		$data = array(
			'open' => $open,
			'subOpen' => $subOpen,
			'menu' => $menu,
		);
		return $this->CI->load->view('w-admin/common/menu.tpl.php', $data, TRUE);
	}
	// 檢查權限
	public function checkLimits($a) {
		if ($this->CI->session->userdata('acl') != 'administration' && !in_array($a, $this->CI->session->userdata('acl'))) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
}