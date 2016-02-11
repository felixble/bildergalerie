<?php
/**
 * Created by PhpStorm.
 * User: felix
 * Date: 11.02.16
 * Time: 23:48
 */
class ArtisticStyle
{

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * @var null|int
     */
    private $styleId;

    /**
     * @var string
     */
    private $styleName;

    /**
     * @var string
     */
    private $description;

    /**
     * ArtisticStyle constructor.
     * @param Mandant $mandant
     * @param int|null $styleId
     * @param string $styleName
     * @param string $description
     */
    public function __construct(Mandant $mandant, $styleId, $styleName = null, $description = null)
    {
        $this->mandant = $mandant;
        $this->styleId = $styleId;
        $this->styleName = $styleName;
        $this->description = $description;
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
     * @return ArtisticStyle
     */
    public function setMandant($mandant)
    {
        $this->mandant = $mandant;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStyleId()
    {
        return $this->styleId;
    }

    /**
     * @param int|null $styleId
     * @return ArtisticStyle
     */
    public function setStyleId($styleId)
    {
        $this->styleId = $styleId;
        return $this;
    }

    /**
     * @return string
     */
    public function getStyleName()
    {
        return $this->styleName;
    }

    /**
     * @param string $styleName
     * @return ArtisticStyle
     */
    public function setStyleName($styleName)
    {
        $this->styleName = $styleName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return ArtisticStyle
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

}