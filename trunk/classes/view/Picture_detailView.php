<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.02.2016
 * Time: 19:52
 */
class Picture_detailView extends View
{

    /**
     * @var Picture
     */
    private $picture;

    /**
     * @var null|string
     */
    private $backTo;

    public function __construct(Picture $picture, $backTo = null)
    {
        parent::__construct(null);
        $this->picture = $picture;
        $this->backTo = $backTo;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function getBackTo()
    {
        return $this->backTo;
    }

}