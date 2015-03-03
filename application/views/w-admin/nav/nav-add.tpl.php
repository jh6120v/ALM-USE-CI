<link rel="stylesheet" href="/css/w-admin/nestable.css">
<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.nav.js"></script>
<script src="/js/w-admin/jquery.nestable.js"></script>
<script>
$(function(){
    $('#nestable').nestable();
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
                            <label>速選：</label>
                            <select id="fast" class="regular-select-2">
                                <option value="/" selected>首頁</option>
                                <option value="/w-admin">後台首頁</option>
                            </select>
                        </div>
                        <div class="item">
                            <label>網址：</label>
                            <input type="text" name="url" id="url" class="regular-text-3">
                        </div>
                        <div class="item">
                            <label>目標：</label>
                            <select name="target" class="regular-select-2">
                                <option value="_self" selected>原視窗</option>
                                <option value="_blank">開新視窗</option>
                            </select>
                        </div>
                        <div class="item">
                            <input type="button" id="add-item" class="button" value="加入">
                        </div>
                    </div>
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
<?php
$string = '[{"id":12},{"id":11},{"id":13},{"id":14},{"id":15,"children":[{"id":16},{"id":17},{"id":18}]}]';
$aaa = json_decode($string);
foreach ($aaa as $k => $v) {
	echo '
    <li class="dd-item" data-id="' . $v->id . '" data-text="a' . $v->id . '">
        <span class="icon-arrow-down8"></span>
        <div class="dd-handle">Item ' . $v->id . '</div>
        <div class="dd-edit">

        </div>';
	if (isset($v->children)):
		echo '<ol class="dd-list">';
		foreach ($v->children as $k2 => $v2):
			echo '<li class="dd-item" data-id="' . $v2->id . '"><span class="icon-arrow-down8"></span><div class="dd-handle">Item ' . $v2->id . '</div></li>';
		endforeach;
		echo '</ol>';
	endif;
	echo '
    </li>';
}
?>
                        </ol>
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
