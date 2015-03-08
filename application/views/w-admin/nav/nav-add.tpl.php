<link rel="stylesheet" href="/css/w-admin/nestable.css">
<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.nestable.js"></script>
<script src="/js/w-admin/jquery.nav.js"></script>
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
                <?php echo $pNav;?>
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='nav' value="新增資料">
    </p>
</form>
