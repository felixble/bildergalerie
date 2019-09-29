<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 19:22
 */
class FileSystemPictureUploader implements \App\Picture\PictureUploader
{

    const THUMBS_FOLDER_NAME = "thumbs";

    /**
     * Path to the temporary file uploaded by browser.
     *
     * @var string
     */
    private $tmpFilePath;

    /**
     * @var string
     */
    private $fileName;

    /**
     * Path to the destination folder where
     * the uploaded file should copied to.
     *
     * @var string
     */
    private $destFolderPath;

    private $uploadedFilePath;

    private $thumbFilePath;

    public function __construct($destFolderPath)
    {
        if(!is_dir($destFolderPath)){
            mkdir($destFolderPath);
        }
        $this->destFolderPath = $destFolderPath;
    }

    /**
     * Moves the temporary file to the upload folder
     * and creates a thumbnail.
     *
     * @param $tmpFile
     * @param int|false $thumbWidth
     * @return bool
     * @throws FileAlreadyExists
     * @throws FileIsNotAnImage
     */
    public function uploadFile($tmpFile, $thumbWidth = 800)
    {
        $this->tmpFilePath = $tmpFile["tmp_name"];
        $this->fileName = $tmpFile["name"];
        if (!exif_imagetype($this->tmpFilePath)) {
            throw new FileIsNotAnImage($this->fileName);
        }

        $this->uploadedFilePath = $this->destFolderPath . "/" . $this->fileName;

        if (is_file($this->uploadedFilePath)) {
            throw new FileAlreadyExists($this->fileName);
        }

        $success = $this->move_uploaded_file($this->tmpFilePath, $this->uploadedFilePath);
 
        if ($success && $thumbWidth) {
            try {
                $this->thumbFilePath = $this->createThumbnail($thumbWidth);
            } catch (Exception $e) {
                // we could not create a thumbnail, whatever...
                // TODO: should we delete the original file as well or should we resign the thumb ?!
            }
        }

        return $success;
    }

    function move_uploaded_file($temporary_name, $target_path)
    {
        return move_uploaded_file($temporary_name, $target_path);
    } 

    /**
     * Creates a thumbnail of the previously uploaded image.
     *
     * @param int $thumbWidth
     * @return string
     */
    private function createThumbnail($thumbWidth)
    {
        // load image and get image size 
        $extension = pathinfo(strtolower($this->uploadedFilePath))["extension"];
        if($extension === "jpg" || $extension === "jpeg"){ 
            $img = imagecreatefromjpeg($this->uploadedFilePath);
        }else if($extension === "png"){
            $img = imagecreatefrompng($this->uploadedFilePath);  
        }else if($extension === "gif"){
            $img = imagecreatefromgif($this->uploadedFilePath); 
        }else{
            $img = imagecreatefromjpeg($this->uploadedFilePath); // old behavior
            // throw exception instead?
        } 
        
        $width = imagesx( $img );
        $height = imagesy( $img );

        // calculate thumbnail size
        $new_width = $thumbWidth;
        $new_height = floor( $height * ( $thumbWidth / $width ) );

        // create a new temporary image
        $tmp_img = imagecreatetruecolor( $new_width, $new_height );

        // copy and resize old image into new image
        imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

        $thumbDir = $this->destFolderPath . "/" . self::THUMBS_FOLDER_NAME;
        if (!is_dir($thumbDir)) {
            mkdir($thumbDir);
        }

        // save thumbnail into a file
        $thumbPath = $thumbDir . "/" . $this->fileName;
        imagejpeg( $tmp_img, $thumbPath );

        return $thumbPath;
    }

    /**
     * @return mixed
     */
    public function getUploadedFilePath()
    {
        return $this->uploadedFilePath;
    }

    /**
     * @return mixed
     */
    public function getThumbFilePath()
    {
        return $this->thumbFilePath;
    }

    public function deleteUploadedFiles()
    {
        $this->deleteFile($this->getUploadedFilePath());
        $this->deleteFile($this->getThumbFilePath());
    }

    private function deleteFile($path)
    {
        if (null != $path) unlink($path);
    }

}
