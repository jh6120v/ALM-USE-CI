<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.pstrength.js"></script>
<script src="/js/w-admin/jquery.account.js"></script>
<link rel="stylesheet" href="/css/w-admin/pstrength.css">
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/account/eSave', 'id="account" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th>使用者名稱</th>
            <td id="username"><?php echo $result->username;?></td>
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
        <tr>
            <th><span class="red">群組</span></th>
            <td>
                <?php if ($groups != FALSE): ?>
                    <?php foreach ($groups as $k => $v): ?>
                        <span class="inline"><input type="radio" name="groups" id="groups-<?php echo $k;?>" class="group" value="<?php echo $v->id;?>" <?php if ($result->groups == $v->id):echo 'checked';endif;?>> <label for="groups-<?php echo $k;?>"><?php echo $v->title;?></label></span>
                    <?php endforeach;?>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <th><span class="red">狀態</span></th>
            <td>
                <span class="inline"><input type="radio" name="status" id="status-0" class="group" value="0" <?php if ($result->status == 0):echo 'checked';endif;?>> <label for="status-0">開啟</label></span>
                <span class="inline"><input type="radio" name="status" id="status-1" class="group" value="1" <?php if ($result->status == 1):echo 'checked';endif;?>> <label for="status-1">停權</label></span>
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
        <input type="button" id="goButton" class="button" data-page='account' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id?>">
    <input type="hidden" name="page" value="<?php echo $page;?>">
</form>