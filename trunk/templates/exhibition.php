<?php /** @var ExhibitionView $this */ ?>
<div class="container">
    <h1><?php echo $this->getExhibitionName(); ?></h1>
    <p>
        <?php echo $this->getExhibitionDescription(); ?>
    </p>
    <div class="menu row">
        <?php foreach ($this->getPictures() as $picture): ?>
            <div class="menu-category list-group">
                <img style="max-width: 100%" src="<?php echo $picture->getPath()->getThumbPath(); ?>">
                <div class="menu-category-name list-group-item"><?php echo $picture->getTitle() ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
