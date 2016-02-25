<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:30
 */

class HomeController extends BildergalerieController {

    /**
     * @var Mandant
     */
    private $mandant;

    public function onCreate(Router $router)
    {
        parent::onCreate($router);
        $this->mandant = $this->baseFactory->getMandantManager()->getMandant();
    }

    /**
     * @return BootstrapView
     */
    public function indexAction()
    {
        $homeView = new HomeView();

        $categoryDAO = new CategoryDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $catTeasers = $categoryDAO->getCategoryTeasers(3);

        $homeView->setCategoryTeaser($catTeasers);

        return $this->getContentFrameView("Startseite", $homeView);
    }
}