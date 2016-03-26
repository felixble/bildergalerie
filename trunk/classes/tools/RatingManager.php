<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 26.03.16
 * Time: 18:05
 */
class RatingManager
{
    const KEY_COOKIE_RATING = "bildergalerie_vistor_rating_id";

    public static function getVisitorRatingId()
    {
        $cookies = $_COOKIE;
        if (!array_key_exists(self::KEY_COOKIE_RATING, $cookies)) {
            $ratingId = uniqid();
            setcookie(self::KEY_COOKIE_RATING, $ratingId, 2147483647, "/"); // expire = max int value (2^31-1)
            return $ratingId;
        }

        return $cookies[self::KEY_COOKIE_RATING];
    }

}