<script type="text/javascript">
$(function(){
	$("ul.w-submenu > li").each(function() {
        if($(this).data("page")=="<?php echo $subOpen;?>") {
			$(this).children("a").css("color","#FFF");
		}
    } );
} );
</script>
<div id="w-menu-back"></div>
<div id="w-menu-wrap">
    <ul class="w-menu">
        <?php foreach ($menu as $key => $val): ?>
            <?php if ($this->session->userdata('acl') == 'administration' || in_array($val['tag'], $this->session->userdata('acl'))): ?>
                <li class="<?php echo ($val["tag"] == $open) ? 'has-select' : 'none-select';?>">
                    <a class="w-menu-title"><span class="icon <?php echo $val["icon"];?>"></span> <span class="text"><?php echo $key;?></span></a>
                    <ul class="w-submenu">
                        <li class="w-submenu-title"><?php echo $key;?></li>
                        <?php foreach ($val['subMenu'] as $key2 => $val2): ?>
                            <?php if ($this->session->userdata('acl') == 'administration' || in_array($val2['tag'], $this->session->userdata('acl'))): ?>
                                <li data-page="<?php echo $val2["tag"];?>"><a href="<?php echo $val2["url"];?>"><?php echo $key2;?></a></li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </li>
            <?php endif;?>
        <?php endforeach;?>
    </ul>

</div>