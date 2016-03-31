<?php /** @var Dashboard_unlinked_picturesView $this */ ?>

<h2>Lose Gemälde</h2>
<p>
    Die folgenden Bilder wurden bereits hochgeladen, sind jedoch noch nicht mit Details verknüpft. Wählen Sie ein Bild
    aus, um einen Titel und weitere Informationen hinzuzufügen. Erst dann kann das Bild im öffentlichen Bereich
    ausgestellt werden.
</p>
<div class="menu row">
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
