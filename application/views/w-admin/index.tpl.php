<!doctype html>
<html>
<head>
<?php require 'common/meta.tpl.php';?>
<link rel="stylesheet" href="/css/w-admin/default.css">
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.login.js"></script>
</head>
<body>
<div id="login-box">
	<H1 class="logo"><img src="/images/w-admin/logo.png"></H1>
    <div class="ajax-response"></div>
        <?php echo form_open('w-admin/login', 'id="login" name="form" autocomplete="off"');?>
    	<p>
            帳號<br>
            <input type="text" name="username" class="column regular-text-1" value="<?php echo $remUser;?>">
        </p>
        <p>
            密碼<br>
            <input type="password" name="password" class="column regular-text-1" value="<?php echo $remPass;?>" style="width:100%;">
        </p>
        <p>
        	驗證碼<br>
            <input type="text" name="captcha" class="column regular-text-2" maxlength="4"> <img src="/captcha" id="captcha" title="點擊更換驗證碼!">
        </p>
        <p>
        	<label for="rememberme"><input type="checkbox" name="rememberme" id="rememberme" value="true" checked> 記住登入資訊</label>
        </p>
        <p class="botton">
        	<input type="submit" id="goButton" class="button" data-page='login' value="登入">
        </p>
    </form>
	<p class="copyright">Copyright © <a href="/"><?php echo $this->config->item("webName");?></a></p>
</div>
</body>
</html>