<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 16.12.2015
 * Time: 16:27
 */

class BootstrapHelper {

    public static function getContentFrameView($title, $content) {
        $view = BootstrapView::getContentFrameView($title, $content);
        $view->addJS("global.js");

        return $view;
    }

} 