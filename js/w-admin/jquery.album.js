// JavaScript Document
$(document).ready(function() {			
	$("#album").validate({
		rules: {
			title: {
				required: true
			},
			catID: {
				required: true,
				digits: true
			},
			"sort": {
				required: true,
				digits: true
			},
			status: {
				required: true
			},
		},
		messages: {
			title: {
				required: "請輸入作品名稱!"
			},
			catID: {
				required: "請選擇分類位置!",
				digits: "錯誤分類!"
			},
			"sort": {
				required: "請輸入排序!",
				digits: "請輸入整數!"
			},
			status: {
				required: "請選擇狀態!"
			},
		},
	});
	ajaxSubmit(false, false);
	leave();
});