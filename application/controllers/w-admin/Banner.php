<?php
class Banner extends CI_Controller {
	public $pageNum = 15;
	public $maxSize = 10240;
	public $savePath = "Upload/banner";
	public $allowedTypes = 'gif|jpg|png';
	public $newWidth = 1800;
	public $newHeight = 900;
	public function __construct() {
		parent::__construct();
		// 判斷是否為登入狀態
		$this->common->checkLoginStatus('i');
		$this->load->model('w-admin/banner_model');
	}
	public function index() {
		// 檢查是否有權限
		if ($this->common->checkLimits('banner') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent();

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('function', 'banner');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function search() {
		// 檢查是否有權限
		if ($this->common->checkLimits('banner') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$data['content'] = $this->getListContent('search');

		if (array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX']) {
			$this->load->view('w-admin/pjax.tpl.php', $data);
		} else {
			$data['menu'] = $this->common->getMenuContent('function', 'banner');
			$this->load->view('w-admin/page.tpl.php', $data);
		}
	}
	public function add() {
		// 檢查是否有權限
		if ($this->common->checkLimits('banner-add') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('function', 'banner');
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
			if ($this->common->checkLimits('banner-add') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('sort', '排序', 'required|numeric');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric|in_list[0,1]');
			if ($this->form_validation->run()) {
				$this->load->library('upload');

				$this->upload->initialize($this->uploadConfig());
				// 檢查是否上傳
				if ($this->upload->do_upload('fileName')) {
					// 取得上傳後返回的資料
					$fInfo = $this->upload->data();

					// 載入圖型處理類別
					$this->load->library('image_lib');

					$this->image_lib->initialize($this->imageConfig($fInfo['full_path']));
					if (!$this->image_lib->resize()) {
						// 刪除已上傳的檔案
						if (file_exists($fInfo['full_path']) == TRUE) {
							unlink($fInfo['full_path']);
						}
						$this->message->getAjaxMsg(array(
							"success" => FALSE,
							"msg" => $this->image_lib->display_errors('', '<br>'),
						));
					}
					$result = $this->banner_model->aSave($fInfo);
					if ($result == TRUE) {
						$this->message->getAjaxMsg(array(
							"success" => TRUE,
							"msg" => $this->message->msg['public'][5],
							"url" => '/w-admin/banner',
						));
					} else {
						// 刪除已上傳的檔案
						if (file_exists($fInfo['full_path']) == TRUE) {
							unlink($fInfo['full_path']);
						}
						$this->message->getAjaxMsg(array(
							"success" => FALSE,
							"msg" => $this->message->msg['public'][8],
						));
					}
				} else {
					$this->message->getAjaxMsg(array(
						"success" => FALSE,
						"msg" => $this->upload->display_errors('', '<br>'),
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
		if ($this->common->checkLimits('banner-edit') == FALSE) {
			$this->message->getMsg($this->message->msg['public'][2]);
		}
		// 取資料
		$menu = $this->common->getMenuContent('function', 'banner');
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
			if ($this->common->checkLimits('banner-edit') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			$this->load->library('form_validation');
			// 檢查必要欄位是否填寫
			$this->form_validation->set_rules('sort', '排序', 'required|numeric');
			$this->form_validation->set_rules('status', '狀態', 'required|numeric|in_list[0,1]');
			if ($this->form_validation->run()) {
				if (!empty($_FILES['fileName']['name'])) {
					$this->load->library('upload');

					$this->upload->initialize($this->uploadConfig());
					// 檢查是否上傳
					if ($this->upload->do_upload('fileName')) {
						// 取得上傳後返回的資料
						$fInfo = $this->upload->data();

						// 載入圖型處理類別
						$this->load->library('image_lib');

						$this->image_lib->initialize($this->imageConfig($fInfo['full_path']));
						if (!$this->image_lib->resize()) {
							// 刪除已上傳的檔案
							if (file_exists($fInfo['full_path']) == TRUE) {
								unlink($fInfo['full_path']);
							}
							$this->message->getAjaxMsg(array(
								"success" => FALSE,
								"msg" => $this->image_lib->display_errors('', '<br>'),
							));
						}
					} else {
						$this->message->getAjaxMsg(array(
							"success" => FALSE,
							"msg" => $this->upload->display_errors('', '<br>'),
						));
					}
				} else {
					$fInfo = FALSE;
				}
				// 取舊檔名
				$oldFile = $this->banner_model->getOldFileName();
				$result = $this->banner_model->eSave($fInfo);
				if ($result == TRUE) {
					if ($fInfo != FALSE && file_exists(realpath($this->savePath . '/' . $oldFile->fileName)) == TRUE) {
						// 刪除舊檔
						unlink(realpath($this->savePath . '/' . $oldFile->fileName));
					}
					$this->message->getAjaxMsg(array(
						"success" => TRUE,
						"msg" => $this->message->msg['public'][6],
						"url" => '/w-admin/banner/' . $this->input->post('page', TRUE),
					));
				} else {
					if ($fInfo != FALSE && file_exists($fInfo['full_path']) == TRUE) {
						unlink($fInfo['full_path']);
					}
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
		$this->common->changeStatus('banner');
	}
	// 單選刪除
	public function delete() {
		if ($this->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->common->checkLimits('banner-del') == FALSE) {
				$this->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->message->msg['public'][2],
				));
			}
			// 取舊檔名
			$oldFile = $this->banner_model->getOldFileName();
			$result = $this->banner_model->delete();
			if ($result == TRUE) {
				// 刪除舊檔
				if (file_exists(realpath($this->savePath . '/' . $oldFile->fileName)) == TRUE) {
					unlink(realpath($this->savePath . '/' . $oldFile->fileName));
				}
				$this->message->getAjaxMsg(array(
					"success" => TRUE,
					"msg" => $this->message->msg['public'][7],
				));
			} else {
				$this->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => $this->message->msg['public'][8],
				));
			}
		}
	}
	// 多選切換狀態
	public function mChangeStatus() {
		$this->common->mChangeStatus('banner');
	}
	// 多選刪除
	public function mDelete() {
		if ($this->input->method(TRUE) == 'POST') {
			// 檢查是否有權限
			if ($this->common->checkLimits('banner-del') == FALSE) {
				$this->message->getMsg($this->message->msg['public'][2]);
			}
			if ($this->input->post('id[]') != NULL) {
				// 取舊檔名
				$oldFile = $this->banner_model->getMultipleOldFileName();
				$result = $this->banner_model->mDelete();
				if ($result == TRUE) {
					// 檢查是否要刪除舊圖
					foreach ($oldFile as $v) {
						if (file_exists(realpath($this->savePath . '/' . $v->fileName)) == TRUE) {
							unlink(realpath($this->savePath . '/' . $v->fileName));
						}
					}
					$this->message->getMsg($this->message->msg['public'][7]);
				} else {
					$this->message->getMsg($this->message->msg['public'][8]);
				}
			} else {
				$this->message->getMsg($this->message->msg['public'][3]);
			}
		}
	}
	public function move() {
		if ($this->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->common->checkLimits('banner-edit') == FALSE) {
				exit();
			}
			$p = ($this->input->post('page', TRUE) != NULL && $this->input->post('page', TRUE) != '' && $this->input->post('page', TRUE) > 0 && ctype_digit($this->input->post('page', TRUE))) ? $this->input->post('page', TRUE) : 1;
			// 取排序
			$this->load->model('w-admin/sort_model');
			$sort = $this->sort_model->getSingleSort('banner');
			// 檢查主要排序是否為自訂排序
			if ($sort->sort == "sort" && $sort->orderBy == "ASC") {
				$sortFirst = ($p - 1) * $this->pageNum + 1;
			} elseif ($sort->sort == "sort" && $sort->orderBy == "DESC") {
				// 計算總筆數
				$num = $this->banner_model->getListTotal(); // 計算總筆數
				$sortFirst = $num - ($p - 1) * $this->pageNum;
			} else {
				$sortFirst = FALSE;
			}
			$result = $this->banner_model->mSave($sort->orderBy, $sortFirst, $this->input->post('id', TRUE));
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
			$config['base_url'] = '/w-admin/banner/search?q=' . $q;
			$config['total_rows'] = $this->banner_model->getSearchTotal($q);
			$config['page_query_string'] = TRUE;
			$config['query_string_segment'] = 'page';
			$page = $this->input->get('page', TRUE);
			$title = '搜尋橫幅廣告';
		} else {
			$config['base_url'] = '/w-admin/banner';
			$config['total_rows'] = $this->banner_model->getListTotal();
			$config['uri_segment'] = 3;
			$page = $this->uri->segment(3, 1);
			$title = '橫幅廣告';
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
		$sort = $this->sort_model->getSingleSort('banner');

		$data = array(
			'title' => $title,
			'tag' => 'banner',
			'q' => $q,
			'sort' => $sort,
			'result' => $this->banner_model->getBannerData($act, $this->pageNum, $offset, $q, $sort),
		);
		return $this->load->view('w-admin/banner/banner-list.tpl.php', $data, TRUE);
	}
	// 取新增表單
	private function getAddFormContent() {
		$data = array(
			'title' => '新增橫幅廣告',
			'setWidth' => $this->newWidth,
			'setHeight' => $this->newHeight,
		);
		return $this->load->view('w-admin/banner/banner-add.tpl.php', $data, TRUE);
	}
	// 取修改表單
	private function getEditFormContent() {
		$result = $this->banner_model->getBannerData('edit');
		if ($result != FALSE) {
			$data = array(
				'title' => '編輯橫幅廣告',
				'result' => $result,
				'setWidth' => $this->newWidth,
				'setHeight' => $this->newHeight,
				'page' => $this->uri->segment(5),
			);
			return $this->load->view('w-admin/banner/banner-edit.tpl.php', $data, TRUE);
		} else {
			$this->message->getMsg($this->message->msg['public'][0]);
		}
	}
	public function uploadConfig() {
		return array(
			'upload_path' => './' . $this->savePath . '/',
			'allowed_types' => $this->allowedTypes,
			'max_size' => $this->maxSize,
			'encrypt_name' => TRUE,
		);
	}
	public function imageConfig($filePath) {
		return array(
			'source_image' => $filePath,
			'width' => $this->newWidth,
			'height' => $this->newHeight,
			'maintain_ratio' => FALSE,
		);
	}
}