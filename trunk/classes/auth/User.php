<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.12.2015
 * Time: 18:23
 */
class User
{

    private $userId;
    private $username;
    private $name;
    private $first_name;
    private $email;

    /**
     * User constructor.
     * @param $userId
     * @param $username
     * @param $name
     * @param $first_name
     * @param $email
     */
    public function __construct($userId, $username, $name, $first_name, $email)
    {
        $this->userId = $userId;
        $this->username = $username;
        $this->name = $name;
        $this->first_name = $first_name;
        $this->email = $email;
    }


    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     * @return User
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return User
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }



}