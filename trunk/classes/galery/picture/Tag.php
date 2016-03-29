<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.02.16
 * Time: 19:38
 */
class Tag
{

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * @var int|null
     */
    private $tagId;

    /**
     * @var string
     */
    private $tagName;

    /**
     * Tag constructor.
     * @param Mandant $mandant
     * @param int|null $tagId
     * @param string $tagName
     */
    public function __construct(Mandant $mandant = null, $tagId = null, $tagName = null)
    {
        $this->mandant = $mandant;
        $this->tagId = $tagId;
        $this->tagName = $tagName;
    }

    /**
     * @return Mandant
     */
    public function getMandant()
    {
        return $this->mandant;
    }

    /**
     * @param Mandant $mandant
     * @return Tag
     */
    public function setMandant($mandant)
    {
        $this->mandant = $mandant;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * @param int|null $tagId
     * @return Tag
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     * @return Tag
     */
    public function setTagName($tagName)
    {
        $this->tagName = $tagName;
        return $this;
    }

    public function __toString()
    {
        return $this->getTagName();
    }

}