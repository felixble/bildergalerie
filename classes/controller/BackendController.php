<?php

/**
 * Controller for the backend (dashboard) Views.
 *
 * User: felix
 * Date: 20.02.16
 * Time: 15:01
 *
 * All actions needs authentications:
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

    /**
     * @var PictureDAO
     */
    private $picDAO;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->picDAO = new PictureDAO($this->baseFactory->getDbConnection(), $this->mandant);
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
        $dashboardView->setUnlinkedPicturesView(new Dashboard_unlinked_picturesView($unlinkedPicPathes));

        // fetch all uncategorized pictures
        $uncategorizedPics = $this->picDAO->getUncategorizedPictures();
        if (count($uncategorizedPics)) {
            $allCategories = $this->categoryDAO->getAllCategories();
            $dashboardView->setUncategorizedPicturesView(
                new Dashboard_uncategorized_picturesView($uncategorizedPics, $allCategories));
        }

        // fetch all pictures
        $pictureTableView = $this->picDAO->getPicturesFromCategory(-1, true, true);
        $dashboardView->setAllPicturesView(new Dashboard_pic_tableView($pictureTableView));

        return $this->getContentFrameView("Dashboard", $dashboardView, false);
    }

    public function deleteExhibitionAction()
    {
        $get = $this->getRequest()->getGetParam();
        $catId = self::getValueOrNull("id", $get);

        $request = new \App\Exhibition\Delete\Request();
        $request->id = $catId;

        $boundary = $this->application->getExhibitionBoundary();
        $boundary->deleteExhibition($request);

        $this->getAlertManager()->setSuccessMessage("<strong>OK:</strong> Die Ausstellung wurde entfernt.");

        $this->getRouter()->reLocateTo("backend");
    }
}