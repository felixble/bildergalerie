<?php

/**
 * Base Controller for our Bildergalerie-Application.
 *
 * User: Felix
 * Date: 30.12.2015
 * Time: 12:15
 */
abstract class BildergalerieController extends Controller
{

    /**
     * @var BaseFactory
     */
    protected $baseFactory;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->baseFactory = new BaseFactory($router->getRequest());
    }

    public function getContentFrameView($title, $content, $showCarousel = true)
    {
        $titlePrefix = $this->baseFactory->getMandantManager()->getMandant()->getPageTitle();

        $fullTitle = $titlePrefix . " - " . $title;

        $contentView = new Content_frameView($titlePrefix, $title);
        $contentView->setContent($content);
        $contentView->setShowCarousel($showCarousel);

        $view = BootstrapView::getContentFrameView($fullTitle, $contentView);
        $view->setJS("global.js");

        return $view;
    }

}