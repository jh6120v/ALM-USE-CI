<li class="dd-item" data-id="<?php echo $id;?>" data-name="<?php echo $name;?>" data-link="<?php echo $link;?>" data-target="<?php echo $target;?>">
	<span class="edit icon-arrow-down8"></span>
	<div class="dd-handle"><?php echo $name;?></div>
	<div class="dd-edit">
    	<div class="item">
            <label>名稱：</label>
            <input type="text" class="name regular-text-3" value="<?php echo $name;?>">
        </div>
        <div class="item">
            <label>網址：</label>
            <input type="text" class="link regular-text-3" value="<?php echo $link;?>">
        </div>
        <div class="item">
            <label>目標：</label>
            <select class="target regular-select-1">'+
        	    <option value="_self" <?php if ($target == '_self'):echo "selected";endif;?>>原視窗</option>
                <option value="_blank" <?php if ($target == '_blank'):echo "selected";endif;?>>開新視窗</option>
            </select>
        </div>
        <div class="item">
        	<input type="button" class="remove-item button" value="移除">
            <input type="button" class="close-item button" value="關閉">
        </div>
    </div>
    <?php if ($subMenu != ''): ?>
    	<ol class="dd-list">
    		<?php echo $subMenu;?>
    	</ol>
    <?php endif;?>
</li>
