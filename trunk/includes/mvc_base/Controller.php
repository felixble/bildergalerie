<?php

/**
 * Description of Controller
 *
 * @author Felix
 */
abstract class Controller {

    private $request;


    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    public abstract function indexAction();


}
