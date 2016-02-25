<?php /** @var Picture_detailView $this */ ?>
<?php
$this->getPicture()->setTags(array("Foto", "Hilde", "malen", "Pinsel", "Farbpalette"));
?>
<div class="row">
    <div class="col-lg-8">
        <a href="#">Zurück zur Übersicht</a>
        <img src="<?php echo $this->getPicture()->getPath()->getPath(); ?>"
             class="img-rounded img-responsive center-block
     alt="<?php echo $this->getPicture()->getTitle(); ?>" width="800" />
        <?php
        $tags = $this->getPicture()->getTags();
        foreach ($tags as $tag) {
            echo "<span class=\"label label-info\">" . $tag->getTagName() . "</span>\n";
        }
        ?>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-primary" style="margin-top: 20px">
            <div class="panel-heading"> <?php echo $this->getPicture()->getTitle(); ?></div>
            <div class="panel-body">
            <h4>Material/Technik</h4>
            <?php echo $this->getPicture()->getMaterial(); ?>
            <h4>Format</h4>
            <?php echo $this->getPicture()->getFormat(); ?>
            <h4>Beschreibung</h4>
            <p><?php echo $this->getPicture()->getDescription(); ?></p>
                </div>
        </div>
    </div>
</div>