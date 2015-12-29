<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.12.2015
 * Time: 18:27
 */
class BaseFactory
{

    /**
     * @var SessionManager
     */
    private $sessionManager;

    /**
     * BaseFactory constructor.
     *
     * @param $cookies array
     */
    public function __construct($cookies)
    {
        $this->sessionManager = new SessionManager($cookies);
    }

    public function getSessionManager()
    {
        return $this->sessionManager;
    }

    public function getUserDAO()
    {
        return new UserPseudoDAO();
        //throw new NotImplementedException("#getUserDAO() in BaseFactory not yet implemented.");
    }

}