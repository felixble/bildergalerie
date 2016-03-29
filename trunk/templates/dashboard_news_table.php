<?php /** @var $this Dashboard_news_tableView */ ?>
<?php
/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 24.03.2016
 * Time: 12:11
 */

?>

<div>
    <div class='pull-right'>
        <a class='btn btn-success hidden-xs hidden-sm'
           href="<?php echo $this->url("news", "", array(), "new_article"); ?>">
            Neuen Artikel erstellen
        </a>
        <a class="btn btn-success visible-xs visible-sm" title="Neuen Artikel erstellen"
           href="<?php echo $this->url("news", "", array(), "new_article"); ?>">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </a>
    </div>
    <h2>Alle News-Artikel</h2>
</div>
<table class="table table-striped table-truncate table-hover">
    <thead>
    <tr>
        <th class="col-xs-3">Titel</th>
        <th class="col-xs-5">Inhalt</th>
        <th class="col-xs-2">Erstellt von</th>
        <th class="col-xs-1">Erstellt am</th>
        <th class="col-xs-1"></th>
    </tr>
    </thead>
    <tbody class="">
    <?php foreach ($this->getNewsArticles() as $article):?>
        <tr>
            <td class="table-no-truncate">
                <a href="<?php echo $this->url("news", "", array(), $article->getId()); ?>">
                    <?php echo $article->getTitle(); ?>
                </a>
            </td>
            <td> <?php echo $article->getContent(); ?></td>
            <td><?php echo $article->getOwner(); ?></td>
            <td><?php echo $article->getDate()->format("d.m.Y"); ?></td>
            <td class="text-right table-no-truncate">
                <a href="<?php echo $this->url("news", "update", array("id" => $article->getId()), "new_article") ?>"
                   title="Artikel bearbeiten">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>

                <a class="confirmation" data-confirmation-text="Soll der Artikel wirklich gelöscht werden?"
                   href="<?php echo $this->url("news", "delete", array("id" => $article->getId())); ?>"
                   title="Artikel entfernen">
                    <span class="glyphicon glyphicon-remove "  aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>