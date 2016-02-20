<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.02.16
 * Time: 23:13
 */
abstract class BaseMultiClientDAO extends BaseDAO
{

    /**
     * @var Mandant
     */
    protected $mandant;

    public function __construct(\Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn);
        $this->mandant = $mandant;
    }

}