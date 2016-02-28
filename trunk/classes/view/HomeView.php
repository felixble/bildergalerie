<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:33
 */

class HomeView extends View {

    /**
     * @var Ausstellung_teasersView;
     */
    private $ausstellungTeaserView;

    /**
     * HomeView constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    public function setCategoryTeaser($ausstellungTeaserView)
    {
        $this->ausstellungTeaserView = new Ausstellung_teasersView($ausstellungTeaserView, /*showFirstDivider*/ true);
    }

    /**
     * @return Ausstellung_teasersView
     */
    public function getCatTeaserView()
    {
        return $this->ausstellungTeaserView;
    }

}