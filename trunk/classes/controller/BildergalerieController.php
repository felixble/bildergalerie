<?php

/**
 * Base Controller for our Bildergalerie-Application.
 *
 * User: Felix
 * Date: 30.12.2015
 * Time: 12:15
 */
abstract class BildergalerieController extends Controller
{

    /**
     * @var BaseFactory
     */
    protected $baseFactory;

    public function onCreate(Request $request)
    {
        parent::onCreate($request);
        $this->baseFactory = new BaseFactory($request);
    }

    public function getContentFrameView($title, $content)
    {
        $titlePrefix = $this->baseFactory->getMandantManager()->getMandant()->getPageTitle();

        $fullTitle = $titlePrefix . " - " . $title;

        $contentView = new Content_frameView($titlePrefix, $title);
        $contentView->setContent($content);

        $view = BootstrapView::getContentFrameView($fullTitle, $contentView);
        $view->setJS("global.js");

        return $view;
    }

}