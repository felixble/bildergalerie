<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 16.12.2015
 * Time: 16:50
 */

class ExceptionView extends View {

    private $exceptionName;
    private $exceptionText;

    public function __construct() {
        parent::__construct("includes/mvc_base/templates/exception");
    }

    /**
     * @return mixed
     */
    public function getExceptionName()
    {
        return $this->exceptionName;
    }

    /**
     * @param mixed $exceptionName
     */
    public function setExceptionName($exceptionName)
    {
        $this->exceptionName = $exceptionName;
    }

    /**
     * @return mixed
     */
    public function getExceptionText()
    {
        return $this->exceptionText;
    }

    /**
     * @param mixed $exceptionText
     */
    public function setExceptionText($exceptionText)
    {
        $this->exceptionText = $exceptionText;
    }


}