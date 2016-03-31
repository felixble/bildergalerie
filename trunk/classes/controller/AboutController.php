<?php
/**
 * Controller for the page to
 * display the information about
 * the Artist.
 *
 * User: Marc
 * Date: 16.12.2015
 * Time: 16:20
 */

class AboutController extends BildergalerieController {

    public function indexAction()
    {
        return $this->getContentFrameView("Die Künstlerin", new AboutView());
    }

}