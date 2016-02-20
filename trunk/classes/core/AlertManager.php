<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.02.16
 * Time: 12:50
 */
class AlertManager
{
    const KEY_ALERT_TYPE = "alert_type";
    const KEY_ALERT_MESSAGE = "alert_msg";

    /**
     * @var \Aura\Session\Segment
     */
    private $alertSegment;

    public function __construct(SessionManager $sessionManager)
    {
        $this->alertSegment = $sessionManager->getAlertSegment();
    }

    public function setSuccessMessage($message)
    {
        $this->alertSegment->set(self::KEY_ALERT_TYPE, BootstrapHelper::$ALERT_SUCCESS);
        $this->alertSegment->set(self::KEY_ALERT_MESSAGE, $message);
    }

    public function hasAlertMessage()
    {
        return (null != $this->getAlertType());
    }

    public function getAlertType()
    {
        return $this->alertSegment->get(self::KEY_ALERT_TYPE);
    }

    public function getAlertMessage()
    {
        return $this->alertSegment->get(self::KEY_ALERT_MESSAGE);
    }

    public function reset()
    {
        $this->alertSegment->clear();
    }

}