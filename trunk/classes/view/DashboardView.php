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
     * @var Dashboard_news_tableView
     */
    private $newsTableView;

    /**
     * @var Dashboard_uncategorized_picturesView
     */
    private $uncategorized_picturesView;


    /**
     * @param Dashboard_news_tableView $newsTableView
     */
    public function setNewsTableView($newsTableView)
    {
        $this->newsTableView = $newsTableView;
    }

    /**
     * @return Dashboard_news_tableView
     */
    public function getNewsTableView()
    {
        return $this->newsTableView;
    }

    /**
     * @return Category[]|null
     */
    public function getCategories()
    {
        return $this->categories;
    }



    public function getCustomJS()
    {
        return array("add_category_dialog.js", "tabs_control.js", "categorize_pic.js");
    }

    /**
     * @return Dashboard_unlinked_picturesView
     */
    public function getUnlinkedPicturesView()
    {
        return (null == $this->unlinkedPicturesView) ? "" : $this->unlinkedPicturesView;
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

    /**
     * @param Dashboard_uncategorized_picturesView $uncategorized_picturesView
     */
    public function setUncategorizedPicturesView(Dashboard_uncategorized_picturesView $uncategorized_picturesView)
    {
        $this->uncategorized_picturesView = $uncategorized_picturesView;
    }

    /**
     * @return Dashboard_uncategorized_picturesView
     */
    public function getUncategorizedPicturesView()
    {
        return (null == $this->uncategorized_picturesView) ? "" : $this->uncategorized_picturesView;
    }

}