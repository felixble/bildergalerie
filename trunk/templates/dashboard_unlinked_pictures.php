<?php /** @var Dashboard_unlinked_picturesView $this */ ?>

<h2>Lose Gemälde</h2>
<p>Die folgenden Bilder wurden bereits hochgeladen, sind jedoch noch nicht mit Details verknüpft. Wählen Sie ein Bild
    aus, um einen Title und weitere Informationen hinzuzufügen.</p>
<div class="menu row">
    <?php foreach ($this->getPicturePathes() as $path): ?>
        <div class="menu-category list-group">
            <?php $url = $this->url("pictures", "create", array("path_id" => $path->getId())); ?>
            <a href="<?php echo $url; ?>">
                <img style="max-width: 100%" src="<?php echo $path->getThumbPath(); ?>">
            </a>
            <div class="menu-category-name list-group-item">
                <a href="<?php echo $url; ?>"><?php echo $path->getFileName(); ?></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
