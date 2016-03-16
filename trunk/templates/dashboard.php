<?php /** @var $this DashboardView */ ?>

<!-- Dialog Content -->
<?php echo new Edit_exhibition_dialogView(/* editMode */ true); ?>
<h1>Ausstellungen</h1>
<table class="table table-striped table-truncate table-hover">
    <thead>
        <tr>
            <th class="col-xs-3">Titel/Thema</th>
            <th class="col-xs-7">Beschreibung</th>
            <th class="col-xs-1">#Gemälde</th>
            <th class="col-xs-1"></th>
        </tr>
    </thead>
    <tbody class="">
        <?php foreach ($this->getCategories() as $category): $id = $category->getCategoryId() ?>
        <tr>
            <td id="exhibition_name_<?php echo $id; ?>" class="table-no-truncate"><?php echo $category->getCategoryName(); ?></td>
            <td id="exhibition_descr_<?php echo $id; ?>"><?php echo $category->getDescription(); ?></td>
            <td class="text-center"><?php echo $category->getNumberPictures(); ?></td>
            <td class="text-right table-no-truncate">
                <a href=""
                   title="Ausstellung bearbeiten"
                   class="open_category_dialog"
                    data-id="<?php echo $id; ?>"
                    data-get-values="getEditValuesDashboard"
                    data-on-success="onSuccessDashboard">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
                <!-- TODO: Remove exhibition -->
                <a href=""
                   title="Ausstellung entfernen"
                   class="open_category_dialog"
                   data-id="<?php echo $id; ?>"
                   data-get-values="getEditValuesDashboard"
                   data-on-success="onSuccessDashboard">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>