<?php


namespace App\Picture;


interface PictureUploader
{

    /**
     * @param $tmpFile
     * @param int $thumbWidth
     * @return boolean
     */
    public function uploadFile($tmpFile, $thumbWidth = 800);


    /**
     * @return string
     */
    public function getUploadedFilePath();

    /**
     * @return string
     */
    public function getThumbFilePath();

    /**
     * @return string
     */
    public function deleteUploadedFiles();

}