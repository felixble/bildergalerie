<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 11.02.16
 * Time: 23:56
 */
interface IUser
{

    /**
     * @return mixed
     */
    public function getUserId();

    /**
     * @param mixed $userId
     * @return User
     */
    public function setUserId($userId);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getLastName();

    /**
     * @param string $name
     * @return User
     */
    public function setLastName($name);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @param string $first_name
     * @return User
     */
    public function setFirstName($first_name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email);

}