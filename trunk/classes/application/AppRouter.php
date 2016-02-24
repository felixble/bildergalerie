<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.02.2016
 * Time: 10:54
 */
class AppRouter extends Router
{

    /**
     * @var BaseFactory
     */
    protected $baseFactory;

    /**
     * @return BaseFactory
     */
    public function getBaseFactory()
    {
        return $this->baseFactory;
    }

    protected function onRequestBuilt(Request $request)
    {
        parent::onRequestBuilt($request);
        $this->baseFactory = new BaseFactory($request);
    }

    protected function preRunController(Controller $controller, $action)
    {
        parent::preRunController($controller, $action);
        if ($controller instanceof BildergalerieController) {
            $controllerAnnotations = $controller->getAnnotationParser()->getAnnotations();
            $actionAnnotations = $controller->getAnnotationParser()->getAnnotationsForMethod($action);
            $isAuthRequired = ($controllerAnnotations->has("AuthRequired") || $actionAnnotations->has("AuthRequired"));
            if ($isAuthRequired && !$this->isUserLoggedIn()) {
                $this->reRouteTo("auth", "login");
            }
        } else {
            throw new IllegalStateException(
                "Could not check annotations because Controller is not an instance of BildergalerieController");
        }
    }

    protected function exceptionHandler(\Exception $e, $jsonResponse = false)
    {
        $exceptionView = parent::exceptionHandler($e, $jsonResponse);
        if ($jsonResponse || $this->baseFactory == null) {
            return $exceptionView;
        }
        if (!$jsonResponse && $e instanceof UserException) {
            $this->getAlertManager()->setErrorMessage("<strong>Fehler!</strong> " . $e->getMessage());
            $exceptionView = "";
        }

        try {
            $exceptionView = $this->getContentFrameView("Error occured", $exceptionView, true);
        } catch (Exception $e) {
            // we could not get custom elements
        }

        return $exceptionView;
    }

    public function getContentFrameView($title, $content, $showCarousel = true)
    {
        $mandant = $this->baseFactory->getMandantManager()->getMandant();
        $titlePrefix = $mandant->getPageTitle();

        $fullTitle = $titlePrefix . " - " . $title;

        $contentView = new Content_frameView($titlePrefix, $title, $mandant->getGaleryBrand());
        $contentView->setContent($content);
        $contentView->setShowCarousel($showCarousel);

        // add alert message
        $alertManager = $this->getAlertManager();
        if ($alertManager->hasAlertMessage()) {
            $contentView->setAlert($alertManager->getAlertType(), $alertManager->getAlertMessage());
        }
        $alertManager->reset();

        // add current user, iff available
        $contentView->setCurrentUser($this->baseFactory->getAuthenticator()->getLoggedInUser());

        $view = BootstrapView::getContentFrameView($fullTitle, $contentView);
        if ($content instanceof View) {
            $view->addCSS($content->getCustomCSS());
            $view->addJS($content->getCustomJS());
        }
        $view->setContentPastJs(HtmlHelper::scriptJS("vendor/1000hz/bootstrap-validator/dist/validator.js"));

        return $view;
    }

    public function getAlertManager()
    {
        return new AlertManager($this->baseFactory->getSessionManager());;
    }

    private function isUserLoggedIn()
    {
        $auth = $this->baseFactory->getAuthenticator();
        return $auth->isAuthenticated();
    }

}