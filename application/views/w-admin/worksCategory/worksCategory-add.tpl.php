<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.worksCategory.js"></script>
<H1><?php echo $title?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/worksCategory/aSave', 'id="worksCategory" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">分類名稱</span></th>
            <td><input type="text" name="catName" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">排序</span></th>
            <td><input type="text" name="sort" class="regular-text-2" value="0"></td>
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
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='worksCategory' value="新增資料">
    </p>
</form>