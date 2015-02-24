<?php
class Setting_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function getSettingData() {
		$query = $this->db->from('setting')->limit(1)->get();
		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return FALSE;
		}
	}
	public function eSave($d) {
		try {
			// 取地址作標
			$geocodin = (isset($d["address"]) && $d["address"] != "") ? $this->common->location($d["address"]) : array('lat' => '', 'lng' => '');
			$data = array(
				'title' => $this->common->htmlFilter($d['title']),
				'keywords' => $this->common->htmlFilter($d['keywords']),
				'description' => $this->common->htmlFilter($d['description']),
				'lat' => $geocodin['lat'],
				'lng' => $geocodin['lng'],
				'email' => $this->common->htmlFilter($d['email']),
				'address' => $this->common->htmlFilter($d['address']),
				'phone' => $this->common->htmlFilter($d['phone']),
				'fax' => $this->common->htmlFilter($d['fax']),
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $d['id']);
			$this->db->update('setting', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
}