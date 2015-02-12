// JavaScript Document
$(document).ready(function() {
	$("#account").validate({
		rules: {
			username: {
				required: true,
				minlength: 5
			},
			pass1: {
				required: true,
				minlength: 5
			},
			pass2: {
				required: true,
				minlength: 5,
				equalTo: "#pass1"
			},					
			name: {
				required: true,
			},
			groups: {
				required: true
			},
			status: {
				required: true
			},
			locked: {
				required: true
			},
			//修改部分
			pass3: {
				required: true,
				minlength: 5
			},
			pass4: {
				required: false,
				minlength: 5
			},
			pass5: {
				required: false,
				minlength: 5,
				equalTo: "#pass4"
			},						
		},
		messages: {
			username: {
				required: "請輸入帳號!",
				minlength: "帳號至少需要5字元!"
			},
			pass1: {
				required: "請輸入密碼!",
				minlength: "密碼至少需要5字元!"
			},
			pass2: {
				required: "請輸入確認密碼!",
				minlength: "確認密碼至少需要5字元!",
				equalTo: "請輸入與密碼相同的字元!"
			},									
			name: {
				required: "請輸入名稱!",
			},
			groups: {
				required: "請選擇群組!"
			},		
			status: {
				required: "請選擇狀態!"
			},
			locked: {
				required: "請選擇鎖定!"
			},				
			//修改部分
			pass3: {
				required: "請輸入舊密碼!",
				minlength: "舊密碼至少需要5字元!"
			},
			pass4: {
				required: "請輸入新密碼!",
				minlength: "新密碼至少需要5字元!"
			},
			pass5: {
				required: "請輸入確認密碼!",
				minlength: "確認密碼至少需要5字元!",
				equalTo: "請輸入與新密碼相同的字元!"
			},									
		},
	});
	ajaxSubmit(false, false);
	leave();

	$('#username').on("keyup",function(){
		var username = $('#username').val();
		
		if(username == "" || username.length < 5){
			$("span.uCheck").remove();
		}else{
			$.ajax({ 
				type: "POST", 
				url: "ajaxData.php", 
				dataType: "json", 
				data: {"username":username,"act":"userCheck"}, 
				success: function(json){ 
					$("span.uCheck").remove();

					if($("#username").next("label").length == 0){
						$("#username").after("<span class='uCheck'></span>");
					}else{
						$("#username").next("label").after("<span class='uCheck'></span>");
					}
					
					if(json.success == 1){
						$("span.uCheck").addClass("userOK").text(json.msg);
					}else{
						$("span.uCheck").addClass("userNOOK").text(json.msg);
					}
				},
				error: function(){
					alert("存取錯誤!");
					return false;
				}
			}); 
		}
	});
	
	$(".password").passStrength({
		userid:	"#username"
	});

});