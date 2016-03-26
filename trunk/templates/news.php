<?php /** @var NewsView $this */ ?>

<?php
if (null != $this->getPostView()) {
    echo $this->getPostView();
}
?>


<div>
    <?php foreach ($this->getNewsArticles() as $article): ?>
        <div>
            <h2><?php echo $article->getTitle() ?></h2>

            <h6>Veröffentlicht am <?php echo $this->getGermanDate($article->getDate()); ?> von <?php echo $article->getOwner(); ?></h6>

            <p> <?php echo $article->getContent() ?></p>
                <div class="articleDevider">
                <?php if ($this->isUserLoggedIn()): ?>
                    <a href="<?php echo $this->url("news", "update", array("id" => $article->getId()), "new_article") ?>"
                       title="Kommentar bearbeiten">Bearbeiten
                    </a> &middot

                    <a class="confirmation" data-confirmation-text="Soll der Artikel wirklich gelöscht werden?"
                       href="<?php echo $this->url("news", "delete", array("id" => $article->getId())) ?>"
                       title="Kommentar entfernen">Entfernen
                    </a>
                <?php endif; ?>
                </div>
        </div>
    <?php endforeach; ?>
</div>
