// JavaScript Document
$(function() {
	$("#sort").validate({
		rules: {
			"sort": {
				required: true,
			},
			orderBy: {
				required:true,
			},
			"sort2": {
				required: true,
			},
			orderBy2: {
				required:true,
			}			
		},
		messages: {
			"sort": {
				required: "請選擇主要依據!",
			},
			orderBy: {
				required: "請選擇主要方式!",
			},
			"sort2": {
				required: "請選擇次要依據!",
			},
			orderBy2: {
				required: "請選擇次要方式!",
			}			
		},
	});
	ajaxSubmit();
	leave();
});