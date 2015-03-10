<script src="/js/w-admin/jquery.pjax.js"></script>
<script src="/js/w-admin/jquery.timeago.js"></script>
<script>
$(function() {
	$("span.past").timeago();
} );
</script>
<?php if ($sort->sort == 'sort' && $this->common->checkLimits($tag . '-edit') == TRUE && $this->uri->segment(3) != 'search'): ?>
    <?php require VIEWPATH . 'w-admin/common/move-sort.tpl.php';?>
<?php endif;?>
<H1>
	<?php echo $title;?>
    <?php if ($this->common->checkLimits($tag . '-add') == TRUE): ?>
        <a href="/w-admin/worksCategory/add">新增</a>
    <?php endif;?>
</H1>
<div class="ajax-response"></div>
<div class="list-nav nav-top clearfix">
    <?php require VIEWPATH . 'w-admin/common/multiple.tpl.php';?>
    <div class="other-act">
        <form method="GET" id="search-form">
            <input type="text" name="q" class="column" value="<?php echo $q;?>">
            <input type="button" id="search" class="button" value="搜尋">
        </form>
    </div>
    <?php echo $this->pagination->create_links();?>
</div>
<?php echo form_open('w-admin/worksCategory', 'id="worksCategory-list" class="form" name="form" data-page="worksCategory" autocomplete="off"');?>
	<table class="list-table">
    	<thead>
        	<tr>
            	<th scope="col" class="column-cb"><input type="checkbox" class="selectAll"></th>
                <th scope="col" class="column-title">分類名稱</th>
                <th scope="col" class="column-date">時間</th>
            </tr>
        </thead>
        <tbody id="list">
            <?php if ($result != FALSE): ?>
                <?php foreach ($result as $k => $v): ?>
                    <tr id="worksCategory-<?php echo $v->catID;?>">
                        <td class="column-cb">
                            <?php if ($v->locked == 1): ?>
                                <input type="checkbox" name="id[]" class="checkboxID" value="<?php echo $v->catID;?>">
                            <?php endif;?>
                        </td>
                        <td class="column-title">
                            <H1>
                                <a <?php if ($this->common->checkLimits($tag . '-edit') == TRUE): ?>href="/w-admin/worksCategory/edit/<?php echo $v->catID;?><?php echo ($this->uri->segment(3) != 'search') ? '/' . $this->uri->segment(3, 1) : '';?>"<?php endif;?>><?php echo $v->catName;?></a>
                            </H1>
                            <div class="action">
                                <?php if ($this->common->checkLimits($tag . '-edit') == TRUE): ?>
                                    <a class="green" href="/w-admin/worksCategory/edit/<?php echo $v->catID;?><?php echo ($this->uri->segment(3) != 'search') ? '/' . $this->uri->segment(3, 1) : '';?>">編輯</a>
                                    <?php if ($v->status == 0): ?>
                                        | <span id="status-<?php echo $v->catID;?>" class="green"><a onClick='changeStatus(<?php echo $v->catID;?>,"close")'>已開啟</a></span>
                                    <?php else: ?>
                                        | <span id="status-<?php echo $v->catID;?>" class="red"><a onClick='changeStatus(<?php echo $v->catID;?>,"open")'>已關閉</a></span>
                                    <?php endif;?>
                                <?php endif;?>
                                <?php if ($this->common->checkLimits($tag . '-del') == TRUE): ?>
                                    <?php if ($v->locked == 1): ?>
                                        | <span class="red"><a class="del" onClick="del(<?php echo $v->catID;?>)">刪除</a></span>
                                    <?php endif;?>
                                <?php endif;?>
                            </div>
                        </td>
                        <td class="column-date"><span class="past" title="<?php echo $v->updateTime;?>"></span><br>已修改</td>
                    </tr>
                <?php endforeach;?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="column-nodata">目前沒有資料</td>
                </tr>
            <?php endif;?>
        </tbody>
        <tfoot>
        	<tr>
            	<th scope="col" class="column-cb"><input type="checkbox" class="selectAll"></th>
                <th scope="col" class="column-title">分類名稱</th>
                <th scope="col" class="column-date">時間</th>
            </tr>
        </tfoot>
    </table>
</form>
<div class="list-nav nav-bottom clearfix">
    <?php echo $this->pagination->create_links();?>
    <?php require VIEWPATH . 'w-admin/common/multiple.tpl.php';?>
</div>
