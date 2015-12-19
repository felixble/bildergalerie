<?php
/** @var BootstrapView $this */

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $this->getTitle() ?></title>
    <base href="<?php echo MvcConfig::getInstance()->getBasePath(); ?>">
    <!-- Bootstrap -->
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <?php
    echo HtmlHelper::linkCSS("resources/css/carousel.css");
    if (null != $this->getCSS()) {
        echo HtmlHelper::linkCSS("resources/css/" . $this->getCSS());
    }

    echo $this->getAdditionalHeader();
    ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<?php echo $this->getBodyContent(); ?>

<!-- Bootstrap core JavaScript
 ================================================== -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>


<?php
if (null != $this->getJS()) {
echo HtmlHelper::scriptJS("resources/js/" . $this->getJS());
}
echo $this->getContentPastJs();
?>

</body>
</html>