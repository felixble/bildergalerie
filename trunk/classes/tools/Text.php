<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 03.04.16
 * Time: 13:32
 */
class Text
{
    const ALLOWED_TAGS = "<br><i><strong><b><hr><h1><h2><h3><h4><h5><h6><div><ul><li><a>";

    /**
     * Prepares a text to displays it without
     * cross site scripting.
     * @param $text
     * @param $tagsAllowed
     * @return string
     */
    public static function prepare($text, $tagsAllowed = false)
    {
        if ($tagsAllowed) {
            $text = strip_tags($text, self::ALLOWED_TAGS);
        } else {
            $text = htmlentities($text);
        }

        return $text;
    }

}