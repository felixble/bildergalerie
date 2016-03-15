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
        // lade alle Ausstellungen
        $categories = $this->categoryDAO->getAllCategories();

        return $this->getContentFrameView("Dashboard", new DashboardView($categories), false);
    }
}