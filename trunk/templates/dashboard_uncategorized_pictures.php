<?php /** @var Dashboard_uncategorized_picturesView $this */ ?>
<h2>Nicht-Zugeordnete Gemälde</h2>
<p>
    Diese Gemälde sind keiner Ausstellung zugeordnet und können deshalb auf der öffentlichen Seite nicht
    angezeigt werden.<br>
    <small>Achtung: Die Bilder werden demnach auch nicht unter "Alle Gemälde" aufgelistet.</small>
</p>
<table class="table table-striped table-truncate table-hover">
    <thead>
    <tr>
        <th class="col-xs-1"></th>
        <th class="col-xs-3">Titel</th>
        <th class="col-xs-7">Ausstellungen</th>
        <th class="col-xs-1"></th>
    </tr>
    </thead>
    <tbody class="">
    <?php foreach ($this->getUncategorizedPics() as $picture): $id = $picture->getPictureId() ?>
        <tr>
            <td>
                <a href="<?php echo $this->url("pictures", "pic", array("id" => $id)); ?>">
                    <img class="img-responsive" width="50" src="<?php echo $picture->getPath()->getThumbPath(); ?>">
                </a>
            </td>
            <td id="pic_title_<?php echo $id; ?>"
                class="table-no-truncate"><?php echo $picture->getTitle(); ?></td>
            <td style="overflow: visible">
                <div id="form-group-exhibition" data-error="Bitte wählen Sie mindestens eine Ausstellung.">
                    <div class="input-group">
                        <select class="selectpicker form-control" name="category[]" id="categorize_<?php echo $id; ?>" data-none-selected-text="-- Bitte wählen --" multiple>
                            <?php
                            foreach ($this->getAllCategories() as $category) {
                                echo "<option value='" . $category->getCategoryId() . "'>" . $category->getCategoryName() . "</option>";
                            }
                            ?>
                        </select>
                        <span class="input-group-btn">
                            <button class="btn btn-success save_categorize_pic"
                                    type="button" title="speichern" data-id="<?php echo $id; ?>">
                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                            </button>
                        </span>
                    </div>
                    <div class="help-block with-errors"></div>
                </div>
            </td>
            <td class="text-right table-no-truncate">
                <a href="<?php echo $this->url("pictures", "edit", array("id" => $id)); ?>"
                   title="Gemälde bearbeiten">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <a href="<?php echo $this->url("pictures", "delete", array("id" => $id)); ?>"
                   class="confirmation"
                   data-confirmation-text="Soll das Gemälde wirklich gelöscht werden?"
                   title="Gemälde entfernen">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>