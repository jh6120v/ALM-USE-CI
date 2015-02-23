<script src="/js/w-admin/jquery.form.js"></script>
<script src="/js/w-admin/jquery.validate.js"></script>
<script src="/js/w-admin/jquery.remark.js"></script>
<script src="/ckeditor/ckeditor.js"></script>
<H1><?php echo $title;?></H1>
<div class="ajax-response"></div>
<?php echo form_open('w-admin/remark/eSave', 'id="remark" name="form" autocomplete="off"');?>
    <table class="form-table">
        <tr>
            <td class="all"><textarea name="content" id="ckeditor" style="width:100%;"><?php echo htmlspecialchars($result->body);?></textarea></td>
        </tr>
    </table>
    <p class="submit">
        <input type="button" id="goButton" class="button" data-page='remark' value="更新資料">
    </p>
    <input type="hidden" name="id" value="<?php echo $result->id;?>">
</form>