<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 19:22
 */
class PictureUploader
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

    public function __construct($tmpFile, $destFolderPath)
    {
        $this->tmpFilePath = $tmpFile["tmp_name"];
        $this->fileName = $tmpFile["name"];
        $this->destFolderPath = $destFolderPath;

        if (!exif_imagetype($this->tmpFilePath)) {
            throw new FileIsNotAnImage($this->fileName);
        }
    }

    /**
     * Moves the temporary file to the upload folder
     * and creates a thumbnail.
     *
     * @param int|false $thumbWidth
     * @return bool
     * @throws FileAlreadyExists
     */
    public function uploadFile($thumbWidth = 400)
    {
        $this->uploadedFilePath = $this->destFolderPath . "/" . $this->fileName;

        if (is_file($this->uploadedFilePath)) {
            throw new FileAlreadyExists($this->fileName);
        }

        $success = move_uploaded_file($this->tmpFilePath, $this->uploadedFilePath);

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

    /**
     * Creates a thumbnail of the previously uploaded image.
     *
     * @param int $thumbWidth
     * @return string
     */
    private function createThumbnail($thumbWidth)
    {
        // load image and get image size
        $img = imagecreatefromjpeg($this->uploadedFilePath);
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