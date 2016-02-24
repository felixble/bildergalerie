<?php /** @var Picture_detailView $this */ ?>
<div class="row">
    <div class="col-lg-9">
        <img src="<?php echo $this->getPicture()->getPath()->getPath(); ?>"
             class="img-rounded img-responsive center-block
     alt="<?php echo $this->getPicture()->getTitle(); ?>" width="800" />

    </div>
    <div class="col-lg-3">
        <h3><?php echo $this->getPicture()->getTitle(); ?></h3>
        <?php echo $this->getPicture()->getCategory()->getCategoryName(); ?><br>
        <?php echo $this->getPicture()->getMaterial(); ?><br>
        <p>
        <?php echo $this->getPicture()->getDescription(); ?></p>
    </div>
</div>