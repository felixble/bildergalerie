<?php
/** @var $this Picture_formView*/
$pic = $this->getPicture();
$title = (null == $pic) ? "" : $pic->getTitle();
$categories = (null == $pic) ? "" : $pic->getCategories();
$material = (null == $pic) ? "" : $pic->getMaterial();
$description = (null == $pic) ? "" : $pic->getDescription();
$tags = (null == $pic) ? array() : $pic->getTags();
$picPath = (null == $pic) ? "" : $pic->getPath()->getPath();
$picFileName = (null == $pic) ? "" : $pic->getPath()->getFileName();
$picThumbPath = (null == $pic) ? "" : $pic->getPath()->getThumbPath();
$picPathId = (null == $pic) ? ":" : $pic->getPath()->getId();

?>

<!-- Dialog Content -->
<?php echo new Edit_exhibition_dialogView(); ?>


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
            <select multiple data-role="tagsinput" id="tags" name="tags[]" class="tags_typeahead">
                <?php foreach($tags as $tag): ?>
                    <option value="<?php echo $tag->getTagName(); ?>"><?php echo $tag->getTagName(); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group" style="display: <?php echo (empty($picPath)) ? "block" : "none"; ?>;">
            <label for="uploadFile">Upload</label>
            <input type="file" id="uploadFile" name="uploadFile" value="<?php echo $picPath; ?>">
            <input type="hidden" id="uploadFile_thumbPath" name="uploadFile_thumbPath" value="<?php echo $picThumbPath; ?>">
            <input type="hidden" id="uploadFile_path" name="uploadFile_path" value="<?php echo $picPath; ?>">
        </div>
        <div style="display: inline-block;">
            <img id="loading" style="margin-left: 50px; display: none" src="resources/img/ajax-loader.gif">
            <img style="display: <?php echo (!empty($picPath)) ? "block" : "none"; ?>;" src="<?php echo $picThumbPath; ?>" id="uploadPreview" width="200">
            <div class="text-center" id="upload_file_name"><?php echo $picFileName; ?></div>
        </div>
    </div>


    <div class="col-lg-8">

        <h1>Informationen hinzufügen</h1>

            <div class="form-group has-feedback">
                <label for="title">Titel</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" autofocus required/>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group has-feedback" id="form-group-exhibition" data-error="Bitte wählen Sie mindestens eine Ausstellung.">
                <label for="category">Ausstellung</label>
                <div class="input-group">
                    <select class="selectpicker form-control" name="category[]" id="category" data-none-selected-text="-- Bitte wählen --" multiple>
                        <!--<option value="-1">-- Bitte wählen --</option>-->
                        <?php
                        foreach ($this->getCategories() as $category) {
                            // TODO: mark chosen categories as selected..
                            $selected = (null != $pic && $pic->hasCategory($category)) ? "selected" : "";
                            echo "<option value='" . $category->getCategoryId() . "' $selected>" . $category->getCategoryName() . "</option>";
                        }
                        ?>
                    </select>
                    <span class="input-group-btn">
                        <button class="btn btn-success open_category_dialog" data-on-success="onSuccessPicForm"
                                type="button" title="Neue Ausstellung hinzufügen">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </span>
                </div>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group has-feedback">
                <label for="material">Material/Technik</label>
                <input type="text" class="form-control" id="material" name="material" value="<?php echo $material ?>"
                       placeholder="z.B. Acryl auf Leinwand" data-error="Bitte geben Sie das verwendete Material und die Technik an." required/>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="description">Beschreibung</label>
                <textarea class="form-control" rows="5" id="description" name="description"><?php echo $description ?></textarea>
            </div>
            <input type="submit" class="btn btn-success" id="add_pic_submit" name="add_pic_submit" value="Speichern" <?php echo ($this->isEditMode() || !empty($picFileName)) ? "" : "disabled"; ?>>
            <input type="hidden" name="picPathId" id="picPathId" value="<?php echo $picPathId; ?>">

    </div>
    </form>

</div>

