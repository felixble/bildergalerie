<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 15.03.16
 * Time: 16:19
 */
class DashboardView extends View
{

    private $css = array();

    /**
     * @var null|Category[]
     */
    private $categories;

    /**
     * @var Dashboard_unlinked_picturesView
     */
    private $unlinkedPicturesView;

    /**
     * @var Dashboard_pic_tableView|null
     */
    private $pictureTableView;

    /**
     * @return Category[]|null
     */
    public function getCategories()
    {
        return $this->categories;
    }



    public function getCustomJS()
    {
        return array("add_category_dialog.js", "tabs_control.js");
    }

    /**
     * @return Dashboard_unlinked_picturesView
     */
    public function getUnlinkedPicturesView()
    {
        return $this->unlinkedPicturesView;
    }

    /**
     * @param Dashboard_unlinked_picturesView $unlinkedPicturesView
     * @return DashboardView|null
     */
    public function setUnlinkedPicturesView(Dashboard_unlinked_picturesView $unlinkedPicturesView)
    {
        if (null != $unlinkedPicturesView) {
            $css = $unlinkedPicturesView->getCustomCSS();
            if (is_array($css)) {
                $this->css = array_merge($this->css, $unlinkedPicturesView->getCustomCSS());
            } else {
                $this->css[] = $css;
            }
        }

        $this->unlinkedPicturesView = $unlinkedPicturesView;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasUnlinkedPicturesView()
    {
        return (null == $this->unlinkedPicturesView);
    }

    /**
     * @param $categories null|Category[]
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getCustomCSS()
    {
        return $this->css;
    }

    /**
     * @param Dashboard_pic_tableView|null $pictureTableView
     */
    public function setAllPicturesView(Dashboard_pic_tableView $pictureTableView)
    {
        $this->pictureTableView = $pictureTableView;
    }

    /**
     * @return Dashboard_pic_tableView|null
     */
    public function getPictureTableView()
    {
        return $this->pictureTableView;
    }

}