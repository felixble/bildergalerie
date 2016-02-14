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
<div class="overlay <?php echo ($this->showCarousel()) ? "" : "overlay-inverse overlay-only-header"; ?>">
    <h1><span class="hidden-xs"><?php echo $this->getPageTitle(); ?> - </span><?php echo $this->getTitle(); ?></h1>
</div>

<?php if ($this->showCarousel()): ?>
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <div class="header-image" style="background-image: url('resources/img/header.JPG');"></div>
            </div>
            <div class="item">
                <div class="header-image" style="background-image: url('resources/img/header2.JPG');"></div>
            </div>
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
<?php else: ?>
    <div id="myCarousel" class="carousel carousel-only-header"></div>
<?php endif; ?>

<div class="container main-content">

    <?php echo $this->getContent(); ?>

    <!-- FOOTER -->
    <footer class="modal-footer">
        <p class="pull-right"><a href="<?php echo $this->urlScrollTo(""); ?>">Back to top</a></p>
        <p class="pull-left">&copy; 2015 <?php echo $this->getPageTitle(); ?> &middot; Designed by Felix Blechschmitt &middot; <a href="<?php echo $this->url("legalnotice"); ?>">Impressum</a> &middot; <a href="<?php echo $this->url("auth", "login"); ?>">Login</a></p>
    </footer>

</div>
<!-- /END THE MAIN CONTENT -->