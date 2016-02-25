<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 25.02.16
 * Time: 15:39
 */
class CategoryTeaser
{

    /**
     * @var Category
     */
    private $category;

    /**
     * @var Picture
     */
    private $picture;

    /**
     * CategoryTeaser constructor.
     * @param Category $category
     * @param Picture $picture
     */
    public function __construct(Category $category, Picture $picture)
    {
        $this->category = $category;
        $this->picture = $picture;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param Picture $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    public function getName()
    {
        return $this->getCategory()->getCategoryName();
    }

    public function getDescription()
    {
        return $this->getCategory()->getDescription();
    }

    public function getPictureThumb()
    {
        return $this->getPicture()->getPath()->getThumbPath();
    }

    public function getTitle()
    {
        return $this->getPicture()->getTitle();
    }

}