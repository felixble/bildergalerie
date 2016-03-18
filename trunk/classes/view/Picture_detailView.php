<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 22.02.2016
 * Time: 19:52
 */
class Picture_detailView extends View
{

    /**
     * @var Picture
     */
    private $picture;

    /**
     * @var Category|null
     */
    private $currentExhibition = null;

    /**
     * @var Category[]|null
     */
    private $otherCategories = null;

    /**
     * @var null|string
     */
    private $backTo;

    public function __construct(Picture $picture, $backTo = null, $currentExhibition = null)
    {
        parent::__construct(null);
        $this->picture = $picture;
        $this->backTo = $backTo;
        $this->currentExhibition = $currentExhibition;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    public function getBackTo()
    {
        return $this->backTo;
    }

    /**
     * return Category[]
     */
    public function getOtherCategories()
    {
        if (null != $this->otherCategories) return $this->otherCategories;

        $allCategories = $this->picture->getCategories();
        if (null == $this->currentExhibition) {
            $this->otherCategories = $allCategories;
        } else {
            $this->otherCategories = array();
            foreach ($allCategories as $category) {
                if ($category->getCategoryId() == $this->currentExhibition->getCategoryId()) continue;
                $this->otherCategories[] = $category;
            }
        }

        return $this->otherCategories;
    }

    public function hasCurrentExhibition()
    {
        return null != $this->currentExhibition;
    }

}