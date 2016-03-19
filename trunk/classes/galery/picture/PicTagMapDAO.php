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
     * Fetches all tags related to the
     * given ID of a pictures.
     *
     * @param $picId int the id of the picture
     * @return Tag[]
     */
    public function getTagsForPic($picId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT t_map.tag_id, t_tag.tag_name
                        FROM galery_pic_tag_map AS t_map
                        LEFT JOIN galery_tag AS t_tag ON t_map.tag_id=t_tag.tag_id
                        WHERE t_map.pic_id = :id;")
            ->setConditions(array("id" => $picId));
        // caution: we use the tagDAO-Object to fetch the rows because we want a tag array as result
        return $this->tagDAO->fetchRowMany($sqlBuilder);
    }

    /**
     * Deletes all tags related to the
     * given ID ofa picture
     *
     * @param $picId int the id of the picture
     * @return bool
     */
    public function deleteTagsForPicId($picId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_PIC_ID => $picId));

        return $this->sqlManager->delete($sqlBuilder);
    }

    public function updateEntries($picId, $tags)
    {
        // delete outdated existing entries
        $this->deleteTagsForPicId($picId);

        // create new entries
        $this->createEntries($picId, $tags);
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