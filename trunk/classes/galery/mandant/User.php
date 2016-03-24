<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.12.2015
 * Time: 18:23
 */
class User implements IUser
{

    /**
     * @var Mandant
     */
    private $mandant;
    private $userId;
    private $username;
    private $last_name;
    private $first_name;
    private $email;
    private $lastlogin;
    private $registeredDate;

    /**
     * User constructor.
     *
     * @param Mandant $mandant
     * @param $userId string
     * @param $username string
     * @param $last_name string
     * @param $first_name string
     * @param $email string
     * @param null|string $lastlogin
     * @param null|string $registeredDate
     */
    public function __construct(Mandant $mandant, $userId, $username, $last_name, $first_name, $email,
                                $lastlogin = null, $registeredDate = null
    ) {
        $this->mandant = $mandant;
        $this->userId = $userId;
        $this->username = $username;
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->email = $email;
        // TODO: lastlogin / registeredDate
    }

    /**
     * @return Mandant
     */
    public function getMandant()
    {
        return $this->mandant;
    }

    /**
     * @param Mandant $mandant
     * @return User
     */
    public function setMandant($mandant)
    {
        $this->mandant = $mandant;
        return $this;
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
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return User
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
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

    /**
     * @return DateTime
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * @param DateTime $lastlogin
     * @return User
     */
    public function setLastlogin($lastlogin)
    {
        $this->lastlogin = $lastlogin;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getRegisteredDate()
    {
        return $this->registeredDate;
    }

    /**
     * @param DateTime $registeredDate
     * @return User
     */
    public function setRegisteredDate($registeredDate)
    {
        $this->registeredDate = $registeredDate;
        return $this;
    }

    public function __toString()
    {
        return $this->first_name." ".$this->last_name;
    }

}