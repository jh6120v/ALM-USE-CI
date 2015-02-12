// JavaScript Document
$(document).ready(function() {
	$("#works-category").validate({
		rules: {
			catName: {
				required: true,
			},
			"sort": {
				required: true,
				digits: true,
			},
			status: {
				required: true
			},
			locked: {
				required: true
			}
		},
		messages: {
			catName: {
				required: "請輸入分類名稱!",
			},
			"sort": {
				required: "請輸入排序!",
				digits: "請數入數字!",
			},
			status: {
				required: "請選擇狀態!"
			},
			locked: {
				required: "請選擇鎖定!"
			}			
		},
	});
	ajaxSubmit(false, false);
	leave();
});