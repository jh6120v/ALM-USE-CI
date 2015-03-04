<link rel="stylesheet" href="/css/w-admin/nestable.css">
<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.nav.js"></script>
<script src="/js/w-admin/jquery.nestable.js"></script>
<script>
$(function(){
    $('#nestable').nestable();
    $("input#btn").on("click",function(){
        alert(window.JSON.stringify($('#nestable').nestable('serialize')));
    });
    $("div.dd-nav").on("click", "span.edit", function(){
        $(this).nextAll("div.dd-edit").slideToggle("fast");
    });
    $("div.dd-nav").on("click", "input.close-item", function(){
        $(this).closest("div.dd-edit").slideUp("fast");
    });
    $("select#fast").on("click", function(){
        var text = $(this).find(":selected").val();
        if (text != 0) {
            $("input#link").val(text);
        }
    });
    $("input#add-item").on("click",function() {
        var id = new Date().getTime(),
            name = $("input#name").val(),
            link = $("input#link").val(),
            target = $("select#target").find(":selected").val();
        if (name == "" || target =="") {
            alert("請輸入名稱!");
            return false;
        }
        if (target == "_self") {
            var t_select = ["selected",""];
        } else {
            var t_select = ["","selected"];
        }
        var tpl =
            '<li class="dd-item" data-id="'+id+'" data-name="'+filterChar(name)+'" data-link="'+filterChar(link)+'" data-target="'+filterChar(target)+'">'+
            '   <span class="edit icon-arrow-down8"></span>'+
            '   <div class="dd-handle">'+filterChar(name)+'</div>'+
            '   <div class="dd-edit">'+
            '       <div class="item">'+
            '           <label>名稱：</label>'+
            '           <input type="text" class="name regular-text-3" value="'+filterChar(name)+'">'+
            '       </div>'+
            '       <div class="item">'+
            '           <label>網址：</label>'+
            '           <input type="text" class="link regular-text-3" value="'+filterChar(link)+'">'+
            '       </div>'+
            '       <div class="item">'+
            '           <label>目標：</label>'+
            '           <select class="target regular-select-1">'+
            '               <option value="_self" '+t_select[0]+'>原視窗</option>'+
            '               <option value="_blank" '+t_select[1]+'>開新視窗</option>'+
            '           </select>'+
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
    $("div.dd-nav").on("change", "input.link", function(){
        var link = $(this).val();
        $(this).closest("li.dd-item").data("link", filterChar(link)).attr("data-link", filterChar(link));
    });
    $("div.dd-nav").on("change", "select.target", function(){
        var target = $(this).val();
        if (filterChar(target) == "") {
            alert("請選擇目標!");
            return false;
        } else {
           $(this).closest("li.dd-item").data("target", filterChar(target)).attr("data-target", filterChar(target));
        }
    });
});
</script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/nav/aSave', 'id="nav" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">選單名稱</span></th>
            <td><input type="text" name="title" id="title" class="regular-text-1"></td>
        </tr>
        <tr>
            <td class="all" colspan="2">
                <div class="dd-nav clearfix">
                    <div class="dd-add">
                        <H1 class="header">新增選項</H1>
                        <div class="item">
                            <label>名稱：</label>
                            <input type="text" id="name" class="regular-text-3">
                        </div>
                        <div class="item">
                            <label>速選：</label>
                            <select id="fast" class="regular-select-2">
                                <option value="0" selected>請選擇</option>
                                <option value="/">首頁</option>
                                <option value="/w-admin">後台首頁</option>
                            </select>
                        </div>
                        <div class="item">
                            <label>網址：</label>
                            <input type="text" id="link" class="regular-text-3">
                        </div>
                        <div class="item">
                            <label>目標：</label>
                            <select id="target" class="regular-select-2">
                                <option value="_self" selected>原視窗</option>
                                <option value="_blank">開新視窗</option>
                            </select>
                        </div>
                        <div class="item">
                            <input type="button" id="add-item" class="button" value="加入">
                            <input type="button" id="btn" value="value">
                        </div>
                    </div>
                    <div class="dd" id="nestable">
                        <H1 class="header">選單結構</H1>
                        <span class="note">從左邊的欄位新增選單項目，拖曳各個項目至你想要的順序，點擊右邊的箭頭可進行更多的設定。</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th><span class="red">主選單</span></th>
            <td>
                <span class="inline"><input type="radio" name="pNav" value="0" id="pNav-0" class="group"> <label for="pNav-0">是</label></span>
                <span class="inline"><input type="radio" name="pNav" value="1" id="pNav-1" class="group"> <label for="pNav-1">否</label></span>
            </td>
        </tr>
        <tr>
            <th><span class="red">狀態</span></th>
            <td>
                <span class="inline"><input type="radio" name="status" value="0" id="status-0" class="group"> <label for="status-0">開啟</label></span>
                <span class="inline"><input type="radio" name="status" value="1" id="status-1" class="group"> <label for="status-1">關閉</label></span>
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="button" id="goButton" class="button" data-page='nav' value="新增資料">
    </p>
</form>
