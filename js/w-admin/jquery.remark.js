// JavaScript Document
$(function() {
	CKEDITOR.replace( 'ckeditor', {
		extraPlugins : 'stat,qrc,lineheight,autogrow',
		autoGrow_minHeight : 400
	} );	
	$("#remark").validate({
		rules: {
		},
		messages: {
		},
	});
	ajaxSubmit(false, true);
	leave();
});