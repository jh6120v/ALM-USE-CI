<!doctype html>
<html>
<head>
<?php require 'common/meta.tpl.php';?>
<link rel="stylesheet" href="/css/w-admin/all-layout.css">
<link rel="stylesheet" href="/css/w-admin/top-bar.css">
<link rel="stylesheet" href="/css/w-admin/menu.css">
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="/js/w-admin/common.js"></script>
</head>

<body>
	<div id="loading"></div>
	<div id="w-wrap">
		<?php echo $menu;?>
		<div id="w-content">
			<?php require 'common/top-bar.tpl.php';?>
			<div id="w-body">
            	<div id="w-body-content">
                	<div class="wrap"><?php echo $content;?></div>
                </div>
			</div>
		</div>
        <div id="w-footer">
        	Copyright © <a href="/"><?php echo $this->config->item("webName");?></a>
            <span class="gotop"><a><span class="icon-arrow-up9"></span> TOP</a></span>
        </div>
	</div>
</body>
</html>