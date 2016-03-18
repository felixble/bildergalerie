<?php /** @var Picture_detailView $this */ ?>
<?php
?>
<div class="row">
    <div class="col-lg-8">
        <?php if (null != $this->getBackTo()): ?>
            <a href="<?php echo $this->getBackTo(); ?>">Zurück zur Übersicht</a>
        <?php else: ?>
            &nbsp; <!-- empty space because there is no back link -->
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
                <?php if (null != $this->getPicture()->getMaterial()): ?>
                    <h4>Material/Technik</h4>
                    <?php echo $this->getPicture()->getMaterial(); ?>
                <?php endif; ?>

                <?php if (null != $this->getPicture()->getFormat()): ?>
                    <h4>Format</h4>
                    <?php echo $this->getPicture()->getFormat(); ?>
                <?php endif; ?>

                <?php if (null != $this->getPicture()->getDescription()): ?>
                    <h4>Beschreibung</h4>
                    <p><?php echo $this->getPicture()->getDescription(); ?></p>
                <?php endif; ?>

                <?php if (0 != count($this->getOtherCategories())): ?>
                    <h4><?php echo ($this->hasCurrentExhibition()) ? "Ebenso ausgestellt in" : "Ausgestellt in"; ?></h4>
                    <ul>
                        <?php foreach ($this->getOtherCategories() as $category): ?>
                            <li>
                                <a href="<?php echo $this->url("pictures", "exhibition", array("id" => $category->getCategoryId())); ?>"><?php echo $category->getCategoryName(); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <?php if($this->isAuthenticated()): ?>
        <div class="text-center">
            <a class="btn btn-lg btn-primary btn-lg-block" href="<?php echo $this->url("pictures", "edit", array("id" => $this->getPicture()->getPictureId())); ?>">Gemälde Bearbeiten</a>
            <br>
            <a class="btn btn-lg btn-danger btn-lg-block" href="<?php echo $this->url("pictures", "delete", array("id" => $this->getPicture()->getPictureId())); ?>">Gemälde löschen</a>
        </div>
        <?php endif; ?>
    </div>
</div>