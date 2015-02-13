<?php
class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function index() {
		$this->load->helper(array(
			'cookie',
			'form',
		));
		// 判斷是否為登入狀態
		if ($this->common->checkLoginStatus() == true) {
			redirect('/w-admin/home', 'refresh');
		}
		$data = array(
			"remUser" => get_cookie('remUser', TRUE),
			"remPass" => get_cookie('remPass', TRUE),
		);
		$this->load->view("w-admin/index.tpl.php", $data);
	}
	public function captcha() {
		$params = array(
			"quantity" => 4,
			"height" => 33,
			"fontsize" => 20,
			"border" => true,
			"line" => false,
			"bgcolor" => array(0, 153, 204),
		);
		$this->load->library('captcha', $params);

		$img = $this->captcha->getCaptcha();
		ImagePNG($img);
		ImageDestroy($img);
	}
	public function loginCheck() {
		$this->load->library('form_validation');
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('username', '帳號', 'required');
			$this->form_validation->set_rules('password', '密碼', 'required');
			$this->form_validation->set_rules('captcha', '驗證碼', 'required|callback_captchaCheck');

			if ($this->form_validation->run()) {
				// model操作
				$this->message->getAjaxMsg(array(
					"success" => 1,
					"msg" => "success!",
					"url" => "/w-admin",
				));
			} else {
				$this->message->getAjaxMsg(array(
					"success" => 0,
					"msg" => validation_errors(),
				));
			}
		}
	}
	public function captchaCheck($str) {
		$captcha = $this->session->userdata('captcha');
		if ($str != $captcha) {
			$this->form_validation->set_message('captchaCheck', '驗證碼錯誤!');
			return false;
		} else {
			return true;
		}
	}
	public function logout() {

	}
}