<?php

/**
 * Created by PhpStorm.
 * User: Felix
 * Date: 12.02.2016
 * Time: 15:24
 */
class MandantDAO
{

    const TABLE_NAME = "galery_mandant";

    const COL_MANDANT_ID = "mandant_id";
    const COL_PAGE_TITLE = "page_title";
    const COL_DOAMIN = "domain";

    /**
     * @var Simplon\Mysql\Manager\SqlManager
     */
    private $sqlManager;

    /**
     * MandantDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn)
    {
        $this->sqlManager = new \Simplon\Mysql\Manager\SqlManager($dbConn);
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

    private function getSqlBuilder()
    {
        $sqlBuilder = new Simplon\Mysql\Manager\SqlQueryBuilder();

        $sqlBuilder->setTableName(self::TABLE_NAME);
        return $sqlBuilder;
    }

    public function queryDefaultMandantForDomain($domain)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery(sprintf('SELECT * FROM %s WHERE %s = :domain', self::TABLE_NAME, self::COL_DOAMIN))
            ->setConditions(array('domain' => $domain));

        $row = $this->sqlManager->fetchRow($sqlBuilder);

        if ($this->sqlManager->getRowCount()) {
            return new Mandant($row[self::COL_MANDANT_ID], $row[self::COL_PAGE_TITLE]);
        }
        return null;
    }

}