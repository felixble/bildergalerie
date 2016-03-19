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
     * @param Category|null $exhibition
     * @param $pictures Picture[]
     */
    public function __construct($exhibition, $pictures)
    {
        parent::__construct();
        $this->exhibition = $exhibition;
        $this->pictures = $pictures;
    }

    public function getExhibitionName()
    {
        if (null == $this->exhibition) return "Alle Gemälde";

        return $this->exhibition->getCategoryName();
    }

    public function getExhibitionDescription()
    {
        if (null == $this->exhibition) return "";
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