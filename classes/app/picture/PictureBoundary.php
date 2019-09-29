<?php

namespace App\Picture;

use App\Utils\Authenticator;

class PictureBoundary
{

    private $authenticator;
    private $pictureRepository;
    private $pictureUploader;

    public function __construct(Authenticator $authenticator, PictureRepository $pictureRepository,
                                PictureUploader $pictureUploader)
    {
        $this->authenticator = $authenticator;
        $this->pictureRepository = $pictureRepository;
        $this->pictureUploader = $pictureUploader;
    }

    public function createPicture(Create\Request $request)
    {
        $createPicture = new Create\CreatePicture($this->authenticator, $this->pictureRepository);
        $createPicture->create($request);
    }

    public function uploadPicture(Upload\Request $request)
    {
        $uploadPicture = new Upload\UploadPicture($this->pictureRepository, $this->pictureUploader);
        return $uploadPicture->upload($request);
    }

}