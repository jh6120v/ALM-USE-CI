<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/additional-methods.js"></script>
<script src="/js/w-admin/jquery.banner.js"></script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php require VIEWPATH . 'w-admin/common/progress.tpl.php';?>
<?php echo form_open('w-admin/banner/aSave', 'id="banner" name="form" enctype="multipart/form-data" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th>連結</th>
            <td><input type="text" name="url" class="regular-text-1"></td>
        </tr>
        <tr>
            <th>檔案</th>
            <td>
            	<span class="red">圖片要求像素：<?php echo $setWidth;?>x<?php echo $setHeight;?>px</span><br>
            	<input type="file" name="fileName" class="regular-text-1">
            </td>
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
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='banner' value="新增資料">
    </p>
</form>