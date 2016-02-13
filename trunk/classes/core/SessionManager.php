<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 27.12.2015
 * Time: 16:47
 */
class SessionManager
{
    const USER_SEGMENT = "Bildergalerie_User_Information";
    const MANDANT_SEGMENT = "Bildergalerie_Mandant_Information";

    /**
     * Holds the session object.
     *
     * @var Aura\Session\Session
     */
    private $session;

    /**
     * SessionManager constructor.
     * @param $cookies array
     */
    public function __construct($cookies)
    {
        $sess_factory = new Aura\Session\SessionFactory();
        $this->session = $sess_factory->newInstance($cookies);
    }

    public function getUserSegment()
    {
        return $this->session->getSegment(self::USER_SEGMENT);
    }

    public function getMandantSegment()
    {
        return $this->session->getSegment(self::MANDANT_SEGMENT);
    }


}