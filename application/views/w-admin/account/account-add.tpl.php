<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.pstrength.js"></script>
<script src="/js/w-admin/jquery.account.js"></script>
<link rel="stylesheet" href="/css/w-admin/pstrength.css">
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/account/aSave', 'id="account" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">使用者名稱</span></th>
            <td><input type="text" name="username" id="username" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">密碼</span></th>
            <td><input type="password" name="pass1" id="pass1" class="regular-text-1 password"></td>
        </tr>
        <tr>
            <th><span class="red">確認密碼</span></th>
            <td><input type="password" name="pass2" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">名稱</span></th>
            <td><input type="text" name="name" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">群組</span></th>
            <td>
                <?php if ($groups != FALSE): ?>
                    <?php foreach ($groups as $k => $v): ?>
                        <span class="inline"><input type="radio" name="groups" id="groups-<?php echo $k;?>" class="group" value="<?php echo $v->id;?>"> <label for="groups-<?php echo $k;?>"><?php echo $v->title;?></label></span>
                    <?php endforeach;?>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <th><span class="red">狀態</span></th>
            <td>
                <span class="inline"><input type="radio" name="status" id="status-0" class="group" value="0"> <label for="status-0">開啟</label></span>
                <span class="inline"><input type="radio" name="status" id="status-1" class="group" value="1"> <label for="status-1">停權</label></span>
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
        <input type="submit" id="goButton" class="button" data-page='account' value="新增資料">
    </p>
</form>