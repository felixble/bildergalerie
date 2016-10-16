<?php

/**
 * Controller to handle all news actions.
 *
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

    /**
     * @var NewsArticle
     */
    private $currentArticle = null;

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

        if ($isLoggedIn) {
            $post_view = new Post_newsView();
            if (null != $this->currentArticle) {
                $post_view->setArticle($this->currentArticle);
            }
            $newsView->setPostView($post_view);
            $newsView->setIsUserLoggedIn(true);
        }

        $newsArticles = $this->newsDAO->getArticles();
        $newsView->setNewsArticles($newsArticles);

        return $this->getContentFrameView("Aktuelles", $newsView);
    }

    /**
     * @AuthRequired
     */
    public function createAction()
    {

        $post = $this->getRequest()->getPostParam();
        $newsArticle = $this->buildArticle($post);
        if(null!=$newsArticle->getId()){
            $this->newsDAO->updateArticle($newsArticle);
            $success = true; // update returns false iff nothing has been update, but this is not an error.
        }else {
            $success = $this->newsDAO->createArticle($newsArticle);
        }


        if ($success) {
            $this->getAlertManager()->setSuccessMessage("<strong>Super!</strong> Der Artikel wurde erfolgreich gespeichert.");
        } else { // no success means nothing as been updates
            $this->getAlertManager()->setErrorMessage("<strong>Fehler!</strong> Der Artikel konnte nicht gespeichert werden.");
        }
        $this->getRouter()->reLocateTo("news");

    }

    /**
     * @throws Exception
     * @throws SimpleUserErrorException
     * @AuthRequired
     */
    public function deleteAction()
    {
        $deleteArticleId = $this->getIdRequestParam("id", /* throw exception if not given */
            true);

        $this->newsDAO->deleteArticle($deleteArticleId);

        $this->getAlertManager()->setSuccessMessage("<strong>OK:</strong> Der Artikel wurde erfolgreich entfernt.");
        $this->getRouter()->reLocateTo("news");

    }

    private function getIdRequestParam($key, $throwExceptionIfNotGiven = false)
    {
        $get = $this->getRequest()->getGetParam();
        if (array_key_exists($key, $get)) { // if we have the get param id its easy...
            return $get[$key];
        } elseif (count($this->getRequest()->getQueryParams()) > 0) { // otherwise, our first parameter key is our id
            return $this->getRequest()->getQueryParams()[0];
        }

        if ($throwExceptionIfNotGiven) {
            throw new SimpleUserErrorException("Der Artikel wurde nicht gefunden.");
        }

        return false;
    }

    public function updateAction()
    {
        try {
            $updateArticleId = $this->getIdRequestParam("id", /* throw exception if not given */true);
            $newsArticle = $this->newsDAO->getArticleById($updateArticleId);
            if (null == $newsArticle) {
                throw new SimpleUserErrorException("Der Beitrag wurde nicht gefunden.");
            }
            $this->currentArticle = $newsArticle;
        } catch(UserException $e) {
            // we cannot throw an exception because the news articles should be shown, though.
            $this->getAlertManager()->setErrorMessage("<strong>Fehler!</strong> " . $e->getMessage());
        }

        return $this->indexAction();


    }

    private function buildArticle($post)
    {
        $title = self::getValueOrNull("title", $post);
        $content = self::getValueOrNull("content", $post);
        $owner = $this->baseFactory->getAuthenticator()->getLoggedInUser();
        $id = self::getValueOrNull("edit_id",$post);

        return new NewsArticle($title, $content, $owner, $id);
    }

}