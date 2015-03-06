<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common {
	protected $CI;
	public function __construct() {
		$this->CI = &get_instance();
		$this->CI->load->library('session');
	}
	// 檢查登入狀態
	public function checkLoginStatus($m = '') {
		if ($this->CI->session->userdata('status') != NULL && $this->CI->session->userdata('status') == "success") {
			return TRUE;
		} else {
			if ($m == 'i') {
				if ($this->CI->input->is_ajax_request()) {
					$this->CI->message->getAjaxMsg(array(
						'success' => FALSE,
						'msg' => $this->CI->message->msg['public'][1],
					));
				} else {
					redirect('/w-admin', 'refresh');
				}
			}
			return FALSE;
		}
	}
	// 檢查權限
	public function checkLimits($a) {
		if ($this->CI->session->userdata('acl') != 'administration' && !in_array($a, $this->CI->session->userdata('acl'))) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	//輸出後台選單
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
	//尋找地理座標
	public function location($address = '') {
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address={$address}&sensor=false";
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "Google Bot",
			CURLOPT_FOLLOWLOCATION => true,
		);
		curl_setopt_array($ch, $options);
		$output = curl_exec($ch);
		curl_close($ch);
		// 將josn格式進行解析
		$obj = json_decode($output);

		$data = array(
			"lat" => $obj->results[0]->geometry->location->lat,
			"lng" => $obj->results[0]->geometry->location->lng,
		);
		return $data;
	}
	//去除HTML
	public function htmlFilter($t) {
		$search = array(
			'/ ]*?>.*?/si', // Strip out javascript
			'/<[\/\!]*?[^<>]*?>/si', // Strip out HTML tags
			'/([\r\n])[\s]+/', // Strip out white space
			'/&(quot|#34);/i', // Replace HTML entities
			'/&(amp|#38);/i',
			'/&(lt|#60);/i',
			'/&(gt|#62);/i',
			'/&(nbsp|#160);/i',
			'/&(iexcl|#161);/i',
			'/&(cent|#162);/i',
			'/&(pound|#163);/i',
			'/&(copy|#169);/i',
			'/&#(\d+);/',
		); // evaluate as php

		$replace = array(
			'',
			'',
			'\1',
			'"',
			'&',
			'<',
			'>',
			' ',
			chr(161),
			chr(162),
			chr(163),
			chr(169),
			'chr(\1)',
		);
		$txt = preg_replace($search, $replace, $t);
		return $txt;
	}
	// 處理搜尋字串
	public function searchQueryHandler($q) {
		return (isset($q)) ? $q : "";
	}
	// 單選切換狀態
	public function changeStatus($method) {
		if ($this->CI->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->checkLimits($method . '-edit') == FALSE) {
				$this->CI->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->CI->message->msg['public'][2],
				));
			}
			$model = $method . '_model';
			$result = $this->CI->$model->changeStatus();
			if ($result == TRUE) {
				$this->CI->message->getAjaxMsg(array(
					"success" => TRUE,
					'act' => $this->CI->message->status[$this->CI->uri->segment(3)][1],
					'name' => $this->CI->message->status[$this->CI->uri->segment(3)][2],
					'updateTime' => date('Y-m-d H:i:s'),
					"msg" => $this->CI->message->msg['public'][$this->CI->message->status[$this->CI->uri->segment(3)][3]],
				));
			} else {
				$this->CI->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => $this->CI->message->msg['public'][8],
				));
			}
		}
	}
	// 單選刪除
	public function delete($method) {
		if ($this->CI->input->is_ajax_request()) {
			// 檢查是否有權限
			if ($this->checkLimits($method . '-del') == FALSE) {
				$this->CI->message->getAjaxMsg(array(
					'success' => FALSE,
					'msg' => $this->CI->message->msg['public'][2],
				));
			}
			$model = $method . '_model';
			$result = $this->CI->$model->delete();
			if ($result == TRUE) {
				$this->CI->message->getAjaxMsg(array(
					"success" => TRUE,
					"msg" => $this->CI->message->msg['public'][7],
				));
			} else {
				$this->CI->message->getAjaxMsg(array(
					"success" => FALSE,
					"msg" => $this->CI->message->msg['public'][8],
				));
			}
		}
	}
	// 多選切換狀態
	public function mChangeStatus($method) {
		if ($this->CI->input->method(TRUE) == 'POST') {
			// 檢查是否有權限
			if ($this->checkLimits($method . '-edit') == FALSE) {
				$this->CI->message->getMsg($this->CI->message->msg['public'][2]);
			}
			if ($this->CI->input->post('id[]') != NULL) {
				$model = $method . '_model';
				$result = $this->CI->$model->mChangeStatus();
				if ($result == TRUE) {
					$this->CI->message->getMsg($this->CI->message->msg['public'][$this->CI->message->status[$this->CI->uri->segment(3)][1]]);
				} else {
					$this->CI->message->getMsg($this->CI->message->msg['public'][8]);
				}
			} else {
				$this->CI->message->getMsg($this->CI->message->msg['public'][3]);
			}
		}
	}
	// 多選刪除
	public function mDelete($method) {
		if ($this->CI->input->method(TRUE) == 'POST') {
			// 檢查是否有權限
			if ($this->checkLimits($method . '-del') == FALSE) {
				$this->CI->message->getMsg($this->CI->message->msg['public'][2]);
			}
			if ($this->CI->input->post('id[]') != NULL) {
				$model = $method . '_model';
				$result = $this->CI->$model->mDelete();
				if ($result == TRUE) {
					$this->CI->message->getMsg($this->CI->message->msg['public'][7]);
				} else {
					$this->CI->message->getMsg($this->CI->message->msg['public'][8]);
				}
			} else {
				$this->CI->message->getMsg($this->CI->message->msg['public'][3]);
			}
		}
	}
}
