<?php /** @var $this Edit_exhibition_dialogView */ ?>
<div id="dialog-add_category" data-edit="<?php echo ($this->isEditMode()) ? "true" : "false"; ?>" style="display: none;">
    <form role="form" method="post" data-toggle="validator">
        <div class="form-group has-feedback">
            <label for="category_name">Titel/Thema</label>
            <input type="text" class="form-control" id="category_name" name="category_name"
                   data-error="Füllen Sie dieses Feld aus!" required />
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="help-block with-errors"></div>
        </div>
        <div class="form-group">
            <label for="category_description">Beschreibung</label>
            <textarea class="form-control" rows="5" id="category_description" name="description"></textarea>
        </div>
    </form>
</div>
