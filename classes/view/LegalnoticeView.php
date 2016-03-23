<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 23.03.2016
 * Time: 13:37
 */
class LegalnoticeView extends View
{
    const NAME = "Hilde Blechschmitt";
    const EMAIL = "hilde@blechschmitt.name";
    const MANDANT = "Hildes Bildergalerie";
    const ADDRESS = "Dr Schierstraße 3";
    const ZIPCODE = "66386";
    const CITY = "St. Ingbert";

    /**
     * @var name
     */
    private $name;
    /**
     * @var email
     */
    private $email;
    /**
     * @var mandant
     */
    private $mandant;
    /**
     * @var address
     */
    private $address;
    /**
     * @var zipcode
     */
    private $zipcode;
    /**
     * @var city
     */
    private $city;

    /**
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param name $name
     */
    public function setName($name)
    {
        $this->name = self::NAME;
    }

    /**
     * @return zipcode
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param zipcode $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = self::ZIPCODE;
    }

    /**
     * @return city
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param city $city
     */
    public function setCity($city)
    {
        $this->city = self::CITY;
    }

    /**
     * @return address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param address $address
     */
    public function setAddress($address)
    {
        $this->address = self::ADDRESS;
    }

    /**
     * @return mandant
     */
    public function getMandant()
    {
        return $this->mandant;
    }

    /**
     * @param mandant $mandant
     */
    public function setMandant($mandant)
    {
        $this->mandant = self::MANDANT;
    }

    /**
     * @return email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param email $email
     */
    public function setEmail($email)
    {
        $this->email = self::EMAIL;
    }



}