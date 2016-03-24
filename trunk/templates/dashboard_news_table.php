<?php /** @var $this Dashboard_news_tableView */ ?>
<?php
/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 24.03.2016
 * Time: 12:11
 */

?>

<h2>Alle News-Artikel</h2>

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
            <td class="table-no-truncate"><?php echo $article->getTitle(); ?></td>
            <td> <?php echo $article->getContent(); ?></td>
            <td><?php echo $article->getOwner(); ?></td>
            <td><?php echo $article->getDate()->format("d.m.Y"); ?></td>
            <td class="text-right table-no-truncate">
                <a href="<?php echo $this->url("news", "update", array("id" => $article->getId())) ?>"
                   title="Artikel bearbeiten">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>

                <a class="confirmation" data-confirmation-text="Soll der Artikel wirklich gelöscht werden?" href="<?php echo $this->url("news", "delete", array("id" => $article->getId())) ?>"
                   title="Artikel entfernen">
                    <span class="glyphicon glyphicon-remove "  aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>