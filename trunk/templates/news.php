<?php /** @var NewsView $this */ ?>

<?php
if (null != $this->getPostView()) {
    echo $this->getPostView();
}
?>


<div class="col-md-2"></div>
<div class="col-md-8">
    <div>
        <div>
            <?php foreach ($this->getNewsArticles() as $article): ?>
                <div>
                    <h2><?php echo $article->getTitle() ?>

                        <a href="<?php echo $this->url("news", "update", array("id"=> $article->getId())) ?>"
                           title="Kommentar bearbeiten">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>

                        <a href="<?php echo $this->url("news", "delete", array("id"=>$article->getId())) ?>"
                           title="Kommentar entfernen">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>

                    </h2>
                    <p> <?php echo $article->getContent() ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-2"></div>