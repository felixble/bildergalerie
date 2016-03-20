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

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
        $this->categoryDAO = new CategoryDAO($this->baseFactory->getDbConnection(), $this->mandant);
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

        // fetch all exhibitions
        $categories = $this->categoryDAO->getAllCategories();
        $dashboardView->setCategories($categories);

        // fetch all unlinked picture pathes
        $picturePathDAO = new PicturePathDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $unlinkedPicPathes = $picturePathDAO->getUnlinkedPathes();
        $dashboardView->setUnlinkedPicturesView(new Dashboard_unlinked_picturesView($unlinkedPicPathes));


        return $this->getContentFrameView("Dashboard", $dashboardView, false);
    }
}