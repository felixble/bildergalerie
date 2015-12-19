<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 16.12.2015
 * Time: 16:20
 */

class AboutController extends Controller {

    public function indexAction()
    {
        return BootstrapHelper::getContentFrameView("Die Künstlerin", new AboutView());
    }
}