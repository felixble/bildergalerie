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

    public function __construct()
    {
        parent::__construct();
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

        // add alert message
        $alertManager = $this->getAlertManager();
        if ($alertManager->hasAlertMessage()) {
            $contentView->setAlert($alertManager->getAlertType(), $alertManager->getAlertMessage());
        }
        $alertManager->reset();

        // add current user, iff available
        $contentView->setCurrentUser($this->baseFactory->getAuthenticator()->getLoggedInUser());

        $view = BootstrapView::getContentFrameView($fullTitle, $contentView);
        if ($content instanceof View) {
            $view->addCSS($content->getCustomCSS());
            $view->addJS($content->getCustomJS());
        }

        return $view;
    }

    public function getAlertManager()
    {
        return new AlertManager($this->baseFactory->getSessionManager());;
    }

}