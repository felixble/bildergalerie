<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 11.02.16
 * Time: 23:47
 */
class Picture
{
    const MYSQL_DATE_TIME_FORMAT = "Y-m-d H:i:s";

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
     * @var PicturePath
     */
    private $path;

    /**
     * @var DateTime
     */
    private $producedDate;

    /**
     * @var DateTime
     */
    private $createdDate;

    /**
     * @var User
     */
    private $uploadedBy;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var Category[]
     */
    private $categories;

    /**
     * @var ArtisticStyle
     */
    private $artisticStyle;

    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * The current users rating value.
     *
     * @var int
     */
    private $ratingValue;

    /**
     * @var double
     */
    private $averageRatingValue;

    /**
     * @var int
     */
    private $ratingCount = 0;

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
     * @param PicturePath|int $path
     * @param DateTime|string|null $producedDate
     * @param DateTime|string|null $createdDate
     * @param User $uploadedBy
     * @param User $owner
     * @param ArtisticStyle|int $artisticStyle
     * @param null|string[]|Tag[] $tags
     */
    public function __construct(Mandant $mandant, $pictureId = null, $title = null, $description = null, $format = null, $material = null, $price = null, $pricePublic = null, $salable = null, $path = null, $producedDate = null, $createdDate = null, User $uploadedBy = null, User $owner = null, $artisticStyle = null, $tags = null
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
        $this->setPath($path);
        $this->setProducedDate($producedDate);
        $this->setCreatedDate($createdDate);
        $this->uploadedBy = $uploadedBy;
        $this->owner = $owner;
        $this->setArtisticStyle($artisticStyle);
        $this->setTags($tags);
    }


    /**
     * It is sometimes necessary to create a
     * picture object without setting all
     * obligatory attributes.
     * So, use this method if you would like
     * to know if all obligatory attributes
     * are correctly set.
     *
     */
    public function validate()
    {
        if (null == $this->getMandant() || !($this->getMandant() instanceof Mandant)) {
            throw new IllegalStateException("Picture object does not have a mandant object.");
        }

        $title = $this->getTitle();
        if (null == $title || empty($title)) {
            throw new InvalidInputException("Das Gemälde hat keinen Titel.", "", true);
        }

        if (null == $this->getPath()) {
            throw new InvalidInputException("Zu den Gemälde-Details wurde kein Bild hochgeladen.", "", true);
        }

        $categories = $this->getCategories();
        if (null == $categories || count($categories) == 0) {
            throw new InvalidInputException("Das Gemälde muss mindestens einer Kategorie zugeordnet werden.", "", true);
        }
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
     * @return PicturePath
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param PicturePath|int $path
     * @return Picture
     */
    public function setPath($path)
    {
        if ($path instanceof PicturePath) {
            $this->path = $path;
        } else {
            $this->path = new PicturePath($this->mandant, $path);
        }
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
        if (null == $producedDate ||$producedDate instanceof DateTime) {
            $this->producedDate = $producedDate;
        } else { // convert db date to DateTime
            $this->producedDate = DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $producedDate);
        }
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param DateTime $createdDate
     * @return Picture
     */
    public function setCreatedDate($createdDate)
    {
        if (null == $createdDate) {
            $this->createdDate = new DateTime();
        } elseif ($createdDate instanceof DateTime) {
            $this->createdDate = $createdDate;
        } else { // convert db date to DateTime
            $this->createdDate = DateTime::createFromFormat(self::MYSQL_DATE_TIME_FORMAT, $createdDate);
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
     * @return Category[]
     */
    public function getCategories()
    {
        if (!is_array($this->categories)) {
            $this->categories = array();
        }
        return $this->categories;
    }

    /**
     * @param Category|int $category
     * @return Picture
     */
    public function addCategory($category)
    {

        if (!is_array($this->categories)) {
            $this->categories = array();
        }

        if ($category instanceof Category) {
            $newCategory = $category;
        } else {
            $newCategory = new Category($this->getMandant(), $category);
        }
        $this->categories[] = $newCategory;

        return $this;
    }

    public function addCategories($categories)
    {
        if (null == $categories) return;
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    public function setCategoriesFromStringList($catsStr, $delimiter)
    {
        if (null == $catsStr) return;

        $arr = explode($delimiter, $catsStr);
        foreach ($arr as $item) {
            $this->addCategory(new Category($this->getMandant(), null, $item));
        }
    }

    public function getCategoriesAsString($delimiter)
    {
        return implode($delimiter, $this->getCategories());
    }

    /**
     * Returns the category object identified by the given id
     * or null, iff not given.
     *
     * @param $categoryId int id of the exhibition (=category)
     * @return Category|null
     */
    public function getCategoryById($categoryId)
    {
        foreach ($this->categories as $category) {
            if ($categoryId == $category->getCategoryId()) {
                return $category;
            }
        }
    }

    public function hasCategory(Category $category)
    {
        return null != $this->getCategoryById($category->getCategoryId());
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

    public function getTags()
    {
        if (null == $this->tags) return array();
        return $this->tags;
    }

    /**
     * @param $tags string[]|Tag[]
     */
    public function setTags($tags)
    {
        if (null == $tags || count($tags) == 0) return;

        if ($tags[0] instanceof Tag) {
            $this->tags = $tags;
        } else {
            // convert tag name array to tag object
            $this->tags = array();
            foreach ($tags as $tag) {
                $this->tags[] = new Tag($this->mandant, null, $tag);
            }
        }

    }

    public function setVisitorRatingValue($ratingValue)
    {
        $this->ratingValue = $ratingValue;
    }

    /**
     * @return int
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    public function setAverageRatingValue($averageRatingValue)
    {
        $this->averageRatingValue = $averageRatingValue;
    }

    /**
     * @return float
     */
    public function getAverageRatingValue()
    {
        return $this->averageRatingValue;
    }

    public function setRatingCount($ratingCount)
    {
        $this->ratingCount = $ratingCount;
    }

    /**
     * @return int
     */
    public function getRatingCount()
    {
        return $this->ratingCount;
    }

}