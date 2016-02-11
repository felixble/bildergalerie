<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 11.02.16
 * Time: 23:58
 */
class Mandant
{

    /**
     * @var int|null
     */
    private $mandantId;

    /**
     * @var string
     */
    private $pageTitle;

    /**
     * Mandant constructor.
     * @param int|null $mandantId
     * @param string|null $pageTitle
     */
    public function __construct($mandantId, $pageTitle = null)
    {
        $this->mandantId = $mandantId;
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return int
     */
    public function getMandantId()
    {
        return $this->mandantId;
    }

    /**
     * @param int|null $mandantId
     * @return Mandant
     */
    public function setMandantId($mandantId)
    {
        $this->mandantId = $mandantId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @param string $pageTitle
     * @return Mandant
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
        return $this;
    }



}