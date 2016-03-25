<?php

/**
 * Created by PhpStorm.
 * User: masolinguist
 * Date: 16.03.2016
 * Time: 17:27
 */
class Post_newsView extends View
{

    /**
     * @var NewsArticle
     */
    private $article = null;

    /**
     * @return NewsArticle
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param NewsArticle $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }


    public function getTitle()
    {
        return (null==$this->article) ? "" : $this->getArticle()->getTitle();
    }

    public function getContent(){
        return (null==$this->article) ? "" : $this->getArticle()->getContent();
    }

    public function getID()
    {
        return (null==$this->article) ? "" : $this->getArticle()->getId();
    }

    public function isEditMode()
    {
        return null != $this->article;
    }
}