<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 25.02.16
 * Time: 23:56
 */
class ExhibitionsView extends View
{

    /**
     * @var Exhibition_teasersView
     */
    private $ausstellungTeasersView;

    /**
     * AusstellungenView constructor.
     * @param CategoryTeaser[] $categoryTeasers
     */
    public function __construct(array $categoryTeasers)
    {
        parent::__construct();
        $this->ausstellungTeasersView = new Exhibition_teasersView($categoryTeasers);
    }


    public function getAusstellungTeasersView()
    {
        return $this->ausstellungTeasersView;
    }
}