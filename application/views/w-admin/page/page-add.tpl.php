<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.page.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<H1><?php echo $title?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/page/aSave', 'id="page" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">頁面名稱</span></th>
            <td><input type="text" name="title" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">標籤</span></th>
            <td>
                <input type="text" name="tag" class="regular-text-1"><br>
                頁面固定網址：http://<?php echo $this->config->item("webDomain");?>/page/<span class="tag">標籤</span>
            </td>
        </tr>
        <tr>
            <th>Title</th>
            <td><input type="text" name="seoTitle" class="regular-text-1"></td>
        </tr>
        <tr>
            <th>Keyword</th>
            <td><input type="text" name="seoKey" class="regular-text-1"></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><input type="text" name="seoDesc" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">狀態</span></th>
            <td>
                <span class="inline"><input type="radio" name="status" id="status-0" class="group" value="0"> <label for="status-0">開啟</label></span>
                <span class="inline"><input type="radio" name="status" id="status-1" class="group" value="1"> <label for="status-1">關閉</label></span>
            </td>
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
            <th>內文</th>
            <td><textarea name="body" class="ckeditor"></textarea></td>
        </tr>
        <tr>
            <th><span class="red">側欄設定</span></th>
            <td>
                <select name="sidebar" class="regular-select-1">
                    <option value="0" selected>無側欄</option>
                    <?php if ($sidebar != FALSE): ?>
                        <?php foreach ($sidebar as $k => $v): ?>
                            <option value="<?php echo $v->id;?>"><?php echo $v->title;?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                </select>
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='page' value="新增資料">
    </p>
</form>