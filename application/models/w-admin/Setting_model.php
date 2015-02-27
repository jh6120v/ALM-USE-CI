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
	public function eSave() {
		try {
			// 取地址作標
			$geocodin = ($this->input->post('address', TRUE) != "") ? $this->common->location($this->input->post('address', TRUE)) : array('lat' => '', 'lng' => '');
			$data = array(
				'title' => $this->common->htmlFilter($this->input->post('title')),
				'keywords' => $this->common->htmlFilter($this->input->post('keywords')),
				'description' => $this->common->htmlFilter($this->input->post('description')),
				'lat' => $geocodin['lat'],
				'lng' => $geocodin['lng'],
				'email' => $this->common->htmlFilter($this->input->post('email')),
				'address' => $this->common->htmlFilter($this->input->post('address')),
				'phone' => $this->common->htmlFilter($this->input->post('phone')),
				'fax' => $this->common->htmlFilter($this->input->post('fax')),
				'updateTime' => date('Y-m-d H:i:s'),
			);
			$this->db->where('id', $this->input->post('id', TRUE));
			$this->db->update('setting', $data);

			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		} catch (Exception $e) {
			exit($e->getMessage());
		}
	}
}