<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.02.16
 * Time: 23:02
 */
class PicturePath
{

    private $mandant;

    private $id;

    /**
     * @var string Path to the file - max. 512 chars
     */
    private $path;

    /**
     * @var string Path to the thumb file - max. 512 chars
     */
    private $thumbPath;

    private $uploadedBy;

    private $uploadedDate;

    /**
     * PicturePath constructor.
     * @param $mandant Mandant
     * @param $id int|null
     * @param $path string|null
     * @param $thumbPath string|null
     * @param $uploadedBy User|null
     * @param $uploadedDate User|null
     */
    public function __construct(Mandant $mandant, $id = null, $path = null, $thumbPath = null, User $uploadedBy = null,
                                User $uploadedDate = null)
    {
        $this->mandant = $mandant;
        $this->id = $id;
        $this->path = $path;
        $this->thumbPath = $thumbPath;
        $this->uploadedBy = $uploadedBy;
        $this->uploadedDate = $uploadedDate;
    }

    /**
     * @return Mandant
     */
    public function getMandant()
    {
        return $this->mandant;
    }

    /**
     * @param Mandant $mandant
     * @return PicturePath
     */
    public function setMandant($mandant)
    {
        $this->mandant = $mandant;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return PicturePath
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param null|string $path
     * @return PicturePath
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getThumbPath()
    {
        return $this->thumbPath;
    }

    /**
     * @param null|string $thumbPath
     * @return PicturePath
     */
    public function setThumbPath($thumbPath)
    {
        $this->thumbPath = $thumbPath;
        return $this;
    }

    /**
     * @return null|User
     */
    public function getUploadedBy()
    {
        return $this->uploadedBy;
    }

    /**
     * @param null|User $uploadedBy
     * @return PicturePath
     */
    public function setUploadedBy($uploadedBy)
    {
        $this->uploadedBy = $uploadedBy;
        return $this;
    }

    /**
     * @return null|User
     */
    public function getUploadedDate()
    {
        return $this->uploadedDate;
    }

    /**
     * @param null|User $uploadedDate
     * @return PicturePath
     */
    public function setUploadedDate($uploadedDate)
    {
        $this->uploadedDate = $uploadedDate;
        return $this;
    }


}