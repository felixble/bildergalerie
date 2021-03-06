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
    private $showAlert = false;
    private $alertType;
    private $alertMessage;
    private $currentUser = null;
    private $galeryBrand;


    public function __construct($pageTitle, $title, $galeryBrand) {
        parent::__construct();
        $this->pageTitle = $pageTitle;
        $this->title = $title;
        $this->galeryBrand = $galeryBrand;
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

    public function setAlert($alertType, $alertMessage)
    {
        $this->showAlert = true;
        $this->alertType = $alertType;
        $this->alertMessage = $alertMessage;
    }

    public function showAlert()
    {
        return $this->showAlert;
    }

    public function getAlertType()
    {
        return $this->alertType;
    }

    public function getAlertMessage()
    {
        return $this->alertMessage;
    }

    /**
     * @return User
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * @param User $currentUser
     */
    public function setCurrentUser($currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * @return string
     */
    public function getGaleryBrand()
    {
        return $this->galeryBrand;
    }

    public function isUserLoggedIn()
    {
        return (null != $this->getCurrentUser());
    }
}