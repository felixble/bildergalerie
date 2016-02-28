<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 28.02.16
 * Time: 20:43
 */
class Exhibition_teasersView extends View
{

    /**
     * @var CategoryTeaser[]
     */
    private $teasers;

    /**
     * @var bool
     */
    private $showFirstDivider;

    /**
     * Ausstellung_teasersView constructor.
     * @param $teasers CategoryTeaser[]
     * @param bool $showFirstDivider
     */
    public function __construct($teasers, $showFirstDivider = false)
    {
        parent::__construct();
        $this->teasers = $teasers;
        $this->showFirstDivider = $showFirstDivider;
    }


    /**
     * @return CategoryTeaser[]
     */
    public function getCatTeasers()
    {
        return $this->teasers;
    }

    /**
     * @return bool
     */
    public function showFirstDivider()
    {
        return $this->showFirstDivider;
    }
}