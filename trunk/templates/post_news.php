<?php /** @var Post_newsView $this */ ?>

<div class="anchor" id="new_article"></div>
<div class="panel panel-default">
    <div class="panel-heading">Beitrag <?php echo ($this->isEditMode()) ? "ändern" : "verfassen"; ?></div>
    <div class="panel-body">
        <form data-toggle="validator" role="form" action="<?php echo $this->url("news","create");?>" method="post">

            <div class="form-group has-feedback">
                <label for="title">Titel</label>
                <input type="text" class="form-control" id="title" name="title" required value="<?php echo $this->getTitle();?>"/>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>

            <div class="form-group">
                <label for="content">Inhalt</label>
                <textarea class="form-control" rows="5" id="content" name="content" required><?php echo $this->getContent()?></textarea>
            </div>
            <input type="submit" class="btn btn-success" id="news_submit" name="news_submit" value="Speichern">
            <input type="hidden" name="edit_id" value="<?php echo $this->getID()?>">
        </form>

    </div>
</div>


