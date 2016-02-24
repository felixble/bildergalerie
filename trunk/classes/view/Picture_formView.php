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



}