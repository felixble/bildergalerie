<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:30
 */

class HomeController extends BildergalerieController {

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * @return BootstrapView
     */
    public function indexAction()
    {
        return BootstrapHelper::getContentFrameView("Startseite", new HomeView());
    }
}