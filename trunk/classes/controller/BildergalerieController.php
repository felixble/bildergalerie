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

    /**
     * @var ControllerAnnotationParser
     */
    private $annotationParser;

    public function __construct()
    {
        $this->annotationParser = new ControllerAnnotationParser($this);
    }

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        if ($router instanceof AppRouter) {
            $this->baseFactory = $router->getBaseFactory();
        } else {
            throw new IllegalStateException("Router must be an instance of AppRouter.");
        }
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
        if ($content instanceof View) {
            $view->addCSS($content->getCustomCSS());
        }

        return $view;
    }

    /**
     * @return ControllerAnnotationParser
     */
    public function getAnnotationParser()
    {
        return $this->annotationParser;
    }

}