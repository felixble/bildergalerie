<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.12.2015
 * Time: 18:16
 */
class Authenticator
{

    /**
     * @var IUserDAO
     */
    private $userDAO;

    /**
     * @var UserSessData
     */
    private $userSessData;

    /**
     * Authenticator constructor.
     * @param $userDAO IUserDAO
     * @param $sessManager SessionManager
     */
    public function __construct($userDAO, $sessManager)
    {
        $this->userDAO = $userDAO;
        $this->userSessData = new UserSessData($sessManager);
    }

    /**
     * Checks if the session holds information
     * about an authenticated user.
     */
    private function isAuthenticatedViaSession()
    {
        $sessUser = $this->userSessData->getUser();
        return (null != $sessUser);
    }

    public function authenticate($user, $pass)
    {
        $user = $this->userDAO->getValidUser($user, $pass);
        if (null == $user) {
            return false;
        }

        $this->userSessData->storeUser($user);

        return true;
    }

    /**
     * Checks if a user is currently
     * logged in.
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->isAuthenticatedViaSession();
    }

    public function logout()
    {
        $this->userSessData->destroySession();
    }

    /**
     * Gets the authenticated user.
     *
     * @return User current user or null, iff there
     *          is no user currently authenticated.
     */
    public function getLoggedInUser()
    {
        return $this->userSessData->getUser();
    }

}