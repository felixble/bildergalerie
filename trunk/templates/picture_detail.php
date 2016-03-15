<?php /** @var Picture_detailView $this */ ?>
<?php
//$this->getPicture()->setTags(array("Foto", "Hilde", "malen", "Pinsel", "Farbpalette"));
?>
<div class="row">
    <div class="col-lg-8">
        <?php if(null != $this->getBackTo()): ?>
        <a href="<?php echo $this->getBackTo(); ?>">Zurück zur Übersicht</a>
        <?php endif; ?>
        <img src="<?php echo $this->getPicture()->getPath()->getPath(); ?>"
             class="img-rounded img-responsive
              alt="<?php echo $this->getPicture()->getTitle(); ?>" width="1000" />
        <?php
        $tags = $this->getPicture()->getTags();
        foreach ($tags as $tag) {
            echo "<span class=\"label label-info\">" . $tag->getTagName() . "</span>\n";
        }
        ?>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default" style="margin-top: 20px">
            <div class="panel-heading"><strong><?php echo $this->getPicture()->getTitle(); ?></strong></div>
            <div class="panel-body">
                <?php if(null != $this->getPicture()->getMaterial()): ?>
                <h4>Material/Technik</h4>
                <?php echo $this->getPicture()->getMaterial(); ?>
                <?php endif; ?>

                <?php if(null != $this->getPicture()->getFormat()): ?>
                <h4>Format</h4>
                <?php echo $this->getPicture()->getFormat(); ?>
                <?php endif; ?>

                <?php if(null != $this->getPicture()->getDescription()): ?>
                <h4>Beschreibung</h4>
                <p><?php echo $this->getPicture()->getDescription(); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>