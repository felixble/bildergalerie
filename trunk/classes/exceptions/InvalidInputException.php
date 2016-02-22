<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.02.16
 * Time: 10:01
 */
class InvalidInputException extends UserException
{

    private $fieldName;
    private $input;

    /**
     * InvalidInputException constructor.
     * @param string $fieldName
     * @param string $input
     */
    public function __construct($fieldName, $input = "")
    {
        parent::__construct(sprintf("The Input \"%s\" for field \"%s\" is invalid.", $input, $fieldName));
        $this->fieldName = $fieldName;
        $this->input = $input;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getInput()
    {
        return $this->input;
    }


}