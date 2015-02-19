<?php
define("salt", "cb65b779772a8edb4c62a1b32e2ab673"); //原始CuZ1fho8n7xm
class Login extends CI_Model {
	public $msg = array(
		"帳號停權",
		"登入成功",
		"密碼錯誤",
		"帳號錯誤",
	);
	public function __construct() {
		parent::__construct();
	}
	public function checkLoginData($u, $p) {
		try {
			$query = $this->db->from('account')->where('username', $u)->limit(1)->get();
			if ($query->num_rows() > 0) {
				$row = $query->row();
				$password = hash_hmac('md5', $p, salt);
				// 比對密碼，若登入成功則呈現登入狀態
				if ($password == $row->password) {
					// 檢查是否為最高權限管理者
					if ($row->groups != 'administration') {
						$query = $this->db->select('acl')->from('account_group')->where(array('id' => $row->groups, 'status' => 0))->limit(1)->get();
						$row2 = $query->row();
						// 群組已關閉或本身帳號已關閉
						if ($query->num_rows() <= 0 || $row->status != '0') {
							$data = array(
								"ip" => $this->input->ip_address(),
								"pID" => $row->id,
								"name" => $row->name,
								"username" => $row->username,
								"message" => $this->msg[0],
							);
							$this->db->insert('account_record', $data);

							return array(0, $this->message->msg['login'][8]);

						} else {
							$this->session->set_userdata('acl', unserialize($row2->acl));
						}
					} else {
						$this->session->set_userdata('acl', 'administration');
					}
					// 計算登入次數及更新登入時間
					$data = array(
						'loginTime' => NOW(), 
						'ip' => $this->input->ip_address()
					);
					$this->db->update('account', $data)->where('id', $row->id);

					$userdata = array(
						'pID' => $row->id,
						'pName' => $row->name,
						'status' => 'success',
					);
					$this->session->set_userdata($userdata);

					if (isset($this->input->post('rememberme')) && $this->input->post('rememberme') == 'true') {
						$this->input->set_cookie( 'remUser', $u, time () + 365 * 24 * 60, NULL, NULL, FALSE, TRUE );
						$this->input->set_cookie( 'remPass', $p, time () + 365 * 24 * 60, NULL, NULL, FALSE, TRUE );
					} else if (isset($this->input->cookie('remUser', TRUE)) {
						$this->input->set_cookie ( 'remUser', $u, time () - 100 );
						$this->input->set_cookie ( 'remPass', $p, time () - 100 );
					}

					$data = array(
						"ip" => $this->input->ip_address(),
						"pID" => $row->id,
						"name" => $row->name,
						"username" => $row->username,
						"message" => $this->msg[1],
					);
					$this->db->insert('account_record', $data);

					return array(1, $this->message->msg['login'][6], '/w-admin/home');
				} else {
					// 密碼錯誤!
					$data = array(
						"ip" => $this->input->ip_address(),
						"pID" => $row->id,
						"name" => $row->name,
						"username" => $row->username,
						"message" => $this->msg[2],
					);
					$this->db->insert('account_record', $data);

					return array(0, $this->message->msg['login'][4]);
				}
			} else {
				// 帳號不存在!
				$data = array(
					"ip" => $this->input->ip_address(),
					"pID" => 0,
					"name" => '未知',
					"username" => '未知',
					"message" => $this->msg[3],
				);
				$this->db->insert('account_record', $data);

				return array(0, $this->message->msg['login'][5]);
			}
		} catch (PDOException $e) {
			exit($e->getMessage());
		}
	}
}