// JavaScript Document
$(function() {
	$("#login").validate({
		rules: {
			username: {
				required: true,
			},
			password: {
				required: true,
			},
			captcha: {
				required: true,
				rangelength: [4, 4],
			},
		},
		messages: {
			username: {
				required: "請輸入帳號!",
			},
			password: {
				required: "請輸入密碼!",
			},
			captcha: {
				required: "",
				rangelength: "",
			},			
		},
	});
	ajaxSubmit(false, false)
	
	$("#captcha").click(function(){
		var d = new Date();
		$(this).prop("src","/captcha?t="+d.toTimeString());
	});
	
	function ajaxSubmit(){
		$("input#goButton").click(function(){
			if($("form#"+$(this).data("page")).valid()){
				$(this).prop('disabled', 'disabled');  //執行送出時先鎖定按鈕，以避免使用者重複送出。
							
				var formData=$("form#"+$(this).data("page")).serialize();	
				$.ajax({ 
					type: "POST", 
					url: location.href, 
					dataType: "json", 
					data: formData,
					timeout:10000,     //ajax请求超时时间10秒     								
					success: function(json){ 
						if(json.success==1){
							ajaxMessage(1,json.msg,json.url);
						}else{
							ajaxMessage(0,json.msg);
						}
					},
					error: function(){
						ajaxMessage(0,"Error!");
					}						 		
				}); 
			}else{
				$("form#"+$(this).data("page")).validate().focusInvalid();
				return false;	
			}
		});	
	}
	function ajaxMessage(method,msg,url){
		if(method == 1){
			alert(msg);
			window.location.href=url;
			return false;
		}else{
			$(".ajax-response").fadeIn().html(msg);
			$('html,body').animate({scrollTop:0}, 300);
			$("input#goButton").removeProp('disabled');
			setTimeout(function(){
				$(".ajax-response").slideUp().empty();
			},3000);
			return false;
		}
	}
});