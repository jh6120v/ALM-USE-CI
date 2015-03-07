<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.layout.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<script>
	var editor;
	CKEDITOR.on( 'instanceReady', function( ev ) {
		editor = ev.editor;
		<?php if ($result->position == 0):echo 'editor.setReadOnly();';endif;?>
	} );
</script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/layout/eSave', 'id="layout" name="form" autocomplete="off"');?>
    <table class="form-table">
    	<tr>
            <th>版面名稱</th>
            <td><?php echo $result->title;?></td>
        </tr>
        <tr>
            <th><span class="red">Title</span></th>
            <td><input type="text" name="seoTitle" value="<?php echo $result->seoTitle;?>" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">Keywords</span></th>
            <td><input type="text" name="seoKey" value="<?php echo $result->seoKey;?>" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">Description</span></th>
            <td><input type="text" name="seoDesc" value="<?php echo $result->seoDesc;?>" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">側欄位置</span></th>
            <td>
            	<select name="position" class="position regular-select-1">
            		<option value="">請選擇</option>
            		<option value="0" <?php if ($result->position == 0):echo 'selected';endif;?>>無側欄</option>
            		<option value="1" <?php if ($result->position == 1):echo 'selected';endif;?>>左側</option>
            		<option value="2" <?php if ($result->position == 2):echo 'selected';endif;?>>右側</option>
            	</select>
            </td>
        </tr>
        <tr>
            <th>選單</th>
            <td>
            	<select name="nav" class="nav regular-select-1" <?php if ($result->position == 0):echo 'disabled';endif;?>>
            		<option value="0" <?php if ($result->nav == 0):echo 'selected';endif;?>>無選單</option>
            		<?php foreach ($nav as $k => $v): ?>
            			<?php $select = ($v->id == $result->nav) ? 'selected' : '';?>
            			<option value="<?php echo $v->id;?>" <?php echo $select;?>><?php echo $v->title;?></option>
            		<?php endforeach;?>
            	</select>
            </td>
        </tr>
        <tr>
        	<th>側欄自訂內容</th>
            <td><textarea name="content" id="ckeditor" style="width:100%;"><?php echo htmlspecialchars($result->content);?></textarea></td>
        </tr>
    </table>
    <p class="submit">
        <input type="button" id="goButton" class="button" data-page='layout' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id;?>">
</form>