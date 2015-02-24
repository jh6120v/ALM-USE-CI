<?php
class Sort extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('w-admin/sort_model');
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
		if ($this->common->checkLimits('sort') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		//取資料
		$menu = $this->common->getMenuContent('system', 'sort');
		$content = $this->getListContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	public function edit($id) {
		//檢查是否有權限
		if ($this->common->checkLimits('sort-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		//取資料
		$menu = $this->common->getMenuContent('system', 'sort');
		$content = $this->getEditFormContent($id);
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	public function eSave() {
		$this->load->library('form_validation');
		if ($this->input->is_ajax_request()) {
			//檢查是否有權限
			if ($this->common->checkLimits('sort-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			//檢查必要欄位是否填寫
			$this->form_validation->set_rules('sort', '主要依據', 'required');
			$this->form_validation->set_rules('orderBy', '主要方式', 'required');
			$this->form_validation->set_rules('sort2', '次要依據', 'required');
			$this->form_validation->set_rules('orderBy2', '次要方式', 'required');

			if ($this->form_validation->run()) {
				$result = $this->sort_model->eSave($this->input->post(NULL, TRUE));
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/sort',
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
	private function getListContent() {
		$data = array(
			'title' => '排序設定',
			'tag' => 'sort',
			'result' => $this->sort_model->getSortData(),
			'sort' => $this->sort_model->getListSortName(),
		);
		return $this->load->view('w-admin/sort/sort-list.tpl.php', $data, TRUE);
	}
	public function getEditFormContent($id) {
		$result = $this->sort_model->getSortData($id);
		if ($result != FALSE) {
			$data = array(
				'title' => '編輯排序',
				'result' => $result,
				'sortArray' => $this->sort_model->getSortArray($result->type),
				'orderByArray' => $this->sort_model->getOrderByArray(),
			);
			return $this->load->view('w-admin/sort/sort-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
}