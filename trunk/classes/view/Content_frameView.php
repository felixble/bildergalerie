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

    public function getActiveMenuItem()
    {
        // TODO: vielleicht besser clientseitig ermitteln?
        return "home";
    }
}