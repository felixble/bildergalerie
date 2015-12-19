<?php
    /** @var HomeView $this */

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Hildes Bildergalerie - <?php echo $this->getTitle() ?></title>
    <base href="/projects/Bildergalerie_Bootstrap/">
    <!-- Bootstrap -->
    <link href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="../../resources/css/carousel.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap core JavaScript
     ================================================== -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../../vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            var menu = $('#nav');
            var origOffsetY = menu.offset().top;

            function scroll() {
                if ($(window).scrollTop() >= origOffsetY) {
                    $('#nav').addClass('navbar-fixed-top');
                } else {
                    $('#nav').removeClass('navbar-fixed-top');
                }


            }

            document.onscroll = scroll;

        });
    </script>
</head>
<body>

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
                            <li class="<?php echo ($this->getActiveMenuItem() == "home") ? "active" : ""; ?>"><a href="">Startseite</a></li>
                            <li class="<?php echo ($this->getActiveMenuItem() == "about") ? "active" : ""; ?>"><a href="../../index.php?controller=<?php echo AboutController::getIdentifier(); ?>">Die Künstlerin</a></li>
                            <li class="<?php echo ($this->getActiveMenuItem() == "news") ? "active" : ""; ?>"><a href="<?php echo NewsController::getIdentifier(); ?>">News</a></li>
                            <li class="<?php echo ($this->getActiveMenuItem() == "pictures") ? "active" : ""; ?>"><a href="<?php echo PicturesController::getIdentifier(); ?>">Gemälde</a></li>
                            <li class="<?php echo ($this->getActiveMenuItem() == "contact") ? "active" : ""; ?>"><a href="<?php echo ContactController::getIdentifier(); ?>">Kontakt</a></li>
                            <li class="<?php echo ($this->getActiveMenuItem() == "legalnotice") ? "active" : ""; ?>"><a href="<?php echo LegalnoticeController::getIdentifier(); ?>">Impressum</a></li>
                            </li>
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
                <div class="header-image" style="background-image: url('../../resources/img/header.JPG');"></div>
            </div>
            <div class="item">
                <!--<img class="second-slide" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Second slide">-->
                <div class="header-image" style="background-image: url('../../resources/img/header2.JPG');"></div>
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


    <?php echo $this->getContent(); ?>

    <!-- FOOTER -->
    <footer class="modal-footer">
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p class="pull-left">&copy; 2015 Hildes Bildergalerie &middot; Designed by Felix Blechschmitt &middot; <a href="#">Impressum</a> &middot; <a href="#">Login</a></p>
    </footer>

</div><!-- /.container -->
</body>
</html>