<?php /** @var $this Picture_formView*/ ?>
<div class="row">

    <div class="col-lg-4">
        <h1>Bild hochladen</h1>
        <form enctype="multipart/form-data">
            <input type="file" id="uploadFile" name="uploadFile">
        </form>
        <img style="display: none;" src="" id="uploadPreview" width="200">
    </div>


    <div class="col-lg-8">

        <h1>Informationen hinzufügen</h1>

        <form role="form" method="post">
            <div class="form-group">
                <label for="title">Titel</label>
                <input type="text" class="form-control" id="title" name="title"/>
            </div>
            <div class="form-group">
                <label for="category">Kategorie:</label>
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
                <label for="material">Material:</label>
                <input type="text" class="form-control" id="material" name="material"/>
            </div>
            <div class="form-group">
                <label for="description">Beschreibung:</label>
                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
            </div>
            <input type="submit" class="btn btn-success" id="add_pic_submit" name="add_pic_submit" value="Speichern" disabled>
            <input type="hidden" name="filePath" id="filePath">
            <input type="hidden" name="thumbPath" id="thumbPath">
        </form>

    </div>

</div>
