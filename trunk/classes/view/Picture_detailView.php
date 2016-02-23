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

    public function __construct(Picture $picture)
    {
        parent::__construct(null);
        $this->picture = $picture;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

}