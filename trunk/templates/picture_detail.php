<?php /** @var Picture_detailView $this */ ?>
<?php
$overall_rating = $this->getPicture()->getAverageRatingValue();
$my_rating = $this->getPicture()->getRatingValue();
$rating_text = ($my_rating == null | empty($my_rating))
    ? "Gesamtbewertung: $overall_rating"
    : "Gesamtbewertung: $overall_rating / meine Bewertung: $my_rating";

if ($overall_rating == null || empty($overall_rating)) {
    $overall_rating = 0;
    $rating_text = "Bisher noch keine Bewertungen";
}
?>
<div class="row">
    <div class="col-lg-8">
        <?php if (null != $this->getBackTo()): ?>
            <a href="<?php echo $this->getBackTo(); ?>">Zurück zur Übersicht</a>
        <?php else: ?>
            &nbsp; <!-- empty space because there is no back link -->
        <?php endif; ?>
        <img src="<?php echo $this->getPicture()->getPath()->getPath(); ?>"
             class="img-rounded img-responsive"
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
            <div class="panel-heading">
                <div class="pull-right" title="<?php echo $rating_text; ?>"><?php echo $overall_rating; ?><small>/5</small></div>
                <div class="pull-right c-rating" data-pic-id="<?php echo $this->getPicture()->getPictureId(); ?>" data-overall-rating="<?php echo str_replace(",", ".", $overall_rating); ?>"></div>
                <strong><?php echo $this->getPicture()->getTitle(); ?></strong>
            </div>
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

        <div class="text-center">
            <div class="list-group">
                <a class="list-group-item list-group-item-success" href="<?php echo $this->url("contact", "", array("ref_pic" => $this->getPicture()->getPictureId())); ?>">Künstler kontaktieren</a>
                <?php if($this->isAuthenticated()): ?>
                    <a class="list-group-item list-group-item-info" href="<?php echo $this->url("pictures", "edit", array("id" => $this->getPicture()->getPictureId())); ?>">Gemälde Bearbeiten</a>
                    <a class="list-group-item list-group-item-danger confirmation" data-confirmation-text="Soll das Gemälde wirklich gelöscht werden?" href="<?php echo $this->url("pictures", "delete", array("id" => $this->getPicture()->getPictureId())); ?>">Gemälde löschen</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>