<?php
/**
 * Default Exception View which can display
 * an occurred error.
 *
 * User: Felix
 * Date: 16.12.2015
 * Time: 16:50
 */

class ExceptionView extends View {

    /**
     * Name of the thrown exception.
     *
     * @var string
     */
    private $exceptionName;

    /**
     * Text which should be displayed.
     *
     * @var string
     */
    private $exceptionText;

    public function __construct() {
        parent::__construct("includes/mvc_base/templates/exception");
    }

    /**
     * Gets the name of the exception which should
     * be displayed.
     *
     * @return string
     */
    public function getExceptionName()
    {
        return $this->exceptionName;
    }

    /**
     * Sets the name of the exception which should
     * be displayed.
     *
     * @param string $exceptionName
     */
    public function setExceptionName($exceptionName)
    {
        $this->exceptionName = $exceptionName;
    }

    /**
     * Gets the text of the exception which
     * should be displayed.
     * <br>
     * This could also be a view because of the
     * magic toString-Method.
     *
     * @return mixed
     */
    public function getExceptionText()
    {
        return $this->exceptionText;
    }

    /**
     * Sets the text of the exception which
     * should be displayed.
     * <br>
     * This could also be a view because of the
     * magic toString-Method.
     *
     * @param mixed $exceptionText
     */
    public function setExceptionText($exceptionText)
    {
        $this->exceptionText = $exceptionText;
    }

    /**
     * @param $exception Exception
     */
    public function setInfosFromException($exception)
    {
        $this->setExceptionName(get_class($exception));
        $this->setExceptionText(new ExceptionTextView($exception));
    }

}