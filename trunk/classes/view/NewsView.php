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

