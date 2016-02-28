<?php /** @var Exhibition_teasersView $this */ ?>
<?php $i = 0;
foreach ($this->getCatTeasers() as $catTeaser): /** @var CategoryTeaser $catTeaser */ ?>
    <?php if ($i != 0 || $this->showFirstDivider()): ?>
        <hr class="featurette-divider">
    <?php endif; ?>
    <div class="row featurette">
        <div class="col-md-7 <?php if (($i % 2) != 0) echo "col-md-push-5"; ?>">
            <h2 class="featurette-heading">Ausstellung <span
                    class="text-muted"><?php echo $catTeaser->getName(); ?></span></h2>
            <p class="lead"><?php echo $catTeaser->getDescription(); ?></p>
            <p>
                <a class="btn btn-default"
                   href="<?php echo $this->url("pictures", "exhibition", array("id" => $catTeaser->getCategory()->getCategoryId())) ?>"
                   role="button">
                    Ausstellung anschauen &raquo;
                </a>
            </p>
        </div>
        <div class="col-md-5 <?php if (($i % 2) != 0) echo "col-md-pull-7"; ?> exhibition_teaser_img">
            <img class="featurette-image img-responsive center-block" height="500"
                 src="<?php echo $catTeaser->getPictureThumb(); ?>"
                 alt="<?php echo $catTeaser->getTitle(); ?>">
        </div>
    </div>
<?php $i++; endforeach; ?>