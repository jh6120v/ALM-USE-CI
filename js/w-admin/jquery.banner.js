// JavaScript Document
$(document).ready(function() {			
	$("#banner").validate({
		rules: {
			fileName: {
				required: true,
				extension: 'jpg|gif|png'
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
			fileName: {
				required: "請選擇檔案!",
				extension: '請選擇JPG、GIF、PNG格式!'
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
	ajaxSubmit(true, false);
	leave();
});