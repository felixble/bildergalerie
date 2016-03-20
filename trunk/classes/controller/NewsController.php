<?php

/**
 * Created by PhpStorm.
 * User: masolinguist
 * Date: 16.03.2016
 * Time: 16:18
 */
class NewsController extends BildergalerieController
{

    /**
     * Default action which will be executed
     * if no specific action is given.
     *
     * Each action returns the {@link View}
     * which will be displayed.
     *
     * @return View
     */
    public function indexAction()
    {
        $newsView = new NewsView();
        $isLoggedIn = (null != $this->baseFactory->getAuthenticator()->getLoggedInUser());

        if ($isLoggedIn){
            $post_view = new Post_newsView();
            $newsView->setPostView($post_view);
        }
        return $this->getContentFrameView("News und Informationen", $newsView);
    }

    public function createAction ()
    {
        $post = $this->getRequest()->getPostParam();
        $title = $this->getValueOrNull("title", $post);
        $content = $this->getValueOrNull("content", $post);

        $NewsArcticle = new NewsArticle($title,$content);

    }
}