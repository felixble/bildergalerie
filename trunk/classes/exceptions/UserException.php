<?php

/**
 * Base class for all failures sitting
 * 40cm in front of the screen.
 *
 * User: felix
 * Date: 22.02.16
 * Time: 12:36
 */
class UserException extends Exception
{

    public function __construct($message = "", $errorCode = 0, Exception $previous = null)
    {
        parent::__construct($message, $errorCode, $previous);
    }

}