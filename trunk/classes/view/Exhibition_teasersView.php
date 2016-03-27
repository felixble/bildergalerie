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
     * @var bool
     */
    private $showNoContentMsg;

    /**
     * Ausstellung_teasersView constructor.
     * @param $teasers CategoryTeaser[]
     * @param bool $showFirstDivider
     * @param bool $showNoContentMsg
     */
    public function __construct($teasers, $showFirstDivider = false, $showNoContentMsg = true)
    {
        parent::__construct();
        $this->teasers = $teasers;
        $this->showFirstDivider = $showFirstDivider;
        $this->showNoContentMsg = $showNoContentMsg;
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

    public function showNoContentMsg()
    {
        return $this->showNoContentMsg;
    }
}