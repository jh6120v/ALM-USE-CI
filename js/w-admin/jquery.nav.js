//JavaScript Document
$(function() {
	$("#nav").validate({
		rules: {
			title: {
				required: true,
			},
			pNav: {
				require: true
			},
			status: {
				required: true
			}
		},
		messages: {
			title: {
				required: "請輸入選單名稱!",
			},
			pNav: {
				require: "請選擇是否為主選單!"
			},
			status: {
				required: "請選擇狀態!"
			}
		},
	});
	//ajaxSubmit(false, false);
	leave();
});