<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 29.12.2015
 * Time: 20:47
 */
class UserPseudoDAO implements IUserDAO
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
    public function getValidUser($user, $pass)
    {
        return new User(new Mandant(47), "4711", $user, "Mustermann", "Max", "max@mustermann.de");
    }
}