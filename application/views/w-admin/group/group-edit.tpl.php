<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.group.js"></script>
<style>
em.group {
	min-height:32px;
	display:block;
	position:relative;
	padding-left:150px;
}
em.group > span.first {
	position:absolute;
	left:25px;
	top:0;
}
</style>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/group/eSave', 'id="group" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">群組名稱</span></th>
            <td><input type="text" name="title" id="title" value="<?php echo $result->title;?>" class="regular-text-1"></td>
        </tr>
        <tr>
            <th><span class="red">權限</span></th>
            <td>
                <?php foreach ($aclList as $k => $v): ?>
                    <H1><span class="inline"><input type="checkbox" name="acl[]" value="<?php echo $v['acl'];?>" id="<?php echo $v['acl'];?>" level="0" onclick="javascript:checknode(this);" <?php if (in_array($v['acl'], $acl)):echo 'checked';endif;?>> <label for="<?php echo $v['acl'];?>"><?php echo $k;?></label></span></H1>
                    <?php foreach ($v['action'] as $k2 => $v2): ?>
                        <em class="group"><span class="inline first"><input type="checkbox" name="acl[]" value="<?php echo $v2['acl'];?>" id="<?php echo $v2['acl'];?>" level="1" onclick="javascript:checknode(this);" <?php if (in_array($v2['acl'], $acl)):echo 'checked';endif;?>> <label for="<?php echo $v2['acl'];?>"><?php echo $v2['name'];?></label></span>
                        <?php foreach ($v2['list_acl'] as $k3 => $v3): ?>
                            <span class="inline"><input type="checkbox" name="acl[]" value="<?php echo $v3;?>" id="<?php echo $v3;?>" level="2" onclick="javascript:checknode(this);" <?php if (in_array($v3, $acl)):echo 'checked';endif;?>> <label for="<?php echo $v3;?>"><?php echo $k3;?></label></span>
                        <?php endforeach;?>
                        </em>
                    <?php endforeach;?>
                <?php endforeach;?>
            </td>
        </tr>
        <tr>
            <th><span class="red">狀態</span></th>
            <td>
                <span class="inline"><input type="radio" name="status" value="0" id="status-0" class="group" <?php if ($result->status == 0):echo 'checked';endif;?>> <label for="status-0">開啟</label></span>
                <span class="inline"><input type="radio" name="status" value="1" id="status-1" class="group" <?php if ($result->status == 1):echo 'checked';endif;?>> <label for="status-1">關閉</label></span>
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="button" id="goButton" class="button" data-page='group' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id?>">
    <input type="hidden" name="page" value="<?php echo $page;?>">
</form>