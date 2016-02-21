<?php /** @var $this Picture_formView*/ ?>
<div class="row">

    <form role="form" enctype="multipart/form-data" method="post" id="picForm">
    <div class="col-lg-4">
        <h1>Bild hochladen</h1>
        <div id="upload_error" class="alert alert-danger ?>" style="display: none">
            <a href="<?php echo $this->urlScrollTo(""); ?>" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Fehler!</strong> <span id="upload_error_msg"></span>
        </div>
            <input type="file" id="uploadFile" name="uploadFile">
        <div style="display: inline-block;">
            <img style="display: none;" src="" id="uploadPreview" width="200">
            <div class="text-center" id="upload_file_name"></div>
        </div>
        <div class="form-group">
            <label for="tags">Schlagwörter, damit das Bild besser gefunden wird</label>
            <select multiple data-role="tagsinput" id="tags" name="tags[]" class="tags_typeahead"></select>
        </div>
    </div>


    <div class="col-lg-8">

        <h1>Informationen hinzufügen</h1>

            <div class="form-group">
                <label for="title">Titel</label>
                <input type="text" class="form-control" id="title" name="title"/>
            </div>
            <div class="form-group">
                <label for="category">Kategorie</label>
                <select class="form-control" name="category" id="category">
                    <option value="-1">-- Bitte wählen --</option>
                    <?php
                    foreach ($this->getCategories() as $category) {
                        echo "<option value='" . $category->getCategoryId() . "'>" . $category->getCategoryName() . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="material">Material</label>
                <input type="text" class="form-control" id="material" name="material"/>
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

