// JavaScript Document
$(document).ready(function() {		
	$("input[name=mode]").on("click",function() {
		$this = $(this).val();
		if($this == 1) {
			editor.setReadOnly(false);			
			$(".plugin").prop("disabled",true);
			$(".url, .urlTarget").prop("disabled",true);			
		} else if($this == 2) {
			editor.setReadOnly();			
			$(".plugin").prop("disabled",false);
			$(".url, .urlTarget").prop("disabled",true);			
		} else if($this == 3) {
			editor.setReadOnly();			
			$(".plugin").prop("disabled",true);
			$(".url, .urlTarget").prop("disabled",false);			
		} else {
			editor.setReadOnly();			
			$(".plugin").prop("disabled",true);
			$(".url, .urlTarget").prop("disabled",true);			
		}
	});
	
	$("#pages").validate({
		rules: {
			title: {
				required: true,
			},
			tag: {
				required: true,
			},
			catID: {
				required: true,
			},
			"sort": {
				required: true,
				digits: true
			},
			status: {
				required: true
			},
			locked: {
				required: true
			},
			mode: {
				required: true,
			},
			plugin: {
				required: true
			},
			url: {
				required: true
			},
			urlTarget: {
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
			catID: {
				required: "請選擇分類位置!",
			},
			"sort": {
				required: "請輸入排序!",
				digits: "請輸入整數!"
			},
			status: {
				required: "請選擇狀態!"
			},
			locked: {
				required: "請選擇鎖定!"
			},			
			mode: {
				required: "請選擇模式!",
			},			
			plugin: {
				required: "請選擇插件!",
			},	
			url: {
				required: ""
			},
			urlTarget: {
				required: ""
			}					
		},
	});
	ajaxSubmit(false,true);
	leave();
});
