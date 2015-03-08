<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.sort.js"></script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/sort/eSave', 'id="sort" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th>項目名稱</th>
            <td><?php echo $result->title;?></td>
        </tr>
        <tr>
            <th><span class="red">主要依據</span></th>
            <td><?php echo form_dropdown('sort', $sortArray, $result->sort, 'class="regular-select-1"');?></td>
        </tr>
        <tr>
            <th><span class="red">主要方式</span></th>
            <td><?php echo form_dropdown('orderBy', $orderByArray, $result->orderBy, 'class="regular-select-1"');?></td>
        </tr>
        <tr>
            <th><span class="red">次要依據</span></th>
            <td><?php echo form_dropdown('sort2', $sortArray, $result->sort2, 'class="regular-select-1"');?></td>
        </tr>
        <tr>
            <th><span class="red">次要方式</span></th>
            <td><?php echo form_dropdown('orderBy2', $orderByArray, $result->orderBy2, 'class="regular-select-1"');?></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='sort' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id;?>">
</form>