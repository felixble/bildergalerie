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

    const COL_MANDANT_ID = "mandant_id";
    const COL_CATEGORY_ID = "category_id";
    const COL_CATEGORY_NAME = "category_name";
    const COL_CATEGORY_DESCRIPTION = "description";

    /**
     * @var GaleryMysql
     */
    private $dbConn;

    /**
     * CategoryDAO constructor.
     * @param GaleryMysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
        $this->dbConn = $dbConn;
    }

    /**
     * Returns all categories for the current mandant.
     * Containing the number of related pictures.
     *
     * @return Category[]
     */
    public function getAllCategories() {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT t_cat.*, COUNT(t_map.pic_id) AS number_related_pictures FROM galery_categories AS t_cat
                        LEFT JOIN galery_pic_category_map AS t_map ON t_cat.category_id=t_map.cat_id
                        WHERE mandant_id =:m_id
                        GROUP BY category_id
                        ORDER BY t_cat.category_name ASC')
            ->setConditions(array("m_id" => $this->mandant->getMandantId()));

        return $this->fetchRowMany($sqlBuilder);
    }


    /**
     * @param int|false $limit
     * @return array
     */
    public function getCategoryTeasers($limit = 3) {
        $add_limit = "";
        $conditions = array("m_id" => $this->mandant->getMandantId());
        if (is_numeric($limit)) {
            $add_limit = " LIMIT :limit";
            $conditions['limit'] = $limit;
        }
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM bildergalerie.galery_categories AS t_cat
                        LEFT JOIN
                          (SELECT t_pic.pic_id, title, path_id, cat_id FROM galery_pic_category_map t_map
                            LEFT JOIN galery_pictures AS t_pic ON t_pic.pic_id=t_map.pic_id
                            ORDER BY RAND()) AS t_pic ON t_pic.cat_id=t_cat.category_id
                        LEFT JOIN galery_picture_path AS t_path ON t_pic.path_id=t_path.pic_path_id
                        WHERE t_cat.mandant_id =:m_id AND t_pic.pic_id IS NOT NULL
                        GROUP BY t_cat.category_id' . $add_limit
                        . ' ORDER BY t_cat.category_id DESC;')
            ->setConditions($conditions);

        $rows = $this->sqlManager->fetchRowMany($sqlBuilder);
        $result = array();
        if ($this->sqlManager->getRowCount()) {
            foreach ($rows as $row) {
                $result[] = $this->row2Teaser($row);
            }
        }
        return $result;
    }

    /**
     * @param $id
     * @return Category
     */
    public function getCategoryById($id)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT * FROM galery_categories WHERE category_id = :id;')
            ->setConditions(array('id' => $id));

        return $this->fetchRow($sqlBuilder);

    }

    public function getCategoriesForPic($picId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT t_map.cat_id, t_cat.category_name, t_cat.category_id
                        FROM galery_pic_category_map AS t_map
                        LEFT JOIN galery_categories AS t_cat ON t_map.cat_id = t_cat.category_id
                        WHERE t_map.pic_id = :id")
            ->setConditions(array('id' => $picId));

        return $this->fetchRowMany($sqlBuilder);
    }

    /**
     * Creates a new category entry.
     *
     * @param Category $category
     * @return bool|int
     */
    public function createCategory(Category $category)
    {
        $data = $this->object2Array($category);

        return $this->create($data);
    }

    /**
     * @param Category $category
     * @return bool|null null iff nothing has been updated
     */
    public function updateCategory(Category $category)
    {
        $data = $this->object2Array($category);

        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_CATEGORY_ID => $category->getCategoryId()))
            ->setData($data);

        return $this->sqlManager->update($sqlBuilder);
    }

    public function deleteCateogry($categoryId)
    {
        $res = $this->dbConn->beginTransaction();
        if (!$res) throw new SimpleUserErrorException("Ausstellung konnte nicht entfernt werden.");

        try {
            // first we delete all related entries in the pic_cat_map
            $picCatMapDAO = new PicCatMapDAO($this->dbConn, $this->mandant);
            $picCatMapDAO->deleteEntriesForCatId($categoryId);
            // we don't have to check the result value, if there are no pics related to the category the result will be false

            // then we can delete the category itself
            $sqlBuilder = $this->getSqlBuilder()
                ->setConditions(array(self::COL_CATEGORY_ID => $categoryId));

            $res = $this->sqlManager->delete($sqlBuilder);
            // now we check the result, because there should be exactly one entry to be deleted.
            if (!$res) throw new SimpleUserErrorException("Ausstellung konnte nicht entfernt werden.");

            $res = $this->dbConn->commitTransaction();
            if (!$res) throw new SimpleUserErrorException("Ausstellung konnte nicht entfernt werden.");
        } catch (Exception $e) {
            $this->dbConn->rollbackTransaction();
            throw $e;
        }
    }

    protected function object2Array(Category $category)
    {
        return array(
            self::COL_MANDANT_ID            => $this->mandant->getMandantId(),
            self::COL_CATEGORY_NAME         => $category->getCategoryName(),
            self::COL_CATEGORY_DESCRIPTION  => $category->getDescription()
        );
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
        $relatedPictures = $this->getValueOrNull($row, "number_related_pictures");

        return new Category(
            $this->mandant,
            $this->getValueOrNull($row, self::COL_CATEGORY_ID),
            $this->getValueOrNull($row, self::COL_CATEGORY_NAME),
            $this->getValueOrNull($row, self::COL_CATEGORY_DESCRIPTION),
            $relatedPictures
        );
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }

    private function row2Teaser($row)
    {
        $category = new Category($this->mandant, $row[self::COL_CATEGORY_ID], $row[self::COL_CATEGORY_NAME],
            $row[self::COL_CATEGORY_DESCRIPTION]);

        $picture = new Picture($this->mandant, $row[PictureDAO::COL_PICTURE_ID], $row[PictureDAO::COL_TITLE], $category);
        $picture->setPath(
            new PicturePath($this->mandant, $row[PicturePathDAO::COL_PIC_PATH_ID],
                $row[PicturePathDAO::COL_PATH], $row[PicturePathDAO::COL_THUMB_PATH])
        );

        return new CategoryTeaser($category, $picture);
    }
}