<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:30
 */

class HomeController extends BildergalerieController {

    /**
     * @return BootstrapView
     */
    public function indexAction()
    {
        return $this->getContentFrameView("Startseite", new HomeView());
    }
}