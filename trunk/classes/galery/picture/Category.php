<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 11.02.16
 * Time: 23:47
 */
class Category
{

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * @var null|int
     */
    private $categoryId;

    /**
     * @var string
     */
    private $categoryName;

    /**
     * @var string
     */
    private $description;

    /**
     * Category constructor.
     * @param Mandant $mandant
     * @param int|null $categoryId
     * @param string $categoryName
     * @param string $description
     */
    public function __construct(Mandant $mandant, $categoryId, $categoryName = null, $description = null)
    {
        $this->mandant = $mandant;
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
        $this->description = $description;
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
     * @return Category
     */
    public function setMandant($mandant)
    {
        $this->mandant = $mandant;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @param int|null $categoryId
     * @return Category
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * @param string $categoryName
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
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
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

}