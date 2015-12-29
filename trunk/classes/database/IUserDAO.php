<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.12.2015
 * Time: 18:20
 */
interface IUserDAO
{

    /**
     * Returns the user identified by the username
     * or {@code null} iff the password does not match
     * or the user does not exists.
     *
     * @param $user string username
     * @param $pass string password
     * @return User
     */
    public function getValidUser($user, $pass);

}