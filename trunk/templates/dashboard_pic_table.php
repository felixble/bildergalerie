<?php /** @var Dashboard_pic_tableView $this */ ?>

<h2>Übersicht aller Gemälde</h2>
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
            <td><img class="img-responsive" width="50" src="<?php echo $picture->getPath()->getThumbPath(); ?>"></td>
            <td id="pic_title_<?php echo $id; ?>"
                class="table-no-truncate"><?php echo $picture->getTitle(); ?></td>
            <td id="exhibition_descr_<?php echo $id; ?>">Hier und da (TODO)</td>
            <td class="text-right table-no-truncate">
                <a href="<?php echo $this->url("pictures", "edit", array("id" => $id)); ?>"
                   title="Gemälde bearbeiten">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <!-- TODO: Remove exhibition -->
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
