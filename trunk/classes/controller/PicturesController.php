<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 14.02.2016
 * Time: 16:44
 */
class PicturesController extends BildergalerieController
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
        // TODO: Implement indexAction() method.
        $test = 5;
        $this->getRouter()->reRouteTo("home", "index");
    }

    public function createAction()
    {
        return $this->getContentFrameView("Bild hinzufügen", new Picture_formView(), false);
    }
}