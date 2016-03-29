<?php /** @var HomeView $this */ ?>
<?php
$galery_text = "Malen bedeutet Lebensfreude und Lust. Mit den Jahren kommen viele Gemälde zustanden. Eine Auswahl "
                . "dieser findet sich in verschiedenen thematisch eingebetteten Ausstellungen wieder. "
                . "Viel Spaß beim Stöbern.";

$about_text = "Hildegard Blechschmitt, geboren in Speyer 1951, lebt in St. Ingbert und malt mit Liebe und Freude "
                . "in ihrem kleinen Atelier, das schon aus den Nähten zu platzen drohte, wenn sich nicht durch "
                . "glückliche Fügung die Chance aufgetan hätte, eine große Menge Bilder in den Fluren und Räumen "
                . "einer Neunkircher Klinik aufzuhängen.";

$news_text = $this->getLatestArticle()->getContent();

$max_length = 218;

$about_text = (strlen($about_text) > $max_length) ? substr($about_text, 0, $max_length) . "..." : $about_text;
$news_text = (strlen($news_text) > $max_length) ? substr($news_text, 0, $max_length) . "..." : $news_text;

?>

<!-- Three columns of text below the carousel -->
<div class="row">
    <div class="col-sm-4">
        <img class="img-circle" src="resources/img/hilde_galery.jpg" alt="Hildes Galery" width="140" height="140">
        <h2>Galerie</h2>
        <p><?php echo $galery_text; ?></p>
        <p><a class="btn btn-default" href="<?php echo $this->url("pictures", "exhibitions"); ?>" role="button">Ausstellungen anschauen &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
    <div class="col-sm-4">
        <img class="img-circle" src="resources/img/hilde_profile.jpg" alt="Hilde, Die Künstlerin" width="140"
             height="140">
        <h2>Die Künstlerin</h2>
        <p><?php echo $about_text; ?></p>
        <p><a class="btn btn-default" href="<?php echo $this->url("about"); ?>" role="button">Mehr erfahren &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
    <div class="col-sm-4">
        <img class="img-circle" src="resources/img/hilde_news.jpg" alt="Hildes News" width="140" height="140">
        <h2>Aktuelles</h2>
        <p><?php echo $news_text; ?></p>
        <p><a class="btn btn-default" href="<?php echo $this->url("news"); ?>" role="button">News lesen &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
</div><!-- /.row -->


<!-- Category TEASERS to introduce the most popular categories -->

<?php echo $this->getCatTeaserView(); ?>


<!-- /END THE TEASERS -->
