<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.02.16
 * Time: 15:01
 *
 * @AuthRequired
 */
class BackendController extends BildergalerieController
{

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * @var CategoryDAO
     */
    private $categoryDAO;

    /**
     * @var NewsDAO
     */
    private $newsDAO;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->categoryDAO = new CategoryDAO($this->baseFactory->getDbConnection(), $this->mandant);
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
        // TODO: Implement indexAction() method.
        $this->getRouter()->reRouteTo("backend", "dashboard");
    }

    public function dashboardAction()
    {
        $dashboardView = new DashboardView();

        //fetch all newsArticles
        $newsArticles = $this->newsDAO->getArticles();
        $dashboardView->setNewsTableView(new Dashboard_news_tableView($newsArticles));

        // fetch all exhibitions
        $categories = $this->categoryDAO->getAllCategories();
        $dashboardView->setCategories($categories);

        // fetch all unlinked picture pathes
        $picturePathDAO = new PicturePathDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $unlinkedPicPathes = $picturePathDAO->getUnlinkedPathes();
        if (count($unlinkedPicPathes) > 0) {
            $dashboardView->setUnlinkedPicturesView(new Dashboard_unlinked_picturesView($unlinkedPicPathes));
        }

        // fetch all pictures
        $picDAO = new PictureDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $pictureTableView = $picDAO->getPicturesFromCategory(-1, true);
        if (count($pictureTableView) > 0) {
            $dashboardView->setAllPicturesView(new Dashboard_pic_tableView($pictureTableView));
        }

        return $this->getContentFrameView("Dashboard", $dashboardView, false);
    }

    public function deleteExhibitionAction()
    {
        $get = $this->getRequest()->getGetParam();
        $catId = $this->getValueOrNull("id", $get);
        if (null == $catId) {
            throw new SimpleUserErrorException("Die Ausstellung wurde nicht gefunden.");
        }

        $this->categoryDAO->deleteCateogry($catId);

        $this->getAlertManager()->setSuccessMessage("<strong>OK:</strong> Die Ausstellung wurde entfernt.");

        $this->getRouter()->reLocateTo("backend");
    }
}