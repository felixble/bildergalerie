<?php


namespace App\Utils;


use Exception;

class NotAuthorizedException extends Exception
{

    public function __construct()
    {
        parent::__construct("You must be authorized to perform this action");
    }
}