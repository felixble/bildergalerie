<?php /** @var $this DashboardView */ ?>


<ul class="nav nav-tabs">
    <li class="tab-item active" id="tab_exhibitions"><a class="tab-control" data-tab="exhibitions" href="<?php echo $this->urlScrollTo("exhibitions") ?>">Ausstellungen</a></li>
    <li class="tab-item" id="tab_pictures"><a class="tab-control" data-tab="pictures" href="<?php echo $this->urlScrollTo("pictures") ?>">Gemälde</a></li>
    <li class="tab-item" id="tab_news"><a class="tab-control" data-tab="news" href="<?php echo $this->urlScrollTo("news") ?>">News</a></li>
    <li class="tab-item" id="tab_users"><a class="tab-control" data-tab="users" href="<?php echo $this->urlScrollTo("users") ?>">Benutzer</a></li>
</ul>

<div class="tab_container active" id="_exhibitions">
    <!-- Dialog Content -->
    <?php echo new Edit_exhibition_dialogView(/* editMode */
        true); ?>
    <div>
        <div class='pull-right'>
            <!-- TODO: onSuccess anpassen!! -->
            <button type='button' class='open_category_dialog btn btn-success hidden-xs hidden-sm'
                    data-on-success="onSuccessDashboard">
                Neue Ausstellung hinzufügen
            </button>
            <button class="open_category_dialog btn btn-success visible-xs visible-sm" data-on-success="onSuccessDashboard"
                    type="button" title="Neue Ausstellung hinzufügen">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
        <h2>Übersicht aller Ausstellungen</h2>
    </div>


    <table id="exhibition_table_body" class="table table-striped table-truncate table-hover">
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
            <tr id="row_<?php echo $id; ?>">
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

<div class="tab_container" id="_pictures">
    <?php echo $this->getUnlinkedPicturesView(); ?>
    <?php echo $this->getPictureTableView(); ?>
</div>

<div class="tab_container" id="_news">
    <?php echo $this->getNewsTableView(); ?>
</div>

<div class="tab_container" id="_users">
    <h2>Alle Benutzer</h2>
</div>