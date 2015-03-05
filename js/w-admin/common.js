// JavaScript Document
$(window).load(function() {
	$(".actionChange").prop('selectedIndex', 0);
	$("ul#top-bar > li > a").on("touchstart", function(e) {
		//e.preventDefault();	
		$(this).next("ul").show();
		$('ul#top-bar > li > a').not(this).next("ul").hide();
	});

	$(document).on("touchstart", function(e) {
		if ($(e.target).closest("ul#top-bar > li").length == 0) {
			$("ul#top-bar > li").children("ul").hide();
		}
	});

	$("#menu-toggle").on("click touchstart", function(e) {
		e.preventDefault();
		$(this).toggleClass("active");
		$("#w-wrap").toggleClass("rwd");
	});

	$(window).on('load resize orientationchange scroll', function() {
		$win_width = $(window).width(),
		$this_Top = $(window).scrollTop();

		if ($win_width < 768) {
			if (!$("#menu-toggle").hasClass("active")) {
				$("#w-wrap").removeClass("rwd");
			} else {
				$("#w-wrap").addClass("rwd");
			}
		}
		if ($this_Top > 90) {
			$("#w-footer").fadeIn({
				display: "block"
			});
		} else {
			$("#w-footer").fadeOut({
				display: "none"
			});
		}
	}).scroll();

	$("ul.w-menu > li.none-select > a").on("click touchstart", function(e) {
		e.preventDefault();
		$(this).parent("li").toggleClass("show");
	});

	if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
		$("table.list-table").addClass("mobile");
	}

	$('.selectAll').on("click", function() {
		var $checkbox = $("input.checkboxID:not(:disabled)")
		$checkbox.attr('checked', !!$(this).attr('checked'));
		$('.selectAll').attr('checked', !!$(this).attr('checked'))
	});

	$(document).on("click", "input.checkboxID", function() {
		var $checkbox = $("input.checkboxID:not(:disabled)"),
			$isSelAll = $checkbox.length == $checkbox.filter(':checked').length;
		$('.selectAll').attr('checked', $isSelAll);
	});

	$(document).on("change", ".actionChange", function() {
		var act = $(this).children('option:selected').val();
		if (act != "") {
			if ($("input[name='id[]']:checked").toArray() == '') {
				alert('沒有選擇!');
				$(this).prop('selectedIndex', 0);
				return false;
			}
			if (confirm('確定執行?')) {
				$("form.form").attr("action", $("form.form").attr("action") + "/" + act).submit();
				return true;
			} else {
				$(this).prop('selectedIndex', 0);
				return false;
			}
		} else {
			$(this).prop('selectedIndex', 0);
			return false;
		}	
	});
	$(document).on("click", "input#search", function(){
		$("form#search-form").attr("action",$("form.form").attr("action") + "/search").submit();
	});

	$('span.gotop').on("click touchstart", function() {
		$('html,body').animate({
			scrollTop: 0
		}, 500);
	});

	$(document).on('click', '.pages a', function(event) {
		$.pjax.click(event, '#w-body-content', {
			scrollTo: $(".nav-top").offset().top - 30
		});
	});
	$(document).on('pjax:send', function() {
		$('#loading').show();
	});
	$(document).on('pjax:complete', function() {
		setTimeout(function() {
			$('#loading').hide()
		}, 500);
	});

});
//處理CKEDITOR的值
function CKupdate() {
	for (instance in CKEDITOR.instances)
		CKEDITOR.instances[instance].updateElement();
}

function ajaxSubmit(fileUpload, editor) {
	$("input#goButton").click(function() {
		if ($("form#" + $(this).data("page")).valid()) {
			$(window).unbind('beforeunload'); //取消綁定
			$(this).prop('disabled', 'disabled'); //執行送出時先鎖定按鈕，以避免使用者重複送出。
			if (editor == true) {
				CKupdate();
			}

			//var formData=$("form#"+$(this).data("page")).serialize();

			$("form#" + $(this).data("page")).ajaxSubmit({
				type: "POST",
				url: $(this).parents("form").attr("action"),
				dataType: "json",
				//data: formData,
				beforeSubmit: function() {
					//check whether browser fully supports all File API
					if (fileUpload == true) {
						if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
							ajaxMessage(2, "Please upgrade your browser, because your current browser lacks some new features we need!");
							return false;
						}
					}
				},
				uploadProgress: function(event, position, total, percentComplete) {
					//Progress bar
					$('#progress-box').show();
					$('#progressbar').width(percentComplete + '%') //update progressbar percent complete
					$('#statustxt').html(percentComplete + '%'); //update status text
					if (percentComplete > 50) {
						$('#statustxt').css('color', '#FFF'); //change status text to white after 50%
					} else {
						$('#statustxt').css('color', '#666'); //change status text to white after 50%
					}
				},
				timeout: 10000,
				success: function(json) {
					if (json.success == true) {
						ajaxMessage(1, json.msg, json.url);
					} else {
						ajaxMessage(2, json.msg);
					}
				},
				complete: function() {
					$('#progress-box').fadeOut();
				},
				error: function() {
					ajaxMessage(2, "Error!");
				},
			});
			return false;

		} else {
			$("form#" + $(this).data("page")).validate().focusInvalid();
			return false;
		}
	});
}

function ajaxMessage(method, msg, url) {
	if (method == 1) {
		alert(msg);
		window.location.href = url;
		return false;
	} else if (method == 2) {
		$(".ajax-response").fadeIn().html(msg);
		$('html,body').animate({
			scrollTop: 0
		}, 300);
		leave(); //重新綁定
		$("input#goButton").removeProp('disabled');
		setTimeout(function() {
			$(".ajax-response").slideUp().html("");
		}, 3000);
		return false;
	}
}

function leave() {
	var isChanged = false;
	$('input, textarea, select').on("change keypress", function() {
		isChanged = true;
	});

	$(window).bind('beforeunload', function() {
		if (isChanged) {
			return '表單有可能尚未完成，您確定要離開此頁面嗎?';
		}
	});
}

function changeStatus(id, act) {
	if (id == "" || act == "") {
		alert("Error!");
		return false;
	}
	$.ajax({
		type: "POST",
		url: $("form.form").attr("action") + "/" + act,
		dataType: "json",
		data: {
			"id": id,
			"csrf_token":$("input[name=csrf_token]").val()
		},
		timeout: 10000, //ajax请求超时时间10秒     								
		success: function(json) {
			if (json.success == true) {
				ajaxMessage(2, json.msg);
				$("span#status-" + id).toggleClass("red green").children("a").attr("onClick", "changeStatus(" + id + ",'" + json.act + "')").text(json.name);
				$("tr#" + $("form.form").data("page") + "-" + id).find("span.past").attr("title", json.updateTime).timeago("updateFromDOM");
			} else {
				ajaxMessage(2, json.msg);
			}
		},
		error: function() {
			ajaxMessage(2, "Error!");
		}
	});
}

function del(id) {
	if (id == "") {
		alert("Error!");
		return false;
	}
	if (confirm("您真的確定要刪除嗎？\n\n請確認！") == true) {
		$.ajax({
			type: "POST",
			url: $("form.form").attr("action") + "/delete",
			dataType: "json",
			data: {
				"id": id,
				"csrf_token":$("input[name=csrf_token]").val()
			},
			timeout: 10000, //ajax请求超时时间10秒     								
			success: function(json) {
				if (json.success == true) {
					ajaxMessage(2, json.msg);
					$("tr#" + $("form.form").data("page") + "-" + id).fadeOut("slow", function() {
						$(this).remove();
						if ($("tbody#list > tr").length <= 0) {
							$("tbody#list").html("<tr><td colspan='10' class='column-nodata'>目前沒有資料</td></tr>");
						}
					});

				} else {
					ajaxMessage(2, json.msg);
				}
			},
			error: function() {
				ajaxMessage(2, "Error!");
			}
		});
	} else {
		return false;
	}
}
function filterChar(pNameStr, pReplaceStr) {
	//var specials = [" ", "-", "[", "]", "/", "{", "}", "(", ")", "*", "+", "=", "?", ".", ",", "\\", "^", "$", "|", "~", "#", "%", "&", "'", "\"", "!", "@", ";", ":", "<", ">", "_", "`"];
	var specialsUrl = [" ", "[", "]", "{", "}", "(", ")", "*", ",", "^", "$", "|", "'", "\"", "!", "@", ";", "<", ">", "`"];
	
	var regex = RegExp('[' + specialsUrl.join('\\') + ']', 'g');
	var replaceStr = "";
	if(null != pReplaceStr){
    	replaceStr = pReplaceStr;
	};
  	var str = pNameStr;
  	str = str.replace(regex,replaceStr);
 	return str;
}
