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
            <div id="myCanvasContainer">
                <canvas width="240" height="200" class="center-block" id="myCanvas">
                    <p>In Internet Explorer versions up to 8, things inside the canvas are inaccessible!</p>
                </canvas>
            </div>
            <div id="tags" style="display: none;">
                <ul>
                    <?php foreach ($this->getTags() as $tag):
                        if ($tag->getNumberOccurrences() == 0 || $this->getTagMaxNumberOfOccurrences() == 0) {
                            $weight = 10;
                        } else {
                            $weight = ( $tag->getNumberOccurrences() / $this->getTagMaxNumberOfOccurrences() * 18 ) + 10;
                        }
                    ?>
                        <li><a data-weight="<?php echo $weight; ?>" href="<?php echo $this->url("pictures", "tag", array("id" => $tag->getTagId())); ?>"><?php echo $tag ?></a></li>
                    <?php endforeach; ?>
                </ul>
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
