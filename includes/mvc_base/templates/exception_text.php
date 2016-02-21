<?php
/** @var $this ExceptionTextView @var $e Exception */
$e = $this->getException();
?>

<code><?php echo $e->getMessage(); ?></code><br>
Code: <?php echo $e->getCode(); ?><br>
File: <?php echo $e->getFile(); ?><br>
Line: <?php echo $e->getLine(); ?><br>
<?php if (strpos($_SERVER['HTTP_HOST'], "localhost")): ?>
<pre> <?php echo $e->getTraceAsString(); ?></pre>
<?php endif; ?>
