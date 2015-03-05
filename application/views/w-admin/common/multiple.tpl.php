<div class="batch-act">
    <select class="actionChange">
        <option value="">批次管理</option>
        <?php if ($this->session->userdata('acl') == 'administration' || in_array($tag . '-del', $this->session->userdata('acl'))): ?>
            <option value="mDelete">刪除</option>
        <?php endif;?>
        <?php if (($this->session->userdata('acl') == 'administration' || in_array($tag . '-edit', $this->session->userdata('acl'))) && !isset($mStatus)): ?>
            <option value="mOpen">開啟</option>
            <option value="mClose">關閉</option>
        <?php endif;?>
    </select>
</div>