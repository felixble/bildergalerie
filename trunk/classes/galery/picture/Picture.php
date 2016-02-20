<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 11.02.16
 * Time: 23:47
 */
class Picture
{

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * @var null|int
     */
    private $pictureId;

    /**
     * @var string max. 128 chars
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string max. 45 chars
     */
    private $format;

    /**
     * @var string max. 128 chars
     */
    private $material;

    /**
     * @var double
     */
    private $price;

    /**
     * @var bool|null
     */
    private $pricePublic;

    /**
     * @var bool|null
     */
    private $salable;

    /**
     * @var string Path to the file - max. 512 chars
     */
    private $path;

    /**
     * @var string Path to the thumb file - max. 512 chars
     */
    private $pathThumb;

    /**
     * @var DateTime
     */
    private $producedDate;

    /**
     * @var DateTime
     */
    private $uploadedDate;

    /**
     * @var User
     */
    private $uploadedBy;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var ArtisticStyle
     */
    private $artisticStyle;

    /**
     * Picture constructor.
     * @param Mandant $mandant
     * @param int|null $pictureId
     * @param string $title
     * @param string $description
     * @param string $format
     * @param string $material
     * @param float $price
     * @param bool|null $pricePublic
     * @param bool|null $salable
     * @param string $path
     * @param null $pathThumb
     * @param DateTime $producedDate
     * @param DateTime $uploadedDate
     * @param User $uploadedBy
     * @param User $owner
     * @param Category|int $category
     * @param ArtisticStyle|int $artisticStyle
     */
    public function __construct(Mandant $mandant, $pictureId, $title = null, $description = null, $format = null,
                                $material = null, $price = null, $pricePublic = null, $salable = null, $path = null,
                                $pathThumb = null, DateTime $producedDate = null, DateTime $uploadedDate = null,
                                User $uploadedBy = null, User $owner = null, $category = null,
                                $artisticStyle = null
    ) {
        $this->mandant = $mandant;
        $this->pictureId = $pictureId;
        $this->title = $title;
        $this->description = $description;
        $this->format = $format;
        $this->material = $material;
        $this->price = $price;
        $this->pricePublic = $pricePublic;
        $this->salable = $salable;
        $this->path = $path;
        $this->pathThumb = $pathThumb;
        $this->setProducedDate($producedDate);
        $this->setUploadedDate($uploadedDate);
        $this->uploadedBy = $uploadedBy;
        $this->owner = $owner;
        $this->setCategory($category);
        $this->setArtisticStyle($artisticStyle);
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
     * @return Picture
     */
    public function setMandant($mandant)
    {
        $this->mandant = $mandant;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPictureId()
    {
        return $this->pictureId;
    }

    /**
     * @param int|null $pictureId
     * @return Picture
     */
    public function setPictureId($pictureId)
    {
        $this->pictureId = $pictureId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Picture
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Picture
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return Picture
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return string
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @param string $material
     * @return Picture
     */
    public function setMaterial($material)
    {
        $this->material = $material;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Picture
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getPricePublic()
    {
        return $this->pricePublic;
    }

    /**
     * @param bool|null $pricePublic
     * @return Picture
     */
    public function setPricePublic($pricePublic)
    {
        $this->pricePublic = $pricePublic;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSalable()
    {
        return $this->salable;
    }

    /**
     * @param bool|null $salable
     * @return Picture
     */
    public function setSalable($salable)
    {
        $this->salable = $salable;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Picture
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getProducedDate()
    {
        return $this->producedDate;
    }

    /**
     * @param DateTime $producedDate
     * @return Picture
     */
    public function setProducedDate($producedDate)
    {
        $this->producedDate = $producedDate;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUploadedDate()
    {
        return $this->uploadedDate;
    }

    /**
     * @param DateTime $uploadedDate
     * @return Picture
     */
    public function setUploadedDate($uploadedDate)
    {
        if (null == $uploadedDate) {
            $this->uploadedDate = new DateTime();
        } else {
            $this->uploadedDate = $uploadedDate;
        }
        return $this;
    }

    /**
     * @return User
     */
    public function getUploadedBy()
    {
        return $this->uploadedBy;
    }

    /**
     * @param User $uploadedBy
     * @return Picture
     */
    public function setUploadedBy($uploadedBy)
    {
        $this->uploadedBy = $uploadedBy;
        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     * @return Picture
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category|int $category
     * @return Picture
     * @throws InvalidInputException
     */
    public function setCategory($category)
    {
        if (null == $category) {
            throw new InvalidInputException("category");
        }

        if ($category instanceof Category) {
            $this->category = $category;
        } else {
            $this->category = new Category($this->getMandant(), $category);
        }

        return $this;
    }

    /**
     * @return ArtisticStyle
     */
    public function getArtisticStyle()
    {
        return $this->artisticStyle;
    }

    /**
     * @param ArtisticStyle|int $artisticStyle
     * @return Picture
     */
    public function setArtisticStyle($artisticStyle)
    {
        if (null == $artisticStyle) return $this;

        if ($artisticStyle instanceof ArtisticStyle) {
            $this->artisticStyle = $artisticStyle;
        } else {
            $this->artisticStyle = new ArtisticStyle($this->getMandant(), $artisticStyle);
        }

        return $this;
    }



}