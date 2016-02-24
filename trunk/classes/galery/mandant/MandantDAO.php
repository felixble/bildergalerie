<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 12.02.2016
 * Time: 15:24
 */
class MandantDAO extends BaseDAO
{

    const TABLE_NAME = "galery_mandant";

    const COL_MANDANT_ID = "mandant_id";
    const COL_PAGE_TITLE = "page_title";
    const COL_DOAMIN = "domain";
    const COL_GALERY_BRAND = "galery_brand";

    /**
     * MandantDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn)
    {
        parent::__construct($dbConn);
    }

    /**
     * Store a new mandat in the database.
     *
     * @param Mandant $mandant
     * @return null id of the created mandat or {@code null}.
     */
    public function createMandant(Mandant $mandant)
    {
        $data = array(
            self::COL_PAGE_TITLE => $mandant->getPageTitle()
        );

        $sqlBuilder = $this->getSqlBuilder()->setData($data);

        return $this->sqlManager->insert($sqlBuilder);
    }

    /**
     * Delete an existing mandant in the database.
     *
     * @param Mandant $mandant
     * @return bool
     */
    public function deleteMandant(Mandant $mandant)
    {
        $cond = array(
            self::COL_MANDANT_ID => $mandant->getMandantId()
        );
        $sqlBuilder = $this->getSqlBuilder()->setConditions($cond);
        return $this->sqlManager->delete($sqlBuilder);
    }

    public function queryDefaultMandantForDomain($domain)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM galery_mandant WHERE domain = :domain')
            ->setConditions(array('domain' => $domain));

        return $this->fetchRow($sqlBuilder);
    }

    public function queryMandantForId($id)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM galery_mandant WHERE mandant_id = :id')
            ->setConditions(array('id' => $id));

        return $this->fetchRow($sqlBuilder);
    }

    /**
     * Converts a table row array into its object
     * representation.
     *
     * @param $row array
     * @return Mandant
     */
    protected function row2Object($row)
    {
        return new Mandant($row[self::COL_MANDANT_ID], $row[self::COL_PAGE_TITLE], $row[self::COL_GALERY_BRAND]);
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        // TODO: Implement getTableName() method.
    }
}