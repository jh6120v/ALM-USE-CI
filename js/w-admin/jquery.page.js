// JavaScript Document
$(document).ready(function() {
	$("input[name=tag]").on("change keyup",function(){
		if ($(this).val() == "") {
			$("span.tag").text("標籤");
		} else {
			$("span.tag").text($(this).val());
		}
	});
	$("#page").validate({
		rules: {
			title: {
				required: true,
			},
			tag: {
				required: true,
			},
			status: {
				required: true
			},
			locked: {
				required: true
			},
			position: {
				required: true
			}
		},
		messages: {
			title: {
				required: "請輸入頁面名稱!",
			},
			tag: {
				required: "請輸入標籤!",
			},
			status: {
				required: "請選擇狀態!"
			},
			locked: {
				required: "請選擇鎖定!"
			},	
			position: {
				required: "請選擇側欄位置!"
			}							
		},
	});
	ajaxSubmit(false,true);
	leave();
});
