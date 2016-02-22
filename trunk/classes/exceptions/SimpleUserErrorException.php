<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.02.2016
 * Time: 20:26
 */
class SimpleUserErrorException extends UserException
{

    public function __construct($message = "", $errorCode = 0, Exception $previous = null)
    {
        parent::__construct($message, $errorCode, $previous);
    }

}