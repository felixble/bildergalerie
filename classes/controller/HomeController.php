<?php
/**
 * Default controller.
 *
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

        $newsDAO = new NewsDAO($this->baseFactory->getDbConnection(), $this->mandant);
        $latestArticle = $newsDAO->getLatestArticle();
        $homeView->setLatestArticle($latestArticle);

        $request = new \App\Exhibition\ListAll\Request();
        $request->mandant = $this->mandant;

        $boundary = $this->application->getExhibitionBoundary();
        $response = $boundary->listAllExhibitions($request);

        $homeView->setCategoryTeaser($response->exhibitions);

        return $this->getContentFrameView("Startseite", $homeView);
    }
}