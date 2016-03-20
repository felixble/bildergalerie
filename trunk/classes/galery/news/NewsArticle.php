<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 20.03.2016
 * Time: 16:06
 */
class NewsArticle
{
    /**
     * @var title of the NewsArticle
     */
    private $title;

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param $owner User
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
    /**
     * @var content of the NewsArticle
     */
    private $content;

    /**
     * @var owner of the NewsArticle
     */
    private $owner;
    /**
     * @return title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param title $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param content $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


    public function __construct($title, $content, $owner)
    {
        $this->title=$title;
        $this->content=$content;
        $this->owner=$owner;
    }
}