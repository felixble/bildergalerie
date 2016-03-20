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
     * @var NewsDAO
     */
    private $newsDAO;
    /**
     * @var Mandant
     */
    private $mandant;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->newsDAO = new NewsDAO($this->baseFactory->getDbConnection(), $this->mandant);
    }
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
        $owner = $this->baseFactory->getAuthenticator()->getLoggedInUser();


        $newsArticle = new NewsArticle($title,$content,$owner);
        $success = $this->newsDAO->createArticle($newsArticle);

        if($success){
            $this->getAlertManager()->setSuccessMessage("<strong>Super!</strong> Der Artikel wurde erfolgreich gespeichert.");
        }else {
            $this->getAlertManager()->setErrorMessage("<strong>Fehler!</strong> Der Artikel konnte nicht gespeichert werden.");
        }
        $this->getRouter()->reLocateTo("news");

    }

}