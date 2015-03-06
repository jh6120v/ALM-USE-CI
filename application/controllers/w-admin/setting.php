<?php
class Setting extends CI_Controller {
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
		$this->load->model('w-admin/setting_model');
	}
	public function index() {
		//檢查是否有權限
		if ($this->common->checkLimits('setting') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		//取資料
		$menu = $this->common->getMenuContent('system', 'setting');
		$content = $this->getEditFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	public function getEditFormContent() {
		$result = $this->setting_model->getSettingData();
		if ($result != FALSE) {
			$data = array(
				'title' => '基本設置',
				'result' => $result,
			);
			return $this->load->view('w-admin/setting/setting.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
	public function eSave() {
		$this->load->library('form_validation');
		if ($this->input->is_ajax_request()) {
			//檢查是否有權限
			if ($this->common->checkLimits('setting-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			//檢查必要欄位是否填寫
			$this->form_validation->set_rules('title', '網站標題', 'required');
			$this->form_validation->set_rules('email', '聯絡Email', 'required|valid_email');

			if ($this->form_validation->run()) {
				$result = $this->setting_model->eSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/setting',
					));
				} else {
					$this->message->getAjaxMsg(array(
						"success" => FALSE,
						"msg" => $this->message->msg['public'][8],
					));
				}
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => validation_errors(),
				));
			}
		}
	}
}