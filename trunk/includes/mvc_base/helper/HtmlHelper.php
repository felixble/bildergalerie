<?php
/**
 * Helper-Class containing common
 * html patterns.
 *
 * User: Felix
 * Date: 15.12.2015
 * Time: 23:38
 */

class HtmlHelper {

    /**
     * Builds a link-tag to include a css file.
     *
     * @param $path path to the css file.
     * @return string
     */
    public static function linkCSS($path)
    {
        return '<link href="' . $path . '" rel="stylesheet">';
    }

    /**
     * Builds a script-tag to include a
     * javascript file.
     *
     * @param $path path to the js file.
     * @return string
     */
    public static function scriptJS($path)
    {
        return '<script src="'.$path.'"></script>';
    }

} 