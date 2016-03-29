<?php /** @var ExhibitionView $this */ ?>
<div class="container">
    <?php
    $count = count($this->getPictures());
    if ($count == 0): ?>
    <h2>Die Ausstellung wird in Kürze veröffentlicht</h2>
    <p>
        Ich aktualisiere derzeit meine Online-Ausstellung. Bitte besuchen Sie meine Website bald wieder.
    </p>
    <?php else: ?>
    <h1><?php echo $this->getExhibitionName(); ?></h1>
    <p>
        <?php echo $this->getExhibitionDescription(); ?>
    </p>
    <?php endif; ?>
    <div class="menu row">
        <?php if ($this->showTagCanvas()): ?>
        <div class="menu-category list-group">
            <div id="myCanvasContainer" style="border: 1px solid #DDDDDD;">
                <canvas width="240" height="200" class="center-block" id="myCanvas">
                    <p>In Internet Explorer versions up to 8, things inside the canvas are inaccessible!</p>
                </canvas>
            </div>
            <div id="tags">
                <ul>
                    <?php foreach ($this->getTags() as $tag): ?>
                        <li><a href="#"><?php echo $tag->getTagName(); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="menu-category-name list-group-item">
                Schlagwörter
            </div>
        </div>
        <?php endif; ?>

        <?php foreach ($this->getPictures() as $picture): ?>
            <div class="menu-category list-group">
                <?php $url = $this->url("pictures", "pic", array("id" => $picture->getPictureId())); ?>
                <a href="<?php echo $url; ?>">
                    <img style="max-width: 100%" src="<?php echo $picture->getPath()->getThumbPath(); ?>">
                </a>
                <div class="menu-category-name list-group-item">
                    <a href="<?php echo $url; ?>"><?php echo $picture->getTitle() ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
