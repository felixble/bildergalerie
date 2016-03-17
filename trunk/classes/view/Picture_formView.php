<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 14.02.2016
 * Time: 16:46
 */
class Picture_formView extends View
{

    private $categories;

    /**
     * Picture which contains the form values
     * to display.
     *
     * @var Picture
     */
    private $picture;

    private $editMode = false;

    /**
     * Picture_formView constructor.
     * @param bool $editMode
     */
    public function __construct($editMode)
    {
        parent::__construct();
        $this->editMode = $editMode;
    }


    public function getCustomJS()
    {
        return array("libs/typeahead.bundle.min.js", "picture_uploader.js", "libs/bootstrap-tagsinput.js",
            "tag_typeahead.js", "add_category_dialog.js");
    }

    public function getCustomCSS()
    {
        return "libs/bootstrap-tagsinput.css";
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function setPicture($currentPicture)
    {
        $this->picture = $currentPicture;
    }

    /**
     * @return Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return boolean
     */
    public function isEditMode()
    {
        return $this->editMode;
    }




}