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
     * @var null|Tag[]
     */
    private $tags;

    /**
     * @var null|Tag
     */
    private $tag;

    /**
     * ExhibitionView constructor.
     * @param Category|null $exhibition
     * @param $pictures Picture[]
     * @param null|Tag[] $tags
     * @param Tag $tag
     */
    public function __construct($exhibition, $pictures, $tags = null, $tag = null)
    {
        parent::__construct();
        $this->exhibition = $exhibition;
        $this->pictures = $pictures;
        $this->tags = $tags;
        $this->tag = $tag;
    }

    public function getExhibitionName()
    {
        if (null == $this->exhibition) {
            return (null == $this->tag)
                ? "Alle Gemälde"
                : "Gemälde mit Schlagwort " . $this->tag->getTagName();
        }

        return $this->exhibition->getCategoryName();
    }

    public function getExhibitionDescription()
    {
        if (null == $this->exhibition) return "";
        return $this->exhibition->getDescription();
    }

    public function showTagCanvas()
    {
        return (null == $this->exhibition && count($this->getTags()) != 0 );
    }

    public function getTags()
    {
        if (null == $this->tags) return array();
        return $this->tags;
    }

    public function getTagMaxNumberOfOccurrences()
    {
        if (null == $this->tags) return 0;

        $max = 0;
        foreach ($this->tags as $tag) {
            if ($tag->getNumberOccurrences() > $max)
                $max = $tag->getNumberOccurrences();
        }

        return $max;
    }

    public function getPictures()
    {
        return $this->pictures;
    }


    public function getCustomCSS()
    {
        return "pinterest_style.css";
    }

    public function getCustomJS()
    {
        return "tag_canvas.js";
    }

}