<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.page.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<H1><?php echo $title?></H1>
<em>紅色文字之欄位為必填。</em>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/page/eSave', 'id="page" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <th><span class="red">頁面名稱</span></th>
            <td><input type="text" name="title" class="regular-text-1" value="<?php echo $result->title;?>"></td>
        </tr>
        <tr>
            <th><span class="red">標籤</span></th>
            <td><input type="text" name="tag" class="regular-text-1" value="<?php echo $result->tag;?>"></td>
        </tr>
        <tr>
            <th>Title</th>
            <td><input type="text" name="pTitle" class="regular-text-1" value="<?php echo $result->seoTitle;?>"></td>
        </tr>
        <tr>
            <th>Keyword</th>
            <td><input type="text" name="pKey" class="regular-text-1" value="<?php echo $result->seoKey;?>"></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><input type="text" name="pDesc" class="regular-text-1" value="<?php echo $result->seoDesc;?>"></td>
        </tr>
        <tr>
            <th><span class="red">狀態</span></th>
            <td>
                <span class="inline"><input type="radio" name="status" id="status-0" class="group" value="0" <?php if ($result->status == 0):echo 'checked';endif;?>> <label for="status-0">開啟</label></span>
                <span class="inline"><input type="radio" name="status" id="status-1" class="group" value="1" <?php if ($result->status == 1):echo 'checked';endif;?>> <label for="status-1">關閉</label></span>
            </td>
        </tr>
       <?php if ($this->session->userdata('acl') == 'administration'): ?>
            <tr>
                <th><span class="red">鎖定</span></th>
                <td>
                    <span class="inline"><input type="radio" name="locked" id="locked-0" class="group" value="0" <?php if ($result->locked == 0):echo 'checked';endif;?>> <label for="locked-0">開啟</label></span>
                    <span class="inline"><input type="radio" name="locked" id="locked-1" class="group" value="1" <?php if ($result->locked == 1):echo 'checked';endif;?>> <label for="locked-1">關閉</label></span>
                </td>
            </tr>
        <?php endif;?>
        <tr>
            <th>內文</th>
            <td><textarea name="body" class="ckeditor"><?php echo htmlspecialchars($result->body);?></textarea></td>
        </tr>
        <?php if ($this->common->checkLimits('layout-edit') == TRUE): ?>
            <tr>
                <th><span class="red">側欄位置</span></th>
                <td>
                    <select name="position" class="position regular-select-1">
                        <option value="">請選擇</option>
                        <option value="0" <?php if ($result->position == 0):echo 'selected';endif;?>>共用設定</option>
                        <option value="1" <?php if ($result->position == 1):echo 'selected';endif;?>>無側欄</option>
                        <option value="2" <?php if ($result->position == 2):echo 'selected';endif;?>>左側</option>
                        <option value="3" <?php if ($result->position == 3):echo 'selected';endif;?>>右側</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>選單</th>
                <td>
                    <select name="nav" class="nav regular-select-1" <?php if ($result->position == 0 || $result->position == 1):echo 'disabled';endif;?>>
                        <option value="0" <?php if ($result->nav == 0):echo 'selected';endif;?>>無選單</option>
                        <?php foreach ($nav as $k => $v): ?>
                            <?php $select = ($v->id == $result->nav) ? 'selected' : '';?>
                            <option value="<?php echo $v->id;?>" <?php echo $select;?>><?php echo $v->title;?></option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>側欄自訂內容</th>
                <td><textarea name="content" id="ckeditor" <?php if ($result->position == 0 || $result->position == 1):echo 'disabled';endif;?>><?php echo htmlspecialchars($result->content);?></textarea></td>
            </tr>
        <?php endif;?>
    </table>
    <p class="submit">
        <input type="submit" id="goButton" class="button" data-page='page' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id;?>">
    <input type="hidden" name="page" value="<?php echo $page;?>">
</form>