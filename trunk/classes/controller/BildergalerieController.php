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

    /**
     * @return AppRouter
     */
    public function getRouter()
    {
        return parent::getRouter();
    }

    public function getContentFrameView($title, $content, $showCarousel = true)
    {
        return $this->getRouter()->getContentFrameView($title, $content, $showCarousel);
    }

    public function getAlertManager()
    {
        return $this->getRouter()->getAlertManager();
    }

}