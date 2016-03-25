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
     * @param string $fieldName or free text
     * @param string $input
     * @param bool $freeText
     */
    public function __construct($fieldName, $input = "", $freeText = false)
    {
        parent::__construct(($freeText) ? $fieldName : sprintf("Die Eingabe \"%s\" im Feld \"%s\" ist ungültig.", $input, $fieldName));
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