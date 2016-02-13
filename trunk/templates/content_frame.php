<?php /** @var Content_frameView $this */ ?>
<!-- NAVBAR
================================================== -->
<div class="navbar-wrapper">
    <div class="container">

        <nav id="nav" class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <!-- Three spans responsible for the three horizontal lines to toggle the navigation bar on mobile devices -->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="">Hilde Blechschmitt</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="auto_activate" id="home"><a href="<?php echo $this->url(); ?>">Startseite</a></li>
                        <li class="auto_activate" id="about"><a href="<?php echo $this->url("about"); ?>">Die Künstlerin</a></li>
                        <li class="auto_activate" id="news"><a href="<?php echo $this->url("news"); ?>">News</a></li>
                        <li class="auto_activate" id="pictures"><a href="<?php echo $this->url("pictures"); ?>">Gemälde</a></li>
                        <li class="auto_activate" id="contact"><a href="<?php echo $this->url("contact"); ?>">Kontakt</a></li>
                        <li class="auto_activate" id="legalnotice"><a href="<?php echo $this->url("legalnotice"); ?>">Impressum</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
</div>

<!-- Carousel
  ================================================== -->
<div class="overlay"><h1><span class="hidden-xs">Hildes Bildergalerie - </span><?php echo $this->getTitle(); ?></h1></div>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <!-- <li data-target="#myCarousel" data-slide-to="2"></li>-->
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <!--<img class="first-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="First slide">
            <img class="first-slide" src="img/header.JPG" /> -->
            <div class="header-image" style="background-image: url('resources/img/header.JPG');"></div>
        </div>
        <div class="item">
            <!--<img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">-->
            <div class="header-image" style="background-image: url('resources/img/header2.JPG');"></div>
        </div>
        <!--<div class="item">
            <img class="third-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Third slide">
            <div class="container">
                <div class="carousel-caption">
                    <h1>One more for good measure.</h1>
                    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    <p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
                </div>
            </div>
        </div>-->
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div><!-- /.carousel -->

<div class="container main-content">

    <?php echo $this->getContent(); ?>

    <!-- FOOTER -->
    <footer class="modal-footer">
        <p class="pull-right"><a href="<?php echo $this->urlScrollTo(""); ?>">Back to top</a></p>
        <p class="pull-left">&copy; 2015 Hildes Bildergalerie &middot; Designed by Felix Blechschmitt &middot; <a href="<?php echo $this->url("legalnotice"); ?>">Impressum</a> &middot; <a href="#">Login</a></p>
    </footer>

</div>
<!-- /END THE MAIN CONTENT -->