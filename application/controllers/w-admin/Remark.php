<?php
class Remark extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('w-admin/remark_model');
		// 判斷是否為登入狀態
		if ($this->common->checkLoginStatus() == FALSE) {
			if ($this->input->is_ajax_request()) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][1],
				));
			} else {
				redirect('/w-admin', 'refresh');
			}
		}
	}
	public function index() {
		//檢查是否有權限
		if ($this->common->checkLimits('remark') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		//取資料
		$menu = $this->common->getMenuContent('console', 'remark');
		$content = $this->getEditFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	private function getEditFormContent() {
		$result = $this->remark_model->getRemarkData();
		if ($result != FALSE) {
			$data = array(
				'title' => '備註版',
				'result' => $result,
			);
			return $this->load->view('w-admin/remark/remark.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
	public function eSave() {
		if ($this->input->is_ajax_request()) {
			//檢查是否有權限
			if ($this->common->checkLimits('remark-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$result = $this->remark_model->eSave($this->input->post());
			if ($result == TRUE) {
				$this->message->getAjaxMsg(array(
					"success" => TRUE,
					"msg" => $this->message->msg['public'][6],
					"url" => '/w-admin/remark',
				));
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => $this->message->msg['public'][8],
				));
			}
		}
	}
}