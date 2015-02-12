//JavaScript Document
$(function() {
	$("#group").validate({
		rules: {
			title: {
				required:true,
			},
			status: {
				required: true
			}
		},
		messages: {
			title: {
				required: "請輸入群組名稱!",
			},
			status: {
				required: "請選擇狀態!"
			}
		},
	});
	ajaxSubmit(false, false);
	leave();
});
function checknode(obj) {
	var chk = $("input[type='checkbox']");
	var count = chk.length;  //總數
	var num = chk.index(obj);  //第幾個
	var level_top = level_bottom = chk.eq(num).attr('level');
	for (var i = num; i >= 0; i--) {
		var le = chk.eq(i).attr('level');
		if (eval(le) < eval(level_top)) {
			chk.eq(i).attr("checked", true);
			var level_top = level_top - 1
		}
	}
	for (var j = num + 1; j < count; j++) {
		var le = chk.eq(j).attr('level');
		if (chk.eq(num).attr("checked") == true) {
			if (eval(le) > eval(level_bottom)) chk.eq(j).attr("checked", true);
			else if (eval(le) == eval(level_bottom)) break
		} else {
			if (eval(le) > eval(level_bottom)) chk.eq(j).attr("checked", false);
			else if (eval(le) == eval(level_bottom)) break
		}
	}
}