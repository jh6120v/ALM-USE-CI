// JavaScript Document
$(function() {
	CKEDITOR.replace( 'ckeditor', {
		extraPlugins : 'stat,qrc,lineheight,autogrow',
		autoGrow_minHeight : 400
	} );	
	$("#layout").validate({
		rules: {
			seoTitle: {
				required: true
			},
			seoKey: {
				required: true
			},
			seoDesc: {
				required: true
			},
			position: {
				required: true
			}
		},
		messages: {
			seoTitle: {
				required: "請輸入標題!"
			},
			seoKey: {
				required: "請輸入關鍵字!"
			},
			seoDesc: {
				required: "請輸入描述!"
			},
			position: {
				required: "請選擇側欄位置!"
			}
		},
	});
	ajaxSubmit(false, true);
	leave();
	$("select.position").on("change", function() {
		$this = $(this).find(":selected").val();
		if($this == 1 || $this == 2) {
			editor.setReadOnly(false);			
			$(".nav").prop("disabled",false);
		} else {
			editor.setReadOnly();			
			$(".nav").prop("disabled",true);
		}
	});

});