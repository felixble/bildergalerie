<?php /** @var ContactView $this */ ?>

<h2>Kontaktanfrage verfassen</h2>

<div class="row">

    <div class="<?php echo (null != $this->getPicture()) ? "col-md-8" : "col-md-12"; ?>">
        <form data-toggle="validator" role="form" action="<?php echo $this->url("contact","send");?>" method="post">

            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <div class="form-group">
                        <label for="name">Vorname</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="name-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="name-addon" autofocus/>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="form-group has-feedback">
                        <label for="lastName">Nachname</label>
                        <div class="input-group">
                            <span class="input-group-addon" id="lastName-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input type="text" class="form-control" id="lastName" name="lastName" aria-describedby="lastName-addon" required/>
                        </div>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                    </div>
                </div>
            </div>


            <div class="form-group has-feedback">
                <label for="mail" class="control-label">E-Mail</label>
                <div class="input-group">
                    <span class="input-group-addon" id="email-addon">@</span>
                    <input type="email" class="form-control" id="mail" name="mail" placeholder="email@example.com"
                           data-error="Bitte geben Sie eine korrekte E-Mail-Adresse an, damit wir Ihnen antworten können." aria-describedby="email-addon" required />
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>
            <div class="form-group">
                <label for="tel">Telefon</label>
                <div class="input-group">
                    <span class="input-group-addon" id="tel-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                    <input type="text" class="form-control" id="tel" name="tel" aria-describedby="tel-addon"/>
                </div>
            </div>
            <div class="form-group has-feedback">
                <!-- glyphicon glyphicon-bullhorn / glyphicon glyphicon-envelope -->
                <label for="subject">Betreff</label>
                <div class="input-group">
                    <span class="input-group-addon"  id="subject-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input type="text" class="form-control" id="subject" name="subject"
                           value="<?php echo $this->getSubjectValue(); ?>"
                           aria-describedby="subject-addon" required value=""/>
                </div>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                <div class="help-block with-errors"></div>
            </div>

            <div class="form-group has-feedback">
                <label for="content">Inhalt</label>
                <textarea class="form-control" rows="5" id="content" name="content" required></textarea>
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <input type="submit" class="btn btn-success" id="news_submit" name="news_submit" value="Absenden">
        </form>
    </div>

    <?php if (null != $this->getPicture()): ?>
        <div class="col-md-4">
            <h3>Anfrage zum Bild</h3>
            <img class="img-responsive" src="<?php echo $this->getPicture()->getPath()->getThumbPath(); ?>">
            <div class="text-center"><b><?php echo $this->getPicture()->getTitle(); ?></b></div>
        </div>
    <?php endif; ?>

</div>