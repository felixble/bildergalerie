<?php
/** @var ExceptionView $this */
?>
<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $this->getExceptionName() ?></h3>
    </div>
    <div class="panel-body">
        <?php echo $this->getExceptionText() ?>
    </div>
</div>