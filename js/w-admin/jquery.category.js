//JavaScript Document
$(function() {
	$("#category").validate({
		rules: {},
		messages: {},
	});
	//ajaxSubmit(false, false);
	leave();
	$('#nestable').nestable();
    $("div.dd-nav").on("click", "span.edit", function(){
        $(this).nextAll("div.dd-edit").slideToggle("fast");
    });
    $("div.dd-nav").on("click", "input.close-item", function(){
        $(this).closest("div.dd-edit").slideUp("fast");
    });
    $("input#add-item").on("click",function() {
        var id = new Date().getTime(),
            name = $("input#name").val();
        if (name == "") {
            alert("請輸入項目名稱!");
            return false;
        }
        var tpl =
            '<li class="dd-item" data-id="'+id+'" data-name="'+filterChar(name)+'">'+
            '   <span class="edit icon-arrow-down8"></span>'+
            '   <div class="dd-handle">'+filterChar(name)+'</div>'+
            '   <div class="dd-edit">'+
            '       <div class="item">'+
            '           <label>名稱：</label>'+
            '           <input type="text" class="name regular-text-3" value="'+filterChar(name)+'">'+
            '       </div>'+
            '       <div class="item">'+
            '           <input type="button" class="remove-item button" value="移除">'+
            '           <input type="button" class="close-item button" value="關閉">'+
            '       </div>'+
            '   </div>'+
            '</li>';

        if ($("#nestable > ol.dd-list").length == 0) {
            $("#nestable").append('<ol class="dd-list">'+ tpl +'</ol>');
        } else {
            $("#nestable > ol.dd-list").append(tpl);
        }
    });
    $("div.dd-nav").on("click", "input.remove-item", function(){
        var li = $(this).closest("li.dd-item");
        if ( li.children("ol.dd-list").length == 0 ) {
            li.slideUp("fast", function(){
                if (li.siblings().length < 1 ) {
                    li.parent("ol.dd-list").remove();
                } else {
                    li.remove();
                }
            });
        } else {
            var body = li.find("li.dd-item").clone();
            li.after(body).remove();
        }
    });
    $("div.dd-nav").on("change keyup", "input.name", function(){
        var name = $(this).val();
        if (filterChar(name) == "") {
            alert("請輸入名稱!");
            return false;
        } else {
           $(this).closest("li.dd-item").data("name", filterChar(name)).attr("data-name", filterChar(name)).children("div.dd-handle").text(filterChar(name));
        }
    });
    $("input#goButton").click(function(e) {
        e.preventDefault();
        if ($("form#" + $(this).data("page")).valid()) {
            $(window).unbind('beforeunload'); //取消綁定
            $(this).prop('disabled', 'disabled'); //執行送出時先鎖定按鈕，以避免使用者重複送出。
            $(this).after(
                $("<input>").attr({
                    "type":"hidden",
                    "name":"mData",
                    "value":window.JSON.stringify($('#nestable').nestable('serialize'))
                })
            );

            $("form#" + $(this).data("page")).ajaxSubmit({
                type: "POST",
                url: $(this).parents("form").attr("action"),
                dataType: "json",
                timeout: 10000,
                success: function(json) {
                    if (json.success == true) {
                        ajaxMessage(1, json.msg, json.url);
                    } else {
                        $("input[name=mData]").remove();
                        ajaxMessage(2, json.msg);
                    }
                },
                error: function() {
                    $("input[name=mData]").remove();
                    ajaxMessage(2, "Error!");
                },
            });
            return false;
        } else {
            $("form#" + $(this).data("page")).validate().focusInvalid();
            return false;
        }
    });
});