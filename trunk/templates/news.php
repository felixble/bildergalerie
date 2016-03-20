<?php /** @var NewsView $this */ ?>

<?php
if (null != $this->getPostView()) {
    echo $this->getPostView();
}
?>


<div class="col-md-2"></div>
<div class="col-md-8">
    <div >
        <div >
            <?php foreach ($this->getNewsArticles() as $articles): ?>
                <div>
                    <h2><?php echo $articles->getTitle() ?></h2>
                    <p> <?php echo $articles->getContent() ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-2"></div>