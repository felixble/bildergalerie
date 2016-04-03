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

    protected function getSqlBuilder($setTableName = true)
    {
        $sqlBuilder = new Simplon\Mysql\Manager\SqlQueryBuilder();

        if ($setTableName) {
            $sqlBuilder->setTableName($this->getTableName());
        }
        return $sqlBuilder;
    }

    /**
     * @param \Simplon\Mysql\Manager\SqlQueryBuilder $sqlBuilder
     * @return null|array
     */
    protected function fetchRow(\Simplon\Mysql\Manager\SqlQueryBuilder $sqlBuilder)
    {
        $row = $this->sqlManager->fetchRow($sqlBuilder);

        if ($this->sqlManager->getRowCount()) {
            return $this->row2object($row);
        }
        return null;
    }

    protected function fetchRowMany(\Simplon\Mysql\Manager\SqlQueryBuilder $sqlBuilder)
    {
        $rows = $this->sqlManager->fetchRowMany($sqlBuilder);
        $result = array();
        if ($this->sqlManager->getRowCount()) {
            foreach ($rows as $row) {
                $result[] = $this->row2Object($row);
            }
        }
        return $result;
    }

    /**
     * Returns the corresponding value to the given key
     * or null if the array does not contain this key.
     *
     * @param $array
     * @param $key
     * @return null|string
     */
    protected function getValueOrNull($array, $key)
    {
        if (array_key_exists($key, $array)) return Text::prepare($array[$key]);
        return null;
    }

    protected abstract function row2Object($row);

    /**
     * @return string table name.
     */
    protected abstract function getTableName();

}