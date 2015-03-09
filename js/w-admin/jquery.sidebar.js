// JavaScript Document
$(document).ready(function() {
	CKEDITOR.replace( 'ckeditor', {
		toolbar: [
			{ name: 'document', items: [ 'Source', '-', 'Preview' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ '-','Image', 'Table', 'quicktable' ] },
			{ name: 'styles', items: [ 'FontSize', 'lineheight' ] },
		],
		extraPlugins : 'stat,qrc,lineheight',
		on : {
			instanceReady: function(ev) {
				editor = ev.editor;
			}
		}
	} );	
	$("select.position").on("change", function() {
		$this = $(this).find(":selected").val();
		if($this == 2 || $this == 3) {
			editor.setReadOnly(false);			
			$(".nav").prop("disabled",false);
		} else {
			editor.setReadOnly();			
			$(".nav").prop("disabled",true);
		}
	});
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
});