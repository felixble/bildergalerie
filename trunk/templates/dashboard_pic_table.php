<?php /** @var Dashboard_pic_tableView $this */ ?>

<div>
    <div class='pull-right'>
        <a class='btn btn-success hidden-xs hidden-sm'
            href="<?php echo $this->url("pictures", "create"); ?>">
            Neues Gemälde hinzufügen
        </a>
        <a class="btn btn-success visible-xs visible-sm" title="Neues Gemälde hinzufügen"
           href="<?php echo $this->url("pictures", "create"); ?>">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </a>
    </div>
    <h2>Übersicht aller Gemälde</h2>
</div>
<?php if (count($this->getPictures()) == 0): ?>
<p>Es wurden noch keine Bilder hochgeladen.</p>
<?php else: ?>
<table class="table table-striped table-truncate table-hover">
    <thead>
    <tr>
        <th class="col-xs-1"></th>
        <th class="col-xs-3">Titel</th>
        <th class="col-xs-7">Ausstellungen</th>
        <th class="col-xs-1"></th>
    </tr>
    </thead>
    <tbody class="">
    <?php foreach ($this->getPictures() as $picture): $id = $picture->getPictureId() ?>
        <tr>
            <td>
                <a href="<?php echo $this->url("pictures", "pic", array("id" => $id)); ?>">
                    <img class="img-responsive" width="50" src="<?php echo $picture->getPath()->getThumbPath(); ?>">
                </a>
            </td>
            <td id="pic_title_<?php echo $id; ?>"
                class="table-no-truncate"><?php echo $picture->getTitle(); ?></td>
            <td><?php echo $picture->getCategoriesAsString(", "); ?></td>
            <td class="text-right table-no-truncate">
                <a href="<?php echo $this->url("pictures", "edit", array("id" => $id)); ?>"
                   title="Gemälde bearbeiten">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <a href="<?php echo $this->url("pictures", "delete", array("id" => $id)); ?>"
                   class="confirmation"
                   data-confirmation-text="Soll das Gemälde wirklich gelöscht werden?"
                   title="Gemälde entfernen">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>