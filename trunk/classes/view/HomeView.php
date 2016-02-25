<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:33
 */

class HomeView extends View {

    /**
     * @var CategoryTeaser[]
     */
    private $catTeaser;

    /**
     * HomeView constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    public function setCategoryTeaser($catTeasers)
    {
        $this->catTeaser = $catTeasers;
    }

    /**
     * @return CategoryTeaser[]
     */
    public function getCatTeaser()
    {
        return $this->catTeaser;
    }

}