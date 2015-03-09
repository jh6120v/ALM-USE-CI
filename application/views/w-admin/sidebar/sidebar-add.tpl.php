<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.sidebar.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/sidebar/aSave', 'id="sidebar" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">側欄名稱</span></th>
            <td><input type="text" name="title" id="title" class="regular-text-1"></td>
        </tr>
        <?php if ($this->session->userdata('acl') == 'administration'): ?>
            <tr>
                <th><span class="red">鎖定</span></th>
                <td>
                    <span class="inline"><input type="radio" name="locked" id="locked-0" class="group" value="0"> <label for="locked-0">開啟</label></span>
                    <span class="inline"><input type="radio" name="locked" id="locked-1" class="group" value="1"> <label for="locked-1">關閉</label></span>
                </td>
            </tr>
        <?php endif;?>
        <tr>
            <th><span class="red">側欄位置</span></th>
            <td>
                <select name="position" class="position regular-select-1">
                    <option value="">請選擇</option>
                    <option value="1">左側</option>
                    <option value="2">右側</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><span class="red">選單</span></th>
            <td>
                <select name="nav" class="nav regular-select-1">
                    <option value="">請選擇</option>
                    <option value="0">No Menu</option>
                    <?php foreach ($nav as $k => $v): ?>
                        <option value="<?php echo $v->id;?>"><?php echo $v->title;?></option>
                    <?php endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <th>側欄自訂內容</th>
            <td><textarea name="content" id="ckeditor"></textarea></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='sidebar' value="新增資料">
    </p>
</form>
