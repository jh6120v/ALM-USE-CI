<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.pstrength.js"></script>
<script src="/js/w-admin/jquery.account.js"></script>
<link rel="stylesheet" href="/css/w-admin/pstrength.css">
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/account/pSave', 'id="account" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th>使用者名稱</th>
            <td><?php echo $result->username;?></td>
        </tr>
        <tr>
            <th><span class="red">舊密碼</span></th>
            <td><input type="password" name="pass3" class="regular-text-1"></td>
        </tr>
        <tr>
            <th>新密碼</th>
            <td><input type="password" name="pass4" id="pass4" class="regular-text-1 password"></td>
        </tr>
        <tr>
            <th>確認密碼</th>
            <td><input type="password" name="pass5" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">名稱</span></th>
            <td><input type="text" name="name" class="regular-text-1" value="<?php echo $result->name;?>"></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='account' value="更新資料">
    </p>
</form>