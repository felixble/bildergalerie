<?php

/**
 * View holding all information to display
 * a exception Text from an exception object.
 *
 * User: Felix
 * Date: 29.12.2015
 * Time: 20:06
 */
class ExceptionTextView extends View
{

    /**
     * The exception which should be displayed.
     *
     * @var Exception
     */
    private $exception;

    public function __construct($exception)
    {
        parent::__construct("includes/mvc_base/templates/exception_text");
        $this->exception = $exception;
    }

    /**
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }



}