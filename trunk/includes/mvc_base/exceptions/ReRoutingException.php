<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.02.2016
 * Time: 10:49
 */
class ReRoutingException extends Exception
{

    /**
     * @var array
     */
    private $reRouteStack;

    /**
     * ReRoutingException constructor.
     * @param array $reRouteStack
     */
    public function __construct($reRouteStack)
    {
        parent::__construct("Re-routing loop occurred!");
        $this->reRouteStack = $reRouteStack;
    }

    /**
     * @return array
     */
    public function getReRouteStack()
    {
        return $this->reRouteStack;
    }

}