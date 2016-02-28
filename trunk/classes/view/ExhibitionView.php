<?php

/**
 * Detail-View of a 'Ausstellung' showing
 * all Picture containing to the selected one.
 *
 * User: felix
 * Date: 28.02.16
 * Time: 20:42
 */
class ExhibitionView extends View
{

    /**
     * @var Category
     */
    private $exhibition;

    private $pictures;

    /**
     * ExhibitionView constructor.
     * @param Category $exhibition
     * @param $pictures Picture[]
     */
    public function __construct(Category $exhibition, $pictures)
    {
        parent::__construct();
        $this->exhibition = $exhibition;
        $this->pictures = $pictures;
    }

    public function getExhibitionName()
    {
        return $this->exhibition->getCategoryName();
    }

    public function getExhibitionDescription()
    {
        return $this->exhibition->getDescription();
    }

    public function getPictures()
    {
        return $this->pictures;
    }


    public function getCustomCSS()
    {
        return "pinterest_style.css";
    }

}