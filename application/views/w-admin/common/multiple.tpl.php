<div class="batch-act">
    <select class="actionChange">
        <option value="">批次管理</option>
        <?php if ($this->common->checkLimits($tag . '-del') == TRUE): ?>
            <option value="mDelete">刪除</option>
        <?php endif;?>
        <?php if ($this->common->checkLimits($tag . '-edit') == TRUE && !isset($mStatus)): ?>
            <option value="mOpen">開啟</option>
            <option value="mClose">關閉</option>
        <?php endif;?>
    </select>
</div>