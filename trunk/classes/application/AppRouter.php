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
            $annotations = $controller->getAnnotationParser()->getAnnotationsForMethod($action);
            if ($annotations->has("AuthRequired") && !$this->isUserLoggedIn()) {
                $this->reRouteTo("auth", "login");
            }
        } else {
            throw new IllegalStateException(
                "Could not check annotations because Controller is not an instance of BildergalerieController");
        }
    }

    private function isUserLoggedIn()
    {
        $auth = $this->baseFactory->getAuthenticator();
        return $auth->isAuthenticated();
    }

}