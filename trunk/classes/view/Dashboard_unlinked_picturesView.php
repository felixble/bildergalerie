<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.03.16
 * Time: 18:19
 */
class Dashboard_unlinked_picturesView extends View
{

    /**
     * @var PicturePath[]
     */
    private $picturePathes;

    /**
     * Dashboard_unlinked_picturesView constructor.
     * @param PicturePath[] $picturePathes
     */
    public function __construct(array $picturePathes)
    {
        parent::__construct();
        $this->picturePathes = $picturePathes;
    }


    /**
     * @return PicturePath[]
     */
    public function getPicturePathes()
    {
        if (null == $this->picturePathes) return array();

        return $this->picturePathes;
    }


    public function getCustomCSS()
    {
        return "pinterest_style.css";
    }
}