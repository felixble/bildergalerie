<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 23.03.2016
 * Time: 11:15
 */
class ContactView extends View

{
    const PICTUREURL = "/bildergalerie/pictures/pic/id/";



    /**
     * @var string title
     */
    private $title;

    /**
     * @var string picId
     */
    private $picId;

    /**
     * @param string $picId
     */
    public function setPicId($picId)
    {
        $this->picId = $picId;
    }

    /**
     * @return string
     */
    public function getPicId()
    {
        return $this->picId;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getPictureDetails (){
        $pictureDetails = self::PICTUREURL.$this->getPicId();
        return $pictureDetails;
    }

}