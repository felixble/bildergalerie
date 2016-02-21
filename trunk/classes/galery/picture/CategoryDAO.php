<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 20:16
 */
class CategoryDAO extends BaseMultiClientDAO
{

    const TABLE_NAME = "galery_categories";

    const COL_CATEGORY_ID = "category_id";
    const COL_CATEGORY_NAME = "category_name";
    const COL_CATEGORY_DESCRIPTION = "description";

    /**
     * CategoryDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
    }

    /**
     * Returns all categories for the current mandant.
     *
     * @return Category[]
     */
    public function getAllCategories() {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM galery_categories WHERE mandant_id =:m_id')
            ->setConditions(array("m_id" => $this->mandant->getMandantId()));

        $rows = $this->sqlManager->fetchRowMany($sqlBuilder);
        $result = array();
        if ($this->sqlManager->getRowCount()) {
            foreach ($rows as $row) {
                $result[] = $this->row2Category($row);
            }
        }
        return $result;
    }

    /**
     * Converts array representation of a category row
     * into a category object.
     *
     * @param $row
     * @return Category
     */
    private function row2Category($row)
    {
        return new Category(
            $this->mandant,
            $row[self::COL_CATEGORY_ID],
            $row[self::COL_CATEGORY_NAME],
            $row[self::COL_CATEGORY_DESCRIPTION]
        );
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }
}