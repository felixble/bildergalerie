<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 09:20
 */
class FileIsNotAnImage extends Exception
{

    /**
     * FileIsNotAnImage constructor.
     * @param $fileName
     */
    public function __construct($fileName)
    {
        parent::__construct(sprintf("The file %s is not an image.", $fileName));
    }
}