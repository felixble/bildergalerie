<?php /** @var Picture_detailView $this */ ?>
<div class="row">
    <div class="col-lg-8">
        <a href="#">Zurück zur Übersicht</a>
        <img src="<?php echo $this->getPicture()->getPath()->getPath(); ?>"
             class="img-rounded img-responsive center-block
     alt="<?php echo $this->getPicture()->getTitle(); ?>" width="800" />

    </div>
    <div class="col-lg-4">
        <h3><?php echo $this->getPicture()->getTitle(); ?></h3>
        <h4>Material/Technik</h4>
        <?php echo $this->getPicture()->getMaterial(); ?>
        <h4>Format</h4>
        <?php echo $this->getPicture()->getFormat(); ?>
        <h4>Beschreibung</h4>
        <p><?php echo $this->getPicture()->getDescription(); ?></p>
    </div>
</div>