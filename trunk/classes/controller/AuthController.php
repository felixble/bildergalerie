<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 13.02.2016
 * Time: 23:57
 */
class AuthController extends BildergalerieController
{

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
        return $this->loginAction();
    }

    public function loginAction()
    {
        if (array_key_exists("submit_login", $this->getRequest()->getPostParam())) { // login form submitted
            $username = $this->getRequest()->getPostParam()["inputUser"];
            $pass = $this->getRequest()->getPostParam()["inputPassword"];
            $authenticated = $this->baseFactory->getAuthenticator()->authenticate($username, $pass);
            if ($authenticated) {
                $this->getRouter()->rewindAndRestartRouting();
            } else {
                // TODO: Fehlermeldung!
            }
        }

        $view = BootstrapView::getContentFrameView("Login", new LoginView());
        return $view;
    }

    public function logoutAction()
    {
        $this->baseFactory->getAuthenticator()->logout();
        $this->getAlertManager()->setSuccessMessage("Auf Wiedersehen!");
        $this->getRouter()->reLocateTo();
    }
}