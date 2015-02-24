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
		"使用者" => array(
			"tag" => "users",
			"icon" => "icon-users",
			"subMenu" => array(
				"全部帳號" => array(
					"tag" => "account",
					"url" => "account.php",
				),
				"新增帳號" => array(
					"tag" => "account-add",
					"url" => "account.php?act=add",
				),
				"登入紀錄" => array(
					"tag" => "account-record",
					"url" => "account.php?act=record",
				),
				"群組管理" => array(
					"tag" => "group",
					"url" => "group.php",
				),
			),
		),
		"頁面" => array(
			"tag" => "main",
			"icon" => "icon-list",
			"subMenu" => array(
				"全部頁面" => array(
					"tag" => "pages",
					"url" => "pages.php",
				),
				"新增頁面" => array(
					"tag" => "pages-add",
					"url" => "pages.php?act=add",
				),
				"分類" => array(
					"tag" => "category",
					"url" => "category.php",
				),
			),
		),
		"功能" => array(
			"tag" => "function",
			"icon" => "icon-grid",
			"subMenu" => array(
				"橫幅廣告" => array(
					"tag" => "banner",
					"url" => "banner.php",
				),
				"設計作品分類" => array(
					"tag" => "works-category",
					"url" => "works-category.php",
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