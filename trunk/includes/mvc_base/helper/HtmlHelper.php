<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 23:38
 */

class HtmlHelper {

    public static function linkCSS($path) {
        return '<link href="' . $path . '" rel="stylesheet">';
    }

    public static function scriptJS($path) {
        return '<script src="'.$path.'"></script>';
    }

} 