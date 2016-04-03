<?php /** @var Dashboard_unlinked_picturesView $this */ ?>

<h2>Lose Gemälde</h2>
<p>
    Die folgenden Bilder wurden bereits hochgeladen, sind jedoch noch nicht mit Details verknüpft. Wählen Sie ein Bild
    aus, um einen Titel und weitere Informationen hinzuzufügen. Erst dann kann das Bild im öffentlichen Bereich
    ausgestellt werden.
</p>
<div class="menu row">


    <div id="uploadzone" class="uploadzone menu-category">
        <svg class="uploadzone_icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43">
            <path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7
            1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2
            1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7
            1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z"></path>
        </svg>
        <span id="drop_help">Neue Gemälde hochladen</span>
        <span id="drop_text" style="display: none">Bilder hier ablegen</span>
        <span id="uploading_text" style="display: none">hochladen...</span>
    </div>


    <?php foreach ($this->getPicturePathes() as $path): ?>
        <div class="menu-category list-group">
            <?php $url = $this->url("pictures", "create", array("path_id" => $path->getId())); ?>
            <a href="<?php echo $url; ?>">
                <img style="max-width: 100%" src="<?php echo $path->getThumbPath(); ?>">
            </a>
            <div class="menu-category-name list-group-item">
                <a href="<?php echo $url; ?>"><?php echo $path->getFileName(); ?></a>
                <span class="pull-right">
                    <a href="<?php echo $url ?>"
                       title="Loses Gemälde mit Details verknüpfen">
                        <span class="glyphicon glyphicon-link"  aria-hidden="true"></span>
                    </a>
                    <a class="confirmation" data-confirmation-text="Soll das lose Gemälde wirklich gelöscht werden?"
                       href="<?php echo $this->url("pictures", "deleteUnlinkedPicture", array("id" => $path->getId())); ?>"
                       title="Loses Gemälde löschen">
                        <span class="glyphicon glyphicon-remove "  aria-hidden="true"></span>
                    </a>
                </span>
            </div>
        </div>
    <?php endforeach; ?>
</div>


