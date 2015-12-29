<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 29.12.2015
 * Time: 20:39
 */
class ErrorHandler extends Exception
{

    protected $severity;

    public function __construct($message, $code, $severity, $filename, $lineno) {
        $this->message = $message;
        $this->code = $code;
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $lineno;
    }

    public function getSeverity() {
        return $this->severity;
    }

}