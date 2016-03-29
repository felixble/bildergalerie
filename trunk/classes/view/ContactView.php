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
     * @var Picture
     */
    private $picture;

    /**
     * @return string
     */
    public function getPicId()
    {
        return $this->picture->getPictureId();
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getPictureDetails ()
    {
        if (null == $this->picture) return "";
        $pictureDetails = self::PICTUREURL . $this->getPicId();
        return $pictureDetails;
    }

    /**
     * @param Picture $picture
     */
    public function setPicture(Picture $picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function getSubjectValue()
    {
        if (null == $this->picture) return "";

        return "Anfrage zum Gemälde " . $this->getPicture()->getTitle();
    }

}