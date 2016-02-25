<?php
/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 15.12.2015
 * Time: 19:33
 */

class HomeView extends View {

    /**
     * @var Mandant
     */
    private $mandant;

    /**
     * HomeView constructor.
     * @param Mandant $mandant
     */
    public function __construct(Mandant $mandant)
    {
        parent::__construct(null);
        $this->mandant = $mandant;
    }

    public function getMandant()
    {
        return $this->mandant;
    }
}