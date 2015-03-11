<link rel="stylesheet" href="/css/w-admin/nestable.css">
<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.nestable.js"></script>
<script src="/js/w-admin/jquery.category.js"></script>
<H1><?php echo $title;?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/category/eSave', 'id="category" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">分類類別名稱</span></th>
            <td><?php echo $result->title;?></td>
        </tr>
        <tr>
            <td class="all" colspan="2">
                <div class="dd-nav clearfix">
                    <div class="dd-add">
                        <H1 class="header">新增選項</H1>
                        <div class="item">
                            <label>項目：</label>
                            <input type="text" id="name" class="regular-text-3">
                        </div>
                        <div class="item">
                            <input type="button" id="add-item" class="button" value="加入">
                        </div>
                    </div>
                    <div class="dd" id="nestable">
                        <H1 class="header">分類結構</H1>
                        <span class="note">從左邊的欄位新增分類項目，拖曳各個項目至你想要的順序，點擊右邊的箭頭可進行更多的設定。</span>
                        <?php if ($category != ''): ?>
                            <ol class="dd-list">
                                <?php echo $category;?>
                            </ol>
                        <?php endif;?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='category' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id?>">
    <input type="hidden" name="page" value="<?php echo $page;?>">
</form>