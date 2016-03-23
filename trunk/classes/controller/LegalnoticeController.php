<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 23.03.2016
 * Time: 13:37
 */
class LegalnoticeController extends BildergalerieController
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
        $legalnotice = new LegalnoticeView();
        $legalnotice->setAddress(null);
        $legalnotice->setName(null);
        $legalnotice->setEmail(null);
        $legalnotice->setMandant(null);
        $legalnotice->setZipcode(null);
        $legalnotice->setCity(null);

        return $this->getContentFrameView("Impressum", $legalnotice);
    }
}