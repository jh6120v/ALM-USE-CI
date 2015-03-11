<li class="dd-item" data-id="<?php echo $id;?>" data-name="<?php echo $name;?>">
	<span class="edit icon-arrow-down8"></span>
	<div class="dd-handle"><?php echo $name;?></div>
	<div class="dd-edit">
    	<div class="item">
            <label>項目：</label>
            <input type="text" class="name regular-text-3" value="<?php echo $name;?>">
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
