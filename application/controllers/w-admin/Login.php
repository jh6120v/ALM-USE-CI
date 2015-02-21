<?php
class Login extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
	public function index() {
		// 判斷是否為登入狀態
		if ($this->common->checkLoginStatus() == TRUE) {
			redirect('/w-admin/home', 'refresh');
		}
		$data = array(
			"remUser" => $this->input->cookie('remUser', TRUE),
			"remPass" => $this->input->cookie('remPass', TRUE),
		);
		$this->load->view("w-admin/index.tpl.php", $data);
	}
	public function captcha() {
		$params = array(
			"quantity" => 4,
			"height" => 33,
			"fontsize" => 20,
			"border" => TRUE,
			"line" => FALSE,
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
			$this->form_validation->set_rules('username', '帳號', 'required|min_length[5]');
			$this->form_validation->set_rules('password', '密碼', 'required');
			$this->form_validation->set_rules('captcha', '驗證碼', 'required|callback_captchaCheck');

			if ($this->form_validation->run()) {
				// model操作
				$this->load->model('login');
				$username = $this->input->post('username', TRUE);
				$password = $this->input->post('password', TRUE);
				$resutl = $this->login->checkLoginData($username, $password);

				$this->message->getAjaxMsg(array(
					"success" => $resutl[0],
					"msg" => $result[1],
					"url" => $result[2],
				));

			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => validation_errors(),
				));
			}
		}
	}
	public function captchaCheck($str) {
		$captcha = $this->session->userdata('captcha');
		if ($str != $captcha) {
			$this->form_validation->set_message('captchaCheck', '驗證碼錯誤!');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function logout() {
		$this->session->sess_destroy();
		$this->message->getMsg($this->message->msg['login'][8], '/w-admin');
	}
}