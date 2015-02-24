// JavaScript Document
$(function() {
	$("#setting").validate({
		rules: {
			title: {
				required: true,
			},
			email: {
				required:true,
				email: true
			}
		},
		messages: {
			title: {
				required: "請輸入網站標題!",
			},
			email: {
				required: "請輸入電子郵件!",
				email: "格式錯誤!"
			}
		},
	});
	ajaxSubmit(false, false);
	leave();
});