<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 21.02.16
 * Time: 19:39
 */
class TagDAO extends BaseMultiClientDAO
{

    const TABLE_NAME = "galery_tag";

    const COL_MANDANT_ID = "mandant_id";
    const COL_TAG_ID = "tag_id";
    const COL_TAG_NAME = "tag_name";


    /**
     * TagDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
    }

    /**
     * @param Tag $tag
     * @return bool|int
     */
    public function createTag(Tag $tag)
    {
        $data = array(
            self::COL_MANDANT_ID    => $this->mandant->getMandantId(),
            self::COL_TAG_NAME      => $tag->getTagName()
        );

        return $this->create($data);
    }

    /**
     * @param $tagName
     * @return null|Tag
     */
    public function queryTagForName($tagName)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT * FROM galery_tag WHERE mandant_id = :mandant AND tag_name = :name")
            ->setConditions(array('name' => $tagName, 'mandant' => $this->mandant->getMandantId()));

        $row = $this->sqlManager->fetchRow($sqlBuilder);

        if ($this->sqlManager->getRowCount()) {
            return $this->row2object($row);
        }
        return null;
    }

    public function queryTagForId($tagId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT * FROM galery_tag WHERE tag_id = :id")
            ->setConditions(array('id' => $tagId));

        $row = $this->sqlManager->fetchRow($sqlBuilder);

        if ($this->sqlManager->getRowCount()) {
            return $this->row2object($row);
        }
        return null;
    }

    /**
     * @return Tag[]
     */
    public function queryForAll()
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT * FROM galery_tag WHERE mandant_id = :mandant")
            ->setConditions(array('mandant' => $this->mandant->getMandantId()));

        return $this->fetchRowMany($sqlBuilder);
    }

    /**
     * @param $row
     * @return Tag
     */
    protected function row2Object($row)
    {
        return new Tag($this->mandant, $row[self::COL_TAG_ID], $row[self::COL_TAG_NAME]);
    }

    /**
     * @param Tag $tag
     * @return bool|int tagId
     */
    public function createTagIfNotExists(Tag $tag)
    {
        $existingTag = $this->queryTagForName($tag->getTagName());
        if (null == $existingTag) {
            // tag does not exist
            return $this->createTag($tag);
        }

        return $existingTag->getTagId();
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }
}