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
    const COL_TAG_ID = "cat_id";

    /**
     * @var TagDAO
     */
    private $categoryDAO;


    /**
     * PicTagMapDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn);
        $this->categoryDAO = new TagDAO($dbConn, $mandant);
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
            self::COL_TAG_ID    => $category->getCategoryId()
        );

        return $this->create($data);
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