<?php

namespace App\Picture\Upload;

use App\Picture\PictureRepository;
use App\Picture\PictureUploader;

class UploadPicture
{

    private $pictureRepository;
    private $pictureUploader;

    public function __construct(PictureRepository $repository, PictureUploader $pictureUploader)
    {
        $this->pictureRepository = $repository;
        $this->pictureUploader = $pictureUploader;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function upload(Request $request)
    {
        $response = new Response();
        if(!$this->pictureUploader->uploadFile($request->file)){
            $response->success = false;
            return $response;
        }

        $picturePath = new \PicturePath($request->mandant, null, $this->pictureUploader->getUploadedFilePath(),
            $this->pictureUploader->getThumbFilePath(), $request->loggedInUser);
        $picPathId = $this->pictureRepository->savePicturePath($picturePath);
        if($picPathId != null){
            $response->picPathId = $picPathId;
            $response->filePath = $this->pictureUploader->getUploadedFilePath();
            $response->thumbPath = $this->pictureUploader->getThumbFilePath();
            $response->success = true;
            return $response;
        } else {
            $this->pictureUploader->deleteUploadedFiles();
            $response->success = false;
            return $response;
        }
    }
}