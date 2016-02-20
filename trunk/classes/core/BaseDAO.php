<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.02.16
 * Time: 23:10
 */
abstract class BaseDAO
{

    /**
     * @var Simplon\Mysql\Manager\SqlManager
     */
    protected $sqlManager;

    /**
     * MandantDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn)
    {
        $this->sqlManager = new \Simplon\Mysql\Manager\SqlManager($dbConn);
    }

    /**
     * @param $data
     * @return int|bool id if auto increment or true
     */
    protected function create($data)
    {
        $sqlBuilder = $this->getSqlBuilder()->setData($data);

        return $this->sqlManager->insert($sqlBuilder);
    }

    protected function getSqlBuilder()
    {
        $sqlBuilder = new Simplon\Mysql\Manager\SqlQueryBuilder();

        $sqlBuilder->setTableName($this->getTableName());
        return $sqlBuilder;
    }

    /**
     * @return string table name.
     */
    protected abstract function getTableName();

}