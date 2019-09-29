<?php

namespace App\Picture;

interface PictureRepository
{


    public function createPicture(\Picture $picture, $edit);

    public function savePicturePath(\PicturePath $picturePath);
}