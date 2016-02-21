<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.02.16
 * Time: 19:54
 */
class PicTagMapDAO extends BaseDAO
{

    const TABLE_NAME = "galery_pic_tag_map";

    const COL_PIC_ID = "pic_id";
    const COL_TAG_ID = "tag_id";

    /**
     * @var TagDAO
     */
    private $tagDAO;


    /**
     * PicTagMapDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn);
        $this->tagDAO = new TagDAO($dbConn, $mandant);
    }

    /**
     * @param $picId
     * @param $tags Tag[]
     */
    public function createEntries($picId, $tags)
    {
        foreach ($tags as $tag) {
            $this->createEntry($picId, $tag);
        }
    }

    public function createEntry($picId, Tag $tag)
    {
        $tagId = $this->tagDAO->createTagIfNotExists($tag);

        $data = array(
            self::COL_PIC_ID    => $picId,
            self::COL_TAG_ID    => $tagId
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
}