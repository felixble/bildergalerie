<?php /** @var $this Picture_formView*/ ?>

<!-- Dialog Content -->
<div id="dialog-add_category" title="Kategorie hinzufügen" style="display: none;">
    <form role="form" method="post" data-toggle="validator">
        <div class="form-group has-feedback">
            <label for="category_name">Kategorie</label>
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


<!-- Form Content -->
<div class="row">

    <form data-toggle="validator" role="form" enctype="multipart/form-data" method="post" id="picForm">
    <div class="col-lg-4">
        <h1>Bild hochladen</h1>
        <div id="upload_error" class="alert alert-danger ?>" style="display: none">
            <a href="<?php echo $this->urlScrollTo(""); ?>" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fehler!</strong> <span id="upload_error_msg"></span>
        </div>
        <div class="form-group">
            <label for="tags">Schlagwörter, damit das Bild besser gefunden wird</label>
            <select multiple data-role="tagsinput" id="tags" name="tags[]" class="tags_typeahead"></select>
        </div>
        <div class="form-group">
            <label for="uploadFile">Upload</label>
            <input type="file" id="uploadFile" name="uploadFile">
        </div>
        <div style="display: inline-block;">
            <img style="display: none;" src="" id="uploadPreview" width="200">
            <div class="text-center" id="upload_file_name"></div>
        </div>
    </div>


    <div class="col-lg-8">

        <h1>Informationen hinzufügen</h1>

            <div class="form-group has-feedback">
                <label for="title">Titel</label>
                <input type="text" class="form-control" id="title" name="title" required/>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group">
                <label for="category">Kategorie</label>
                <div class="input-group">
                <select class="form-control" name="category" id="category">
                    <option value="-1">-- Bitte wählen --</option>
                    <?php
                    foreach ($this->getCategories() as $category) {
                        echo "<option value='" . $category->getCategoryId() . "'>" . $category->getCategoryName() . "</option>";
                    }
                    ?>
                </select>
                <span class="input-group-btn">
                    <button class="btn btn-success" type="button" id="add_category">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </span>
                </div>
            </div>
            <div class="form-group">
                <label for="material">Material/Technik</label>
                <input type="text" class="form-control" id="material" name="material" placeholder="z.B. Acryl auf Leinwand"/>
            </div>
            <div class="form-group">
                <label for="description">Beschreibung</label>
                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
            </div>
            <input type="submit" class="btn btn-success" id="add_pic_submit" name="add_pic_submit" value="Speichern" disabled>
            <input type="hidden" name="picPathId" id="picPathId">

    </div>
    </form>

</div>

