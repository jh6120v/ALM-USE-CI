<script src="/js/w-admin/jquery.timeago.js"></script>
<script>
$(function(){
	$("span.past").timeago();
});
</script>
<H1><?php echo $title;?></H1>
<?php echo form_open('', 'id="layout-list" name="form" autocomplete="off"')?>
	<table class="list-table">
    	<thead>
        	<tr>
            	<th scope="col" class="column-no">編號</th>
                <th scope="col" class="column-title">版面名稱</th>
                <th scope="col" class="column-ip">IP紀錄</th>
                <th scope="col" class="column-date">時間</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result != FALSE): ?>
                <?php foreach ($result as $k => $v): ?>
                    <tr>
                        <td class="column-no"><?php echo $k + 1;?></td>
                        <td class="column-title">
                            <H1>
                                <a <?php if ($this->session->userdata('acl') == 'administration' || in_array($tag . '-edit', $this->session->userdata('acl'))):echo 'href="/w-admin/layout/edit/' . $v->id . '"';endif;?>><?php echo $v->title;?></a>
                            </H1>
                            <div class="action">
                                <?php if ($this->session->userdata('acl') == 'administration' || in_array($tag . '-edit', $this->session->userdata('acl'))): ?>
                                    <a class="green" href="/w-admin/layout/edit/<?php echo $v->id;?>">編輯</a>
                                <?php endif;?>
                            </div>
                        </td>
                        <td class="column-ip"><?php echo $v->ip;?></td>
                        <td class="column-date"><span class="past" title="<?php echo $v->updateTime;?>"></span><br>已修改</td>
                    </tr>
                <?php endforeach;?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="column-nodata">目前沒有資料</td>
                </tr>
            <?php endif;?>
        </tbody>
        <tfoot>
        	<tr>
            	<th scope="col" class="column-no">編號</th>
                <th scope="col" class="column-title">版面名稱</th>
                <th scope="col" class="column-ip">IP紀錄</th>
                <th scope="col" class="column-date">時間</th>
            </tr>
        </tfoot>

    </table>
</form>