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
    const ALERT_SEGMENT = "Bildergalerie_Alert";
    const FLASH_SEGMENT = "Bildergalerie_FlashSegment";
    const KEY_BACKTO = "backto";
    const SESS_LIFETIME = 1800; // 30 min

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
        $this->session->setCookieParams(array('lifetime' => self::SESS_LIFETIME));
    }

    public function getUserSegment()
    {
        return $this->session->getSegment(self::USER_SEGMENT);
    }

    public function getMandantSegment()
    {
        return $this->session->getSegment(self::MANDANT_SEGMENT);
    }

    /**
     * @return \Aura\Session\Segment
     */
    public function getAlertSegment()
    {
        return $this->session->getSegment(self::ALERT_SEGMENT);
    }

    private function getFlashSegment()
    {
        return $this->session->getSegment(self::FLASH_SEGMENT);
    }

    public function setBackTo($backTo)
    {
        $this->setFlash("backto", $backTo);
    }

    public function getBackTo($refresh = false)
    {
        return $this->getFlash("backto", $refresh);
    }

    public function setFlash($key, $value)
    {
        $flashSegment = $this->getFlashSegment();
        $flashSegment->setFlash($key, $value);
    }

    public function getFlash($key, $refresh = false)
    {
        $value = $this->getFlashSegment()->getFlash($key);
        if ($refresh) {
            $this->setFlash($key, $value);
        }
        return $value;
    }


}