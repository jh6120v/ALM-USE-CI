<?php
class WorksCategory extends CI_Controller {
	public $pageNum = 15;
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
		$this->load->model('w-admin/worksCategory_model');
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('worksCategory') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('function', 'worksCategory');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function search() {
		// 檢查是否有權限
		if ($this->common->checkLimits('worksCategory') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent('search');

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('function', 'worksCategory');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function add() {
		// 檢查是否有權限
		if ($this->common->checkLimits('worksCategory-add') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('function', 'worksCategory');
		$content = $this->getAddFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	// 新增儲存
	public function aSave() {
		$this->load->library('form_validation');
		if ($this->input->is_ajax_request()) {
			//檢查是否有權限
			if ($this->common->checkLimits('worksCategory-add') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('catName', '分類名稱', 'required');
			$this->form_validation->set_rules('sort', '排序', 'required|numeric');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric|in_list[0,1]');
			if ($this->session->userdata('acl') == 'administration') {
				$this->form_validation->set_rules('locked', '鎖定', 'required|numeric|in_list[0,1]');
			}
			if ($this->form_validation->run()) {
				$result = $this->worksCategory_model->aSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][5],
						"url" => '/w-admin/worksCategory',
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
	public function edit() {
		// 檢查是否有權限
		if ($this->common->checkLimits('worksCategory-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('function', 'worksCategory');
		$content = $this->getEditFormContent();
		$data = array(
			'menu' => $menu,
			'content' => $content,
		);
		$this->load->view('w-admin/page.tpl.php', $data);
	}
	// 修改儲存
	public function eSave() {
		if ($this->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->common->checkLimits('worksCategory-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$this->load->library('form_validation');
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('catName', '分類名稱', 'required');
			$this->form_validation->set_rules('sort', '排序', 'required|numeric');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric|in_list[0,1]');
			if ($this->session->userdata('acl') == 'administration') {
				$this->form_validation->set_rules('locked', '鎖定', 'required|numeric|in_list[0,1]');
			}
			if ($this->form_validation->run()) {
				$result = $this->worksCategory_model->eSave();
				if ($result == TRUE) {
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/worksCategory/' . $this->input->post('page', TRUE),
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
	// 單選切換狀態
	public function changeStatus() {
		$this->common->changeStatus('worksCategory');
	}
	// 單選刪除
	public function delete() {
		$this->common->delete('worksCategory');
	}
	// 多選切換狀態
	public function mChangeStatus() {
		$this->common->mChangeStatus('worksCategory');
	}
	// 多選刪除
	public function mDelete() {
		$this->common->mDelete('worksCategory');
	}
	public function move() {
		if ($this->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->common->checkLimits('worksCategory-edit') == FALSE) {
				exit();
			}
			$p = ($this->input->post('page', TRUE) != NULL && $this->input->post('page', TRUE) != '' && $this->input->post('page', TRUE) > 0 && ctype_digit($this->input->post('page', TRUE))) ? $this->input->post('page', TRUE) : 1;
			// 取排序
			$this->load->model('w-admin/sort_model');
			$sort = $this->sort_model->getSingleSort('worksCategory');
			// 檢查主要排序是否為自訂排序
			if ($sort->sort == "sort" && $sort->orderBy == "ASC") {
				$sortFirst = ($p - 1) * $this->pageNum + 1;
			} elseif ($sort->sort == "sort" && $sort->orderBy == "DESC") {
				// 計算總筆數
				$num = $this->worksCategory_model->getListTotal(); // 計算總筆數
				$sortFirst = $num - ($p - 1) * $this->pageNum;
			} else {
				$sortFirst = FALSE;
			}
			$result = $this->worksCategory_model->mSave($sort->orderBy, $sortFirst, $this->input->post('id', TRUE));
			if ($result == FALSE) {
				exit();
			}
		}
	}
	// 取全部資料
	private function getListContent($act = 'list') {
		// 分頁設定
		$this->load->library('pagination');
		$q = $this->common->searchQueryHandler($this->input->get('q', TRUE));

		if ($act == 'search') {
			$config['base_url'] = '/w-admin/worksCategory/search?q=' . $q;
			$config['total_rows'] = $this->worksCategory_model->getSearchTotal($q);
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$page = $this->input->get('page', TRUE);
			$title = '搜尋設計作品分類';
		} else {
			$config['base_url'] = '/w-admin/worksCategory';
			$config['total_rows'] = $this->worksCategory_model->getListTotal();
			$config['uri_segment'] = 3;
			$page = $this->uri->segment(3, 1);
			$title = '設計作品分類';
		}
		$config['per_page'] = $this->pageNum;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<div class="pages">';
		$config['full_tag_close'] = '</div>';
		$config['cur_tag_open'] = '<a class="page now">';
		$config['cur_tag_close'] = '</a>';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$config['attributes'] = array('class' => 'page');
		$this->pagination->initialize($config);

		// 計算總分頁
		$totalPages = ceil($config['total_rows'] / $this->pageNum);
		if ($page < 1 || $page > $totalPages) {
			$page = 1;
		}
		$offset = $this->pageNum * ($page - 1);

		// 取排序
		$this->load->model('w-admin/sort_model');
		$sort = $this->sort_model->getSingleSort('worksCategory');

		$data = array(
			'title' => $title,
			'tag' => 'worksCategory',
			'q' => $q,
			'sort' => $sort,
			'result' => $this->worksCategory_model->getWorksCategoryData($act, $this->pageNum, $offset, $q, $sort),
		);
		return $this->load->view('w-admin/worksCategory/worksCategory-list.tpl.php', $data, TRUE);
	}
	// 取新增表單
	private function getAddFormContent() {
		$data = array(
			'title' => '新增設計作品分類',
		);
		return $this->load->view('w-admin/worksCategory/worksCategory-add.tpl.php', $data, TRUE);
	}
	// 取修改表單
	private function getEditFormContent() {
		$result = $this->worksCategory_model->getWorksCategoryData('edit');
		if ($result != FALSE) {
			$data = array(
				'title' => '編輯設計作品分類',
				'result' => $result,
				'page' => $this->uri->segment(5),
			);
			return $this->load->view('w-admin/worksCategory/worksCategory-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
}