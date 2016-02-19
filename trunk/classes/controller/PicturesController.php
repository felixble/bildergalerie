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
        $this->getRouter()->reRouteTo("home", "index");
    }

    /**
     * @return BootstrapView
     * @AuthRequired
     */
    public function createAction()
    {
        $picFormView = new Picture_formView();

        // get Categories
        $categoryDAO = new CategoryDAO(
            $this->baseFactory->getDbConnection(),
            $this->baseFactory->getMandantManager()->getMandant());

        $picFormView->setCategories($categoryDAO->getAllCategories());

        return $this->getContentFrameView("Bild hinzufügen", $picFormView, false);
    }
}