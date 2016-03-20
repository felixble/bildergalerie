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
     * @var content of the news article
     */
    private $content;

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


    public function __construct($title, $content)
    {
        $this->title=$title;
        $this->content=$content;
    }
}