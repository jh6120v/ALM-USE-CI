<script src="/js/w-admin/jquery.pjax.js"></script>
<script src="/js/w-admin/jquery.timeago.js"></script>
<script>
$(function() {
	$("span.past").timeago();
} );
</script>
<H1><?php echo $title;?></H1>
<?php echo form_open('', 'id="account-record" class="form" name="form" autocomplete="off"');?>
	<div class="list-nav nav-top clearfix">
        <?php echo $this->pagination->create_links();?>
    </div>
	<table class="list-table">
    	<thead>
        	<tr>
            	<th scope="col" class="column-no">編號</th>
                <th scope="col" class="column-title">系統訊息</th>
                <th scope="col" class="column-name">使用者名稱</th>
                <th scope="col" class="column-name">名稱</th>
                <th scope="col" class="column-ip">登入IP</th>
                <th scope="col" class="column-date">時間</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result != FALSE): ?>
                <?php foreach ($result as $k => $v): ?>
                    <tr>
                        <td class="column-no"><?php echo $k + 1;?></td>
                        <td class="column-title"><?php echo $v->message;?></td>
                        <td class="column-name"><?php echo $v->username;?></td>
                        <td class="column-name"><?php echo $v->name;?></td>
                        <td class="column-ip"><?php echo $v->ip;?></td>
                        <td class="column-date"><span class="past" title="<?php echo $v->loginTime;?>"></span><br>登入</td>
                    </tr>
                <?php endforeach;?>
            <?php else: ?>
                <tr>
                    <td colspan="6">目前沒有資料</td>
                </tr>
            <?php endif;?>
        </tbody>
        <tfoot>
        	<tr>
            	<th scope="col" class="column-no">編號</th>
                <th scope="col" class="column-title">系統訊息</th>
                <th scope="col" class="column-name">使用者名稱</th>
                <th scope="col" class="column-name">名稱</th>
                <th scope="col" class="column-ip">登入IP</th>
                <th scope="col" class="column-date">時間</th>
            </tr>
        </tfoot>

    </table>
	<div class="list-nav nav-bottom clearfix">
    	<?php echo $this->pagination->create_links();?>
    </div>
</form>
