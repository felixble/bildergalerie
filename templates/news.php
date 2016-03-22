<?php /** @var NewsView $this */ ?>

<?php
if (null != $this->getPostView()) {
    echo $this->getPostView();
}
?>


<div>
    <?php foreach ($this->getNewsArticles() as $article): ?>
        <div>
            <hr>
            <h2><?php echo $article->getTitle() ?></h2>

            <p> <?php echo $article->getContent() ?></p>
            <div class="pull-right">
            <a href="<?php echo $this->url("news", "update", array("id" => $article->getId())) ?>"
               title="Kommentar bearbeiten">
                <span class="glyphicon glyphicon-pencil pull-right" aria-hidden="true"></span>
            </a>

            <a class="confirmation" data-confirmation-text="Soll der Artikel wirklich gelöscht werden?"
               href="<?php echo $this->url("news", "delete", array("id" => $article->getId())) ?>"
               title="Kommentar entfernen">
                <span class="glyphicon glyphicon-remove pull-right" aria-hidden="true"></span>
            </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
