<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 23:57
 */

class Content_frameView extends View {

    private $title;
    private $pageTitle;
    private $content;
    private $showCarousel = true;

    public function __construct($pageTitle, $title) {
        parent::__construct();
        $this->pageTitle = $pageTitle;
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the global page title of
     * the current mandant.
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getCustomCSS()
    {
        return array("carousel.css", "global.css");
    }

    public function getCustomJS()
    {
        return "global.js";
    }

    public function showCarousel()
    {
        return $this->showCarousel;
    }

    /**
     * @param mixed $showCarousel
     */
    public function setShowCarousel($showCarousel)
    {
        $this->showCarousel = $showCarousel;
    }
}