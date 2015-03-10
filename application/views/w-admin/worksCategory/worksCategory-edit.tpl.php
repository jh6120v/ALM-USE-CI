<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.worksCategory.js"></script>
<H1><?php echo $title?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/worksCategory/eSave', 'id="worksCategory" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">分類名稱</span></th>
            <td><input type="text" name="catName" class="regular-text-1" value="<?php echo $result->catName;?>"></td>
        </tr>
        <tr>
            <th><span class="red">排序</span></th>
            <td><input type="text" name="sort" class="regular-text-2" value="<?php echo $result->sort;?>"></td>
        </tr>
        <tr>
            <th><span class="red">狀態</span></th>
            <td>
                <span class="inline"><input type="radio" name="status" id="status-0" class="group" value="0" <?php if ($result->status == 0):echo 'checked';endif;?>> <label for="status-0">開啟</label></span>
                <span class="inline"><input type="radio" name="status" id="status-1" class="group" value="1" <?php if ($result->status == 1):echo 'checked';endif;?>> <label for="status-1">關閉</label></span>
            </td>
        </tr>
        <?php if ($this->session->userdata('acl') == 'administration'): ?>
            <tr>
                <th><span class="red">鎖定</span></th>
                <td>
                    <span class="inline"><input type="radio" name="locked" id="locked-0" class="group" value="0" <?php if ($result->locked == 0):echo 'checked';endif;?>> <label for="locked-0">開啟</label></span>
                    <span class="inline"><input type="radio" name="locked" id="locked-1" class="group" value="1" <?php if ($result->locked == 1):echo 'checked';endif;?>> <label for="locked-1">關閉</label></span>
                </td>
            </tr>
        <?php endif;?>
    </table>
    <p class="submit">
        <input type="button" id="goButton" class="button" data-page='worksCategory' value="更新資料">
    </p>
    <input type="hidden" name="catID" value="<?php echo $result->catID;?>">
    <input type="hidden" name="page" value="<?php echo $page;?>">
</form>