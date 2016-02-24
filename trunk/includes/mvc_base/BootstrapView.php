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
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function addCSS($css)
    {
        if (null == $this->css) {
            $this->css = array();
        }

        if (is_array($css)) {
            $this->css = array_merge($this->css, $css);
        } else {
            $this->css[] = $css;
        }
    }

    public function addJS($js)
    {
        if (null == $this->js) {
            $this->js = array();
        }

        if (is_array($js)) {
            $this->js = array_merge($this->js, $js);
        } else {
            $this->js[] = $js;
        }
    }

    /**
     * @return array
     */
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

    public function getBodyContent()
    {
        return $this->bodyContent;
    }

    public function setBodyContent($bodyContent)
    {
        $this->bodyContent = $bodyContent;
        if (($bodyContent instanceof View) && ( null != $bodyContent->getCustomCSS() )) {
            // the bodyContent provides a custom css file
            $this->addCSS($bodyContent->getCustomCSS());
            $this->addJS($bodyContent->getCustomJS());
        }
    }

    /**
     * @param mixed $contentPastJs
     * @return BootstrapView
     */
    public function setContentPastJs($contentPastJs)
    {
        $this->contentPastJs = $contentPastJs;
        return $this;
    }

    public function getContentPastJs()
    {
        return $this->contentPastJs;
    }

    public static function getContentFrameView($title, $content)
    {
        $baseView = new BootstrapView();
        $baseView->setTitle($title);

        $baseView->setBodyContent($content);

        return $baseView;
    }

    public function enableJQueryUI()
    {
        return true;
    }
}