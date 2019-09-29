<?php


namespace App;


use App\Picture\PictureBoundary;

interface Application
{

    /**
     * @return Exhibition\ExhibitionBoundary
     */
    public function getExhibitionBoundary();

    /**
     * @return PictureBoundary
     */
    public function getPictureBoundary();

}