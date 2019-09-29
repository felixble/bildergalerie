<?php

class PictureRepositoryImpl implements \App\Picture\PictureRepository
{

    private $pictureDao;
    private $picPathDao;

    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        $this->pictureDao = new PictureDAO($dbConn, $mandant);
        $this->picPathDao = new PicturePathDAO($dbConn, $mandant);
    }

    public function createPicture(\Picture $picture, $edit)
    {
        if($edit){
            $this->pictureDao->updatePicture($picture);
        } else {
            $this->pictureDao->createPicture($picture);
        }
    }

    public function savePicturePath(PicturePath $picturePath)
    {

        try {
            return $this->picPathDao->createPicturePath($picturePath);
        } catch (Exception $e){
            return null;
        }
    }
}