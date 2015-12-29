<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.12.2015
 * Time: 18:28
 */
class NotImplementedException extends Exception
{

    public function __construct($message = "", Exception $previous = null)
    {
        parent::__construct($message, ErrorCodes::$_NOT_IMPLEMENTED, $previous);
    }

}