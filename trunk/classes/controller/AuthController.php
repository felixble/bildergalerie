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
        return $this->getContentFrameView("Login", new LoginView());
    }
}