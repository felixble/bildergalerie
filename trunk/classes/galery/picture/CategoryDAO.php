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

        return $this->fetchRowMany($sqlBuilder);
    }

    /**
     * Converts array representation of a category row
     * into a category object.
     *
     * @param $row
     * @return Category
     */
    protected function row2Object($row)
    {
        return new Category(
            $this->mandant,
            $this->getValueOrNull($row, self::COL_CATEGORY_ID),
            $this->getValueOrNull($row, self::COL_CATEGORY_NAME),
            $this->getValueOrNull($row, self::COL_CATEGORY_DESCRIPTION)
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