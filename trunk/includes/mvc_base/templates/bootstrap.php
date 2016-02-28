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

    <!-- Custom Font TODO: make this customizable -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>


    <?php if($this->enableJQueryUI()): ?>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <?php endif; ?>

    <?php
    if (null != $this->getCSS() && is_array($this->getCSS())) {
        foreach ($this->getCSS() as $css) {
            if (!empty($css)) echo HtmlHelper::linkCSS("resources/css/" . $css);
        }
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

<?php if($this->enableJQueryUI()): ?>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<?php endif; ?>


<?php
if (null != $this->getJS() && is_array($this->getJS())) {
    foreach ($this->getJS() as $js) {
        if (!empty($js)) echo HtmlHelper::scriptJS("resources/js/" . $js);
    }
}

echo $this->getContentPastJs();
?>

</body>
</html>