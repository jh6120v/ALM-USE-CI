// JavaScript Document
$(document).ready(function() {
	if ($("select.position").length > 0) {
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
	}
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
