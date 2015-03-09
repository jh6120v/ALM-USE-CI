<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.sidebar.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/sidebar/eSave', 'id="sidebar" name="form" autocomplete="off"');?>
    <table class="form-table">
    	<tr>
            <th>側欄名稱</th>
            <td><input type="text" name="title" id="title" class="regular-text-1" value="<?php echo $result->title;?>"></td>
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
        <tr>
            <th><span class="red">側欄位置</span></th>
            <td>
            	<select name="position" class="position regular-select-1">
            		<option value="">請選擇</option>
            		<option value="1" <?php if ($result->position == 1):echo 'selected';endif;?>>左側</option>
            		<option value="2" <?php if ($result->position == 2):echo 'selected';endif;?>>右側</option>
            	</select>
            </td>
        </tr>
        <tr>
            <th><span class="red">選單</span></th>
            <td>
            	<select name="nav" class="nav regular-select-1">
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
            <td><textarea name="content" id="ckeditor"><?php echo htmlspecialchars($result->content);?></textarea></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='sidebar' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id;?>">
</form>