<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.03.16
 * Time: 12:57
 */
class GaleryMysql extends \Simplon\Mysql\Mysql
{

    public function beginTransaction()
    {
        return $this->getDbh()->beginTransaction();
    }

    public function commitTransaction()
    {
        return $this->getDbh()->commit();
    }

    public function rollbackTransaction()
    {
        return $this->getDbh()->rollBack();
    }

}