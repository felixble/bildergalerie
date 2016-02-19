<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 09:07
 */
class FileAlreadyExists extends Exception
{

    /**
     * FileAlreadyExists constructor.
     * @param $fileName
     */
    public function __construct($fileName)
    {
        parent::__construct(sprintf("The file %s already exists.", $fileName));
    }
}