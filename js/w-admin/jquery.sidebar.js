// JavaScript Document
$(document).ready(function() {
	CKEDITOR.replace( 'ckeditor', {
		toolbar: [
			{ name: 'document', items: [ 'Source', '-', 'Preview' ] },
			{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
			{ name: 'insert', items: [ '-','Image', 'Table', 'quicktable' ] },
			{ name: 'styles', items: [ 'FontSize', 'lineheight' ] },
		],
		extraPlugins : 'stat,lineheight',
	} );	
	$("#sidebar").validate({
		rules: {
			title: {
				required: true
			},
			locked: {
				required: true
			},
			nav: {
				required: true
			},
			position: {
				required: true
			}
		},
		messages: {
			title: {
				required: "請輸入側欄名稱!"
			},
			locked: {
				required: "請選擇鎖定!"
			},
			nav: {
				required: "請選擇選單!"
			},
			position: {
				required: "請選擇側欄位置!"
			}
		},
	});
	ajaxSubmit(false, true);
	leave();
});