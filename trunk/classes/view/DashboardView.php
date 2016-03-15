<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 15.03.16
 * Time: 16:19
 */
class DashboardView extends View
{

    /**
     * @var null|Category[]
     */
    private $categories;

    /**
     * DashboardView constructor.
     * @param null|Category[] $categories
     */
    public function __construct($categories = null)
    {
        parent::__construct(null);
        $this->categories = $categories;
    }

    /**
     * @return Category[]|null
     */
    public function getCategories()
    {
        return $this->categories;
    }

}