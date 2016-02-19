<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 20:13
 */
class IllegalArgumentException extends Exception
{

    /**
     * IllegalArgumentException constructor.
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}