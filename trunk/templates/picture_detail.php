<?php /** @var Picture_detailView $this */ ?>
<div class="text-center">
<img src="<?php echo $this->getPicture()->getPath()->getPath(); ?>" class="img-rounded img-responsive center-block" alt="Cinque Terre" width="800" />
    <h1><?php echo $this->getPicture()->getTitle(); ?></h1>
</div>