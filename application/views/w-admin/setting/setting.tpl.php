<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.setting.js"></script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/setting/eSave', 'id="setting" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">網站標題</span></th>
            <td><input type="text" name="title" class="regular-text-1" value="<?php echo $result->title;?>"></td>
        </tr>
        <tr>
            <th>網站關鍵字</th>
            <td><input type="text" name="keywords" class="regular-text-1" value="<?php echo $result->keywords;?>"></td>
        </tr>
        <tr>
            <th>網站描述</th>
            <td><input type="text" name="description" class="regular-text-1" value="<?php echo $result->description;?>"></td>
        </tr>
        <tr>
            <th><span class="red">聯絡Email</span></th>
            <td><input type="text" name="email" class="regular-text-1" value="<?php echo $result->email;?>"></td>
        </tr>
        <tr>
            <th>地址</th>
            <td><input type="text" name="address" class="regular-text-1" value="<?php echo $result->address;?>"></td>
        </tr>
        <tr>
            <th>電話</th>
            <td><input type="text" name="phone" maxlength="30" class="regular-text-1" value="<?php echo $result->phone;?>"></td>
        </tr>
        <tr>
            <th>傳真</th>
            <td><input type="text" name="fax" maxlength="30" class="regular-text-1" value="<?php echo $result->fax;?>"></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='setting' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id;?>">
</form>