<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common {
	protected $CI;
	public function __construct() {
		$this->CI = &get_instance();
		$this->CI->load->library('session');
	}
	// 檢查登入狀態
	function checkLoginStatus() {
		if ($this->CI->session->userdata('status') && $this->CI->session->userdata('status') == "success") {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}