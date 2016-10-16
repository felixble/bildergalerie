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
     * @param $path string path to the css file.
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
     * @param $path string path to the js file.
     * @param $prepend string to prepend before the path,
     *                 iff the path does not start with the string 'http'
     * @return string
     */
    public static function scriptJS($path, $prepend = "")
    {
        if (!empty($prepend) && substr($path, 0,4) != "http") {
            $path = $prepend . $path;
        }

        return '<script src="'.$path.'"></script>';
    }

} 