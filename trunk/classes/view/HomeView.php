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

    /**
     * @param NewsArticle|null $latestArticle
     */
    public function setLatestArticle($latestArticle)
    {
        $this->latestArticle = $latestArticle;
    }

    /**
     * @return string
     */
    public function getLatestArticleContent()
    {
        return (null == $this->latestArticle)
            ? "Momentan gibt es keine Neuigkeiten zu berichten"
            : $this->latestArticle->getContent();
    }

}