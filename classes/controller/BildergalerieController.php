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
     * @var \App\Application
     */
    protected $application;

    public function __construct()
    {
        parent::__construct();
    }

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        if ($router instanceof AppRouter) {
            $this->baseFactory = $router->getBaseFactory();
            $this->application = new WebApplication($this->baseFactory);
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

    /**
     * Gets the value of the given key in
     * the given attribute or null if the array
     * does not contain such a key.
     *
     * @param $key
     * @param $search
     * @return null|string value of the key or null if the array
     *                     does not contain such a key.
     */
    public static function getValueOrNull($key, $search)
    {
        return (array_key_exists($key, $search)) ? $search[$key] : null;
    }

}