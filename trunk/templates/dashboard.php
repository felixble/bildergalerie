<?php /** @var $this DashboardView */ ?>
<h1>Ausstellungen</h1>
<table class="table table-striped table-truncate table-hover">
    <thead>
        <tr>
            <th class="col-xs-3">Titel/Thema</th>
            <th class="col-xs-8">Beschreibung</th>
            <th class="col-xs-1"></th>
        </tr>
    </thead>
    <tbody class="">
        <?php foreach ($this->getCategories() as $category): ?>
        <tr>
            <td class="table-no-truncate"><?php echo $category->getCategoryName(); ?></td>
            <td><?php echo $category->getDescription(); ?></td>
            <td class="text-right">
                <a href="<?php echo $this->url("exhibition", "edit", array("id" => $category->getCategoryId())); ?>">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>