<?php /** @var $this DashboardView */ ?>


<ul class="nav nav-tabs">
    <li class="tab-item active"><a class="tab-control" data-tab="tab_exhibitions" href="#">Ausstellungen</a></li>
    <li><a class="tab-item tab-control" data-tab="tab_pictures" href="#">Gemälde</a></li>
    <li><a class="tab-item tab-control" data-tab="tab_news" href="#">News</a></li>
    <li><a class="tab-item tab-control" data-tab="tab_users" href="#">Benutzer</a></li>
</ul>

<div class="tab_container active" id="tab_exhibitions">
    <!-- Dialog Content -->
    <?php echo new Edit_exhibition_dialogView(/* editMode */
        true); ?>
    <h2>Übersicht aller Ausstellungen</h2>
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
                <td id="exhibition_name_<?php echo $id; ?>"
                    class="table-no-truncate"><?php echo $category->getCategoryName(); ?></td>
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
                       title="Ausstellung entfernen">
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="tab_container" id="tab_pictures">
    <?php echo $this->getUnlinkedPicturesView(); ?>
</div>

<div class="tab_container" id="tab_news">
    <h2>Alle News-Artikel</h2>
</div>

<div class="tab_container" id="tab_users">
    <h2>Alle Benutzer</h2>
</div>