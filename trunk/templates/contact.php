<?php /** @var ContactView $this */ ?>

<div class="panel-heading">Kontaktanfrage verfassen</div>
<div class="panel-body">
    <form data-toggle="validator" role="form" action="<?php echo $this->url("contact","send");?>" method="post">

        <div class="form-group has-feedback">
            <label for="title">Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" required value=""/>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <label for="title">Vorname</label>
            <input type="text" class="form-control" id="name" name="name" required value=""/>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <div class="form-group has-feedback">
                <label for="title">eMail</label>
                <input type="text" class="form-control" id="mail" name="mail" required value=""/>
                <span class="glyphicon form-control-feedback input-group-addon>@<" aria-hidden="true"></span>
            </div>
            <label for="title">Telefon</label>
            <input type="text" class="form-control" id="tel" name="tel" value=""/>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            <label for="title">Betreff</label>
            <input type="text" class="form-control" id="subject" name="subject" required value=""/>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
        </div>

        <div class="form-group">
            <label for="content">Inhalt</label>
            <textarea class="form-control" rows="5" id="content" name="content" required></textarea>
        </div>
        <input type="submit" class="btn btn-success" id="news_submit" name="news_submit" value="Absenden">
    </form>