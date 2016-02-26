<?php /** @var HomeView $this */ ?>

<!-- Three columns of text below the carousel -->
<div class="row">
    <div class="col-lg-4">
        <img class="img-circle" src="resources/img/hilde_galery.jpg" alt="Hildes Galery" width="140" height="140">
        <h2>Galerie</h2>
        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies
            vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus
            magna.</p>
        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
        <img class="img-circle" src="resources/img/hilde_profile.jpg" alt="Hilde, Die Künstlerin" width="140"
             height="140">
        <h2>Die Künstlerin</h2>
        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis
            consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum
            nibh.</p>
        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
    <div class="col-lg-4">
        <img class="img-circle" src="resources/img/hilde_news.jpg" alt="Hildes News" width="140" height="140">
        <h2>News</h2>
        <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta
            felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum
            massa justo sit amet risus.</p>
        <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
    </div><!-- /.col-lg-4 -->
</div><!-- /.row -->


<!-- Category TEASERS to introduce the most popular categories -->


<?php $i = 0; foreach ($this->getCatTeaser() as $catTeaser): /** @var CategoryTeaser $catTeaser */ ?>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-md-7 <?php if ( ($i % 2) != 0 ) echo "col-md-push-5"; ?>">
            <h2 class="featurette-heading">Ausstellung <span
                    class="text-muted"><?php echo $catTeaser->getName(); ?></span></h2>
            <p class="lead"><?php echo $catTeaser->getDescription(); ?></p>
        </div>
        <div class="col-md-5 <?php if ( ($i % 2) != 0 ) echo "col-md-pull-7"; ?>">
            <img class="featurette-image img-responsive center-block" height="500"
                 src="<?php echo $catTeaser->getPictureThumb(); ?>"
                 alt="<?php echo $catTeaser->getTitle(); ?>">
        </div>
    </div>
<?php $i++; endforeach; ?>


<!-- /END THE TEASERS -->
