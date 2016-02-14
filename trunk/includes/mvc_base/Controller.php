<?php

/**
 * Base Controller class.
 *
 * Each controller must handle at
 * least one action, the indexAction.
 *
 * @author Felix
 */
abstract class Controller {

    /**
     * @var Router
     */
    private $router;

    /**
     * Creates a new Controller.
     * A controller will only be instantiated
     * by the {@link Router}-Class.
     */
    public function __construct()
    {
    }

    /**
     * After building the Request-Object
     * the Router will be passed to the controller.
     *
     * @param Router $router
     */
    public function onCreate(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->router->getRequest();
    }

    /**
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Default action which will be executed
     * if no specific action is given.
     *
     * Each action returns the {@link View}
     * which will be displayed.
     *
     * @return View
     */
    public abstract function indexAction();


}
