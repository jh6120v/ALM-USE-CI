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
	ajaxSubmit();
	
	$("#captcha").click(function(){
		var d = new Date();
		$(this).prop("src","/captcha?t="+d.toTimeString());
	});
	
	function ajaxSubmit(){
		$("input#goButton").click(function(e){
			e.preventDefault();
			if($("form#"+$(this).data("page")).valid()){
				$(this).prop('disabled', 'disabled');  //執行送出時先鎖定按鈕，以避免使用者重複送出。
							
				var formData=$("form#"+$(this).data("page")).serialize();	
				$.ajax({ 
					type: "POST", 
					url: $(this).parents("form").attr("action"), 
					dataType: "json", 
					data: formData,
					timeout:10000,     //ajax请求超时时间10秒     								
					success: function(json){ 
						if(json.success == true){
							ajaxMessage(1,json.msg,json.url);
						}else{
							ajaxMessage(2,json.msg);
						}
					},
					error: function(){
						ajaxMessage(2,"Error!");
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
		}else if(method == 2){
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