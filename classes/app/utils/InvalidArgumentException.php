<?php


namespace App\Utils;


use Exception;

class InvalidArgumentException extends Exception
{

    /**
     * InvalidArgumentException constructor.
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}