<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 16.12.2015
 * Time: 17:03
 */

class UnknownController extends Controller {


    public function indexAction()
    {
        $exceptionView = new ExceptionView();

        $exceptionView->setExceptionName("Page not available (404)");
        $exceptionView->setExceptionText("Diese Seite ist leider nicht verfügbar.");

        return BootstrapHelper::getContentFrameView("Error occured!", $exceptionView);
    }
}