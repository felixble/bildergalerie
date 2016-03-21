<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.03.16
 * Time: 20:19
 */
class Dashboard_pic_tableView extends View
{

    /**
     * @var null|Picture[]
     */
    private $pictures;

    public function __construct($pictures)
    {
        parent::__construct();
        $this->pictures = $pictures;
    }

    /**
     * @return null|Picture[]
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param null|Picture[] $pictures
     * @return Dashboard_pic_tableView
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
        return $this;
    }



}