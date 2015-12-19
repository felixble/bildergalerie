<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 23:57
 */

class Content_frameView extends View {

    private $title;
    private $content;

    public function __construct($title) {
        parent::__construct();
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
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