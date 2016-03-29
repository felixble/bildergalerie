<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:33
 */

class HomeView extends View {

    /**
     * @var Exhibition_teasersView;
     */
    private $ausstellungTeaserView;

    /**
     * @var NewsArticle
     */
    private $latestArticle;

    /**
     * HomeView constructor.
     */
    public function __construct()
    {
        parent::__construct(null);
    }

    public function setCategoryTeaser($ausstellungTeaserView)
    {
        $this->ausstellungTeaserView =
            new Exhibition_teasersView($ausstellungTeaserView, /*showFirstDivider*/ true, /*showNoContentMsg*/ false);
    }

    /**
     * @return Exhibition_teasersView
     */
    public function getCatTeaserView()
    {
        return $this->ausstellungTeaserView;
    }

    public function setLatestArticle(NewsArticle $latestArticle)
    {
        $this->latestArticle = $latestArticle;
    }

    /**
     * @return NewsArticle
     */
    public function getLatestArticle()
    {
        return $this->latestArticle;
    }

}