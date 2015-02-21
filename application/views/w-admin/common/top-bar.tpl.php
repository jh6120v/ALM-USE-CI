<div id="w-header-menu">
    <ul id="top-bar" class="top-bar-left">
        <li id="menu-toggle"><a><span class="icon-menu2"></span></a></li>
        <li><a href="/w-admin/home"><span class="icon-world"></span></a></li>
        <li><a href="/" target="_blank"><span class="icon-home"></span> <span class="text"><?php echo $this->config->item("webName");?></span></a></li>
        <li id="fast-add">
            <a id="open-fast-add-menu" class="slide-menu"><span class="icon-plus"></span> <span class="text">快速新增</span></a>
            <ul class="fast-add-menu clearfix">
                <li><a href="banner.php?act=add">橫幅廣告</a></li>
                <li><a href="works.php?act=add">設計作品</a></li>
            </ul>
        </li>
    </ul>
    <ul id="top-bar" class="top-bar-right">
        <li id="userInfo">
            <a id="open-userInfo-menu" class="slide-menu"><span class="text">您好，<?php echo $this->session->userdata('pName');?></span> <span class="icon-user3"></span></a>
            <ul class="userInfo-menu clearfix">
                <li><a href="account.php?act=personal"><?php echo $this->session->userdata('pName');?></a></li>
                <li><a href="account.php?act=personal">編輯個人資訊</a></li>
                <li><a href="/w-admin/logout">登出</a></li>
            </ul>
        </li>
    </ul>
</div>
