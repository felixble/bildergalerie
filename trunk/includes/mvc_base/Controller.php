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

    private $request;

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
     * it will be passed to the controller.
     *
     * @param Request $request
     */
    public function onCreate(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
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
