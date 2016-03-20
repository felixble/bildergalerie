<?php

/**
 * Created by PhpStorm.
 * User: masolinguist
 * Date: 16.03.2016
 * Time: 16:25
 */
class NewsView extends View
{

    /**
     * @var NewsArticle[]
     */
    private $newsArticles;

    /**
     * @return NewsArticle[]
     */
    public function getNewsArticles()
    {
        if (null==$this->newsArticles){
            return array();
        }
        return $this->newsArticles;
    }

    /**
     * @param NewsArticle[] $newsArticles
     */
    public function setNewsArticles($newsArticles)
    {
        $this->newsArticles = $newsArticles;
    }

    /**
     * @var Post_newsView
     */
    private $postView=null;

    /**
     * @param Post_newsView $postView
     */
    public function setPostView(Post_newsView $postView)
    {
        $this->postView = $postView;
    }

    /**
     * @return Post_newsView
     */
    public function getPostView()
    {
        return $this->postView;
    }


}

