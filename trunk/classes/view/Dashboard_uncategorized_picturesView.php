<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 29.03.16
 * Time: 13:33
 */
class Dashboard_uncategorized_picturesView extends View
{

    /**
     * @var Picture[]
     */
    private $uncategorizedPics;

    /**
     * @var Category[]
     */
    private $allCategories;

    /**
     * Dashboard_uncategorized_picturesView constructor.
     * @param Picture[] $uncategorizedPics
     * @param Category[] $allCategories
     */
    public function __construct($uncategorizedPics, $allCategories)
    {
        parent::__construct();
        $this->uncategorizedPics = $uncategorizedPics;
        $this->allCategories = $allCategories;
    }

    /**
     * @return Picture[]
     */
    public function getUncategorizedPics()
    {
        return $this->uncategorizedPics;
    }

    /**
     * @return Category[]
     */
    public function getAllCategories()
    {
        return $this->allCategories;
    }


}