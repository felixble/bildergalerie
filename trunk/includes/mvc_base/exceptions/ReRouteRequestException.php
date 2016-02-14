<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 14.02.2016
 * Time: 18:55
 */
class ReRouteRequestException extends Exception
{

    private $controller;
    private $action;

    /**
     * ReRouteRequestException constructor.
     * @param $controller
     * @param $action
     */
    public function __construct($controller, $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }

}