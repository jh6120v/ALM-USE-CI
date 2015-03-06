// JavaScript Document
$(function() {
	CKEDITOR.replace( 'ckeditor', {
		extraPlugins : 'stat,qrc,lineheight,autogrow',
		autoGrow_minHeight : 400
	} );	
	$("#layout").validate({
		rules: {
		},
		messages: {
		},
	});
	ajaxSubmit(false, true);
	leave();
	$("select.position").on("change",function() {
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