<?php

namespace App\Picture\Create;

class Request
{
    /** @var string */
    public $title;

    /** * @var Tag[] */
    public $tags;

    /** @var string */
    public $descr;

    /** * @var string */
    public $material;

    /** @var \PicturePath */
    public $picPathId;

    public $picPath;
    public $picPathThumb;
    /**
     * @var int[]
     */
    public $categoryIds;

    /** @var \Mandant */
    public $mandant;

    /** @var \User */
    public $uploadedBy;

    /** @var \User */
    public $owner;

    /** @var bool */
    public $edit;

    /** @var int */
    public $editPicId;
}