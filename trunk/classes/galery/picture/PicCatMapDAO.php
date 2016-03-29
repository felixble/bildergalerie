<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.02.16
 * Time: 19:54
 */
class PicCatMapDAO extends BaseDAO
{

    const TABLE_NAME = "galery_pic_category_map";

    const COL_PIC_ID = "pic_id";
    const COL_CAT_ID = "cat_id";


    /**
     * PicTagMapDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn);
    }

    /**
     * @param $picId
     * @param $categories Category[]
     */
    public function createEntries($picId, $categories)
    {
        foreach ($categories as $category) {
            $this->createEntry($picId, $category);
        }
    }

    public function createEntry($picId, Category $category)
    {
        $data = array(
            self::COL_PIC_ID    => $picId,
            self::COL_CAT_ID    => $category->getCategoryId()
        );

        return $this->create($data);
    }

    public function updateEntries($picId, $categories)
    {
        // delete outdated existing entries
        $this->deleteCategoriesForPic($picId);

        // create new entries
        $this->createEntries($picId, $categories);
    }

    /**
     * Deletes all categories related to the given
     * picture id.
     *
     * @param $picId
     * @return bool
     */
    public function deleteCategoriesForPic($picId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_PIC_ID => $picId));

        return $this->sqlManager->delete($sqlBuilder);
    }

    /**
     * Deletes all entries related to the given
     * category id.
     * Some pictures could then be without any
     * related category!
     *
     * @param $catId
     * @return bool
     */
    public function deleteEntriesForCatId($catId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_CAT_ID => $catId));

        return $this->sqlManager->delete($sqlBuilder);
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }

    protected function row2Object($row)
    {
        // The picTagMapTable does not have any object representation
        throw new NotImplementedException("This method is not implemented because it is not necessary right now.");
    }
}