<?php

/**
 * Router customization for the bildergalerie-
 * Project.
 *
 * User: Felix
 * Date: 15.02.2016
 * Time: 10:54
 */
class AppRouter extends Router
{

    /**
     * Application BaseFactory to
     * get a instance of the SessionManager,
     * DatabaseConnection or other singletons.
     *
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

    /**
     * Will be called after the request
     * has been built.
     *
     * @param Request $request
     */
    protected function onRequestBuilt(Request $request)
    {
        parent::onRequestBuilt($request);
        $this->baseFactory = new BaseFactory($request);
    }

    /**
     * Will be called immediately before the
     * controller will be executed.
     *
     * At this point we check if a user is
     * authenticated if necessary.
     *
     * @param Controller $controller
     * @param string $action
     * @throws IllegalStateException
     * @throws ReRouteRequestException
     * @throws SimpleUserErrorException
     */
    protected function preRunController(Controller $controller, $action)
    {
        parent::preRunController($controller, $action);
        if ($controller instanceof BildergalerieController) {
            $controllerAnnotations = $controller->getAnnotationParser()->getAnnotations();
            $actionAnnotations = $controller->getAnnotationParser()->getAnnotationsForMethod($action);
            $isAuthRequired = ($controllerAnnotations->has("AuthRequired") || $actionAnnotations->has("AuthRequired"));
            if ($isAuthRequired && !$this->isUserLoggedIn()) {
                // authRequired but no user authenticated!
                if ($controllerAnnotations->has("JsonResponse") || $actionAnnotations->has("JsonResponse")) {
                    throw new SimpleUserErrorException("Sie sind nicht angemeldet. Bitte loggen Sie sich zuerst ein.");
                } else {
                    $this->reRouteTo("auth", "login");
                }
            }
        } else {
            throw new IllegalStateException(
                "Could not check annotations because Controller is not an instance of BildergalerieController");
        }
    }

    /**
     * Here we customize the exception-handler.
     * We show the defaullt page frame if possible.
     *
     * @param Exception $e
     * @param bool $jsonResponse
     * @return BootstrapView|string
     */
    protected function exceptionHandler(\Exception $e, $jsonResponse = false)
    {
        $exceptionView = parent::exceptionHandler($e, $jsonResponse);

        if (!$jsonResponse && !($e instanceof UserException)) {
            // send ErrorMail
            ErrorMailHandler::sendErrorMail($e);
        }

        if ($jsonResponse || $this->baseFactory == null) {
            return $exceptionView;
        }
        if (!$jsonResponse && ($e instanceof UserException)) {
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

    /**
     * Here we provide the default content frame
     * which is equal for each page.
     *
     * @param $title
     * @param $content
     * @param bool $showCarousel
     * @return BootstrapView
     */
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

    /**
     * Gets the alert manager to read or write
     * error or success messages.
     *
     * @return AlertManager
     */
    public function getAlertManager()
    {
        return new AlertManager($this->baseFactory->getSessionManager());;
    }

    /**
     * Checks if there is currently a user
     * authenticated.
     *
     * @return bool
     */
    private function isUserLoggedIn()
    {
        $auth = $this->baseFactory->getAuthenticator();
        return $auth->isAuthenticated();
    }

}