<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 24.03.2016
 * Time: 12:10
 */
class Dashboard_news_tableView extends View
{
    /**
     * @var null|NewsArticle[]
     */
    private $newsArticles;

    /**
     * @return NewsArticle[]|null
     */
    public function getNewsArticles()
    {
        return $this->newsArticles;
    }

    /**
     * @param NewsArticle[]|null $newsArticles
     */
    public function setNewsArticles($newsArticles)
    {
        $this->newsArticles = $newsArticles;
    }

    /**
     * Dashboard_news_tableView constructor.
     * @param null|NewsArticle[] $newsArticles
     */
    public function __construct($newsArticles)
    {
        parent::__construct();
        $this->setNewsArticles($newsArticles);
    }
}