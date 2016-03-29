<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 13.02.2016
 * Time: 23:58
 */
class LoginView extends View
{

    /**
     * Should a error message
     * be displayed?
     *
     * @var bool
     */
    private $failure;

    public function __construct($failure)
    {
        parent::__construct();
        $this->failure = $failure;
    }

    public function isFailure()
    {
        return $this->failure;
    }

    public function getCustomCSS()
    {
        return "login.css";
    }

}