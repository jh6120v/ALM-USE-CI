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
	public function getSortData($id = FALSE) {
		if ($id == FALSE) {
			$query = $this->db->from('sort')->order_by('id', 'ASC')->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			} else {
				return FALSE;
			}
		} else {
			$query = $this->db->from('sort')->where('id', $id)->limit(1)->get();
			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return FALSE;
			}
		}
	}
	public function eSave($d) {
		try {
			$data = array(
				'sort' => $d['sort'],
				'orderBy' => $d['orderBy'],
				'sort2' => $d['sort2'],
				'orderBy2' => $d['orderBy2'],
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $d['id']);
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