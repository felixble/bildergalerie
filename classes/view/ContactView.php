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


    private $post;

    /**
     * @var string title
     */
    private $title;

    /**
     * @var Picture
     */
    private $picture;

    /**
     * ContactView constructor.
     * @param $post
     */
    public function __construct($post = null)
    {
        parent::__construct(null);
        $this->post = $post;
    }


    /**
     * @return string
     */
    public function getPicId()
    {
        if ($this->picture == null) return "";
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

    public function getPostOrEmpty($key) {
        if ($this->post == null) return "";
        $value = BildergalerieController::getValueOrNull($key, $this->post);
        return ($value == null) ? "" : $value;
    }

    public function getSubjectValue()
    {
        $postSubject = $this->getPostOrEmpty('subject');
        if (!empty($postSubject)) {
            return $postSubject;
        }

        if (null == $this->picture) return "";

        return "Anfrage zum Gemälde " . $this->getPicture()->getTitle();
    }

    public function getCustomJS()
    {
        return ["https://www.google.com/recaptcha/api.js", "recaptcha_enable_submit.js"];
    }


}