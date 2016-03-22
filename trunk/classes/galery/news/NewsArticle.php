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
     * @var id of the NewsArticle
     */
    private $id;
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
     * @param $owner User|null
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

    /**
     * @return id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param id $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    public function __construct($title, $content, $owner = null, $id = null)
    {
        $this->title=$title;
        $this->content=$content;
        $this->owner=$owner;
        $this->id=$id;
    }


}