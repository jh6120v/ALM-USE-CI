<?php
class Menu_model extends CI_Model {
	private $menu = array(
		"控制台" => array(
			"tag" => "console",
			"icon" => "icon-console",
			"subMenu" => array(
				"首頁" => array(
					"tag" => "home",
					"url" => "/w-admin/home",
				),
				"備註板" => array(
					"tag" => "remark",
					"url" => "/w-admin/remark",
				),
			),
		),
		"系統設置" => array(
			"tag" => "system",
			"icon" => "icon-settings2",
			"subMenu" => array(
				"基本設置" => array(
					"tag" => "setting",
					"url" => "/w-admin/setting",
				),
				"排序設定" => array(
					"tag" => "sort",
					"url" => "/w-admin/sort",
				),
			),
		),
		"版面設置" => array(
			"tag" => "layouts",
			"icon" => "icon-screen",
			"subMenu" => array(
				"側欄設定" => array(
					"tag" => "sidebar",
					"url" => "/w-admin/sidebar",
				),
				"選單管理" => array(
					"tag" => "nav",
					"url" => "/w-admin/nav",
				),
			),
		),
		"使用者" => array(
			"tag" => "users",
			"icon" => "icon-users",
			"subMenu" => array(
				"全部帳號" => array(
					"tag" => "account",
					"url" => "/w-admin/account",
				),
				"新增帳號" => array(
					"tag" => "account-add",
					"url" => "/w-admin/account/add",
				),
				"登入紀錄" => array(
					"tag" => "account-record",
					"url" => "/w-admin/account/record",
				),
				"群組管理" => array(
					"tag" => "group",
					"url" => "/w-admin/group",
				),
			),
		),
		"頁面" => array(
			"tag" => "pages",
			"icon" => "icon-list",
			"subMenu" => array(
				"全部頁面" => array(
					"tag" => "page",
					"url" => "/w-admin/page",
				),
				"新增頁面" => array(
					"tag" => "page-add",
					"url" => "/w-admin/page/add",
				),
			),
		),
		"功能" => array(
			"tag" => "function",
			"icon" => "icon-grid",
			"subMenu" => array(
				"橫幅廣告" => array(
					"tag" => "banner",
					"url" => "/w-admin/banner",
				),
				"設計作品分類" => array(
					"tag" => "worksCategory",
					"url" => "/w-admin/worksCategory",
				),
				"設計作品" => array(
					"tag" => "works",
					"url" => "works.php",
				),
			),
		),
		"BETA" => array(
			"tag" => "beta",
			"icon" => "icon-info2",
			"subMenu" => array(
				"相簿分類" => array(
					"tag" => "album-category",
					"url" => "album-category.php",
				),
				"相簿" => array(
					"tag" => "album",
					"url" => "album.php",
				),

			),
		),
	);
	public function __construct() {
		parent::__construct();
	}
	public function menuData() {
		return $this->menu;
	}
}