<?php
class Sort_model extends CI_Model {
	private $sort = array(
		"sort" => array(
			"title" => "名稱",
			"catName" => "分類名稱",
			"url" => "連結",
			"addTime" => "日期",
			"sort" => "排序",
		),
		"orderBy" => array(
			"ASC" => "遞增排列",
			"DESC" => "遞減排列",
		),
	);
	private $orderByArray = array(
		"ASC" => "遞增排列",
		"DESC" => "遞減排列",
	);
	public function __construct() {
		parent::__construct();
	}
	public function getSortData($act) {
		if ($act == 'list') {
			$query = $this->db->from('sort')->order_by('id', 'ASC')->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else if ($act == 'edit') {
			$query = $this->db->from('sort')->where('id', $this->uri->segment(4))->limit(1)->get();
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	public function eSave() {
		try {
			$data = array(
				'sort' => $this->input->post('sort', TRUE),
				'orderBy' => $this->input->post('orderBy', TRUE),
				'sort2' => $this->input->post('sort2', TRUE),
				'orderBy2' => $this->input->post('orderBy2', TRUE),
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $this->input->post('id', TRUE));
			$this->db->update('sort', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
	public function getListSortName() {
		return $this->sort;
	}
	public function getSortArray($type) {
		switch ($type) {
			case "pages":
			case "works":
			case "album":
			case "albumPhoto":
				$sortArray = array(
					"title" => "名稱",
					"addTime" => "日期",
					"sort" => "排序",
				);
				break;
			case "banner":
				$sortArray = array(
					"url" => "連結",
					"addTime" => "日期",
					"sort" => "排序",
				);
				break;
			case "worksCategory":
			case "albumCategory":
				$sortArray = array(
					"catName" => "分類名稱",
					"addTime" => "日期",
					"sort" => "排序",
				);
				break;
		}
		return $sortArray;
	}
	public function getOrderByArray() {
		return $this->orderByArray;
	}
}