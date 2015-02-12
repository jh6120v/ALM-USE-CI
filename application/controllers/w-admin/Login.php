<?php
class Login extends CI_Controller {
	function __construct() {
		parent::__construct ();
	}
	function index() {
		$this->load->helper ( array (
				'cookie',
				'form' 
		) );		
		// 判斷是否為登入狀態
		if ($this->common->checkLoginStatus() == true) {
			redirect('/w-admin/home', 'refresh');
		}
		$data = array (
				"remUser" => get_cookie ( 'remUser', TRUE ),
				"remPass" => get_cookie ( 'remPass', TRUE )
		);
		$this->load->view ( "w-admin/index.tpl.php", $data );
	}
	function captcha() {
		$params = array (
				"quantity" => 4,
				"height" => 33,
				"fontsize" => 20,
				"border" => true,
				"line" => false,
				"bgcolor" => array (0, 153, 204),
		);
		$this->load->library ( 'captcha', $params );
		
		$img = $this->captcha->getCaptcha ();
		ImagePNG ( $img );
		ImageDestroy ( $img );
	}
	function loginCheck() {
		echo 'test';
	}
	function logout() {
		
	}
}