<?php
/**
 * Base View containing the html frame
 * necessary for a bootstrap page.
 *
 * User: Felix
 * Date: 15.12.2015
 * Time: 23:34
 */

class BootstrapView extends View {

    const TITLE_PREFIX = "Hildes Bildergalerie - ";

    private $title;

    private $css = null;

    private $js = null;

    private $additionalHeader;

    private $bodyContent;

    private $contentPastJs;

    public function __construct() {
        parent::__construct("includes/mvc_base/templates/bootstrap");
    }

    public function getTitle()
    {
        return self::TITLE_PREFIX . $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getCSS()
    {
        return $this->css;
    }

    public function getAdditionalHeader()
    {
        return $this->additionalHeader;
    }

    public function getJS()
    {
        return $this->js;
    }

    public function setJS($js)
    {
        $this->js = $js;
    }

    public function getBodyContent()
    {
        return $this->bodyContent;
    }

    public function setBodyContent($bodyContent)
    {
        $this->bodyContent = $bodyContent;
    }

    public function getContentPastJs()
    {
        return $this->contentPastJs;
    }

    public static function getContentFrameView($title, $content)
    {
        $baseView = new BootstrapView();
        $baseView->setTitle($title);

        //$bodyContent = new Content_frameView($title, $title);
        //$bodyContent->setContent($content);

        $baseView->setBodyContent($content);

        return $baseView;
    }
}