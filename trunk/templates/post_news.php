<?php /** @var Post_newsView $this */ ?>

<div class="row">

    <div class="col-md-2"></div>

    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Beitrag verfassen</div>
            <div class="panel-body">
                <form data-toggle="validator" role="form" action="<?php echo $this->url("news","create");?>" method="post">

                    <div class="form-group has-feedback">
                        <label for="title">Titel</label>
                        <input type="text" class="form-control" id="title" name="title" required value="test"/>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>

                    <div class="form-group">
                        <label for="content">Inhalt</label>
                        <textarea class="form-control" rows="5" id="content" name="content" required></textarea>
                    </div>
                    <input type="submit" class="btn btn-success" id="news_submit" name="news_submit" value="Speichern">
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

