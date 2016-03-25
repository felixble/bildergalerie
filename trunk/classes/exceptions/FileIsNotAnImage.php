<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 09:20
 */
class FileIsNotAnImage extends UserException
{

    /**
     * FileIsNotAnImage constructor.
     * @param $fileName
     */
    public function __construct($fileName)
    {
        parent::__construct(sprintf("Die Datei %s ist kein Bild.", $fileName));
    }
}