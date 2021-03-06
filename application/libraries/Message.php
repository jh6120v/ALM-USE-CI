<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message {
	public $status = array(
		"open" => array(0, "close", "已開啟", 11),
		"close" => array(1, "open", "已關閉", 10),
		"mOpen" => array(0, 11),
		"mClose" => array(1, 10),
	);
	public $msg = array(
		"public" => array(
			0 => "系統嚴銃錯誤!",
			1 => "請先登入系統!",
			2 => "權限不足!",
			3 => "沒有選擇!",
			4 => "必要欄位未選擇或輸入!",
			5 => "新增成功!",
			6 => "修改成功!",
			7 => "刪除成功!",
			8 => "執行失敗!",
			9 => "不得操作此功能!",
			10 => "已關閉!",
			11 => "已開啟!",
			12 => "檔案大小超出限制!",
			13 => "檔案類型錯誤!",
			14 => "上傳檔案失敗!",
			15 => "清除緩存成功!",
		),
		"login" => array(
			0 => "請輸入帳號!",
			1 => "請輸入密碼!",
			2 => "請輸入驗證碼!",
			3 => "驗證碼錯誤!",
			4 => "密碼錯誤!",
			5 => "帳號錯誤!",
			6 => "登入成功!",
			7 => "帳號停權中!",
			8 => "登出中!",
			9 => "登入系統中!",
			10 => "偵測到不合法字元!",
		),
		"group" => array(
			0 => "請選擇權限!",
		),
		"account" => array(
			0 => "請輸入使用者名稱!",
			1 => "請輸入密碼!",
			2 => "兩次輸入的密碼不相同!",
			3 => "請輸入名稱!",
			4 => "請輸入舊密碼!",
			5 => "請輸入新密碼!",
			6 => "舊密碼錯誤!",
			7 => "新舊密碼不得相同!",
			8 => "此帳號已有人註冊!",
			9 => "此帳號不得刪除!",
			10 => "群組不存在!",
			11 => "修改成功，請重新登入!",
			12 => "請選擇群組!",
			13 => "請選擇狀態!",
			14 => "請選擇鎖定!",
		),
		"category" => array(
			0 => "標籤名稱重複!",
			1 => "此上層無法新增分類",
		),
		"pages" => array(
			0 => "標籤名稱重複!",
			1 => "請選擇模式!",
			2 => "此分類無法新增頁面!",
			3 => "請選擇插件!",
			4 => "分類錯誤!",
		),
		"banner" => array(
			0 => "橫幅廣告數量不得低於一張!",
		),
		"works" => array(
			0 => "分類錯誤!",
		),
		"album" => array(
			0 => "分類錯誤!",
		),
		"mgroup" => array(
			0 => "請輸入群組名稱!",
		),
		"members" => array(
			0 => "請輸入帳號!",
			1 => "請輸入密碼!",
			2 => "兩次輸入密碼不同!",
			3 => "請輸入姓名!",
			4 => "請輸入行動電話!",
			5 => "行動電話格式錯誤!",
			6 => "請輸入電子郵件!",
			7 => "此帳號已有人註冊!",
		),
		"sms" => array(
			0 => "簡訊系尚未設置成功!",
			1 => "剩餘點數不足!",
			2 => "請選擇發送對象!",
			3 => "發送成功!",
			4 => "請輸入主旨!",
			5 => "超出每小時發送流量!",
		),
	);

	public static function getMsg($t, $u = "") {
		if (isset($u) && $u != "") {
			echo "
			<script language=\"javascript\">
				alert(\"$t\");
				location.href=\"$u\";
			</script>";
			exit();
		} else {
			echo "
			<script language=\"javascript\">
				alert(\"$t\");
				location.href=\"javascript:history.back(-1)\";
			</script>";
			exit();
		}
	}

	public static function getAjaxMsg($data) {
		echo json_encode($data);
		exit();
	}
}
