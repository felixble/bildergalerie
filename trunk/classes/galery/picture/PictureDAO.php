<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 22:55
 */
class PictureDAO extends BaseMultiClientDAO
{

    const TABLE_NAME = "galery_pictures";

    const COL_MANDANT_ID = "mandant_id";
    const COL_PICTURE_ID = "pic_id";
    const COL_PATH_ID = "path_id";
    const COL_STYLE_ID = "style_id";
    const COL_UID_CREATED_BY = "uid_created_by";
    const COL_UID_OWNDER = "uid_owner";
    const COL_TITLE = "title";
    const COL_DESCRIPTION = "description";
    const COL_FORMAT = "format";
    const COL_MATERIAL = "material";
    const COL_PRICE = "price";
    const COL_PRICE_PUBLIC = "price_public";
    const COL_SALABLE = "salable";
    const COL_DATE_PRODUCED = "date_produced";
    const COL_DATE_CREATED = "date_created";

    /**
     * @var PicTagMapDAO
     */
    private $picTagMapDAO;

    /**
     * @var PicturePathDAO
     */
    private $picPathDAO;

    /**
     * @var CategoryDAO
     */
    private $categoryDAO;

    /**
     * @var PicCatMapDAO
     */
    private $picCatMapDAO;

    /**
     * @var GaleryMysql
     */
    private $dbConn;

    /**
     * PictureDAO constructor.
     * @param GaleryMysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
        $this->dbConn = $dbConn;
        $this->picTagMapDAO = new PicTagMapDAO($dbConn, $mandant);
        $this->picPathDAO = new PicturePathDAO($dbConn, $mandant);
        $this->picCatMapDAO = new PicCatMapDAO($dbConn, $mandant);
        $this->categoryDAO = new CategoryDAO($dbConn, $mandant);
    }

    public function createPicture(Picture $picture)
    {
        $data = $this->object2array($picture);

        $picId = $this->create($data);

        if ($picId) {
            // the pic was created successfully, so we can insert the categories and tags too.
            $this->picCatMapDAO->createEntries($picId, $picture->getCategories());
            $this->picTagMapDAO->createEntries($picId, $picture->getTags());
        }

        return $picId;
    }

    public function updatePicture(Picture $picture)
    {
        $data = $this->object2array($picture);

        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_PICTURE_ID => $picture->getPictureId()))
            ->setData($data);

        $res = $this->sqlManager->update($sqlBuilder); // $res: bool|null, null iff nothing has been updated

        if (null == $res || $res) { // data was updated successfully or nothing has been updated
            //TODO update tag map if necessary...
            $this->picCatMapDAO->updateEntries($picture->getPictureId(), $picture->getCategories());
            $this->picTagMapDAO->updateEntries($picture->getPictureId(), $picture->getTags());
        }

        return $res;
    }

    private function object2array(Picture $picture)
    {
        return array(
            self::COL_MANDANT_ID        => $this->mandant->getMandantId(),
            self::COL_PATH_ID           => $picture->getPath()->getId(),
            self::COL_UID_CREATED_BY   => $picture->getUploadedBy()->getUserId(),
            self::COL_UID_OWNDER        => $picture->getOwner()->getUserId(),
            self::COL_TITLE             => $picture->getTitle(),
            self::COL_DESCRIPTION       => $picture->getDescription(),
            self::COL_MATERIAL          => $picture->getMaterial()
        );
    }

    /**
     * @param $picId
     * @return null|Picture
     */
    public function getPictureById($picId)
    {
        // when fetching a single picture by its id it stands to reason that we need all details of the picture.
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT t_pic.*,t_path.pic_path_id, t_path.path,t_path.thumb_path,t_path.date_uploaded
                        FROM galery_pictures AS t_pic
                        LEFT JOIN galery_picture_path AS t_path ON t_pic.path_id=t_path.pic_path_id
                        WHERE pic_id = :id;')
            ->setConditions(array("id" => $picId));

        /** @var Picture $picture */
        $picture = $this->fetchRow($sqlBuilder);
        if (null == $picture) return null;

        // TODO: Fetch all related categories (=exhibitions)
        // Fetch all related categories (=exhibitions)
        $categories = $this->categoryDAO->getCategoriesForPic($picId);
        $picture->addCategories($categories);

        // Fetch all related tags
        $tags = $this->picTagMapDAO->getTagsForPic($picId);
        $picture->setTags($tags);

        return $picture;
    }

    public function getPicturesFromCategory($categoryId, $fetchRelatedCategories = false)
    {
        if ($fetchRelatedCategories) {
            $query = 'SELECT t_cat_map.cat_id, t_pic.pic_id, t_cat_map.pic_id, t_pic.title, t_path.path,t_path.thumb_path,
                        GROUP_CONCAT(t_cat.category_name SEPARATOR \'\t\') as categories
                      FROM galery_pic_category_map AS t_cat_map
                      LEFT JOIN galery_pictures AS t_pic ON t_cat_map.pic_id=t_pic.pic_id
                      LEFT JOIN galery_picture_path AS t_path ON t_pic.path_id=t_path.pic_path_id
                      LEFT JOIN galery_categories AS t_cat ON t_cat_map.cat_id=t_cat.category_id
                      GROUP BY t_pic.pic_id';
        } else {
            $query = 'SELECT t_cat_map.cat_id, t_pic.pic_id, t_cat_map.pic_id, t_pic.title, t_path.path,t_path.thumb_path
                      FROM galery_pic_category_map AS t_cat_map
                      LEFT JOIN galery_pictures AS t_pic ON t_cat_map.pic_id=t_pic.pic_id
                      LEFT JOIN galery_picture_path AS t_path ON t_pic.path_id=t_path.pic_path_id
                      GROUP BY t_pic.pic_id';
        }

        $where = ($categoryId != -1) ? ' WHERE cat_id = :catId' : '';
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery($query . $where);
        if ($categoryId != -1) {
            $sqlBuilder->setConditions(array("catId" => $categoryId));
        }

        return $this->fetchRowMany($sqlBuilder);
    }

    public function deletePicture($picId)
    {
        $res = $this->dbConn->beginTransaction();
        if (!$res) throw new SimpleUserErrorException("Gemälde konnte nicht entfernt werden.");

        try {
            // first we fetch the picPathId before deleting the detail entry so we can delete the path entry as well
            $picPathId = $this->getPicturePathForPicture($picId);

            // then we delete the related entries in the tag_map table
            $this->picTagMapDAO->deleteTagsForPicId($picId);
            // we don't have to check the result value, if there are no tags related to the picture the result will be false

            // then we delete the related entries in the category_map table
            $this->picCatMapDAO->deleteCategoriesForPic($picId); // same as above

            // then we delete the picture details
            $res = $this->deletePictureDetails($picId);
            if (!$res) throw new SimpleUserErrorException("Gemälde konnte nicht entfernt werden.");

            // then we delete the picture path entry, but first we fetch the entry to get the path to the files
            $picPath = $this->picPathDAO->getPicturePathForId($picPathId);
            $res = $this->picPathDAO->deletePicturePath($picPathId);
            if (!$res) throw new SimpleUserErrorException("Gemälde konnte nicht entfernt werden.");

            // finally we have to delete the files (pic/thumb)
            $filePath = $picPath->getPath();
            if (null != $filePath && !empty($filePath)) {
                $res = unlink($filePath);
                if (!$res) throw new SimpleUserErrorException("Gemälde konnte nicht entfernt werden.");
            }
            $thumbFilePath = $picPath->getThumbPath();
            if (null != $thumbFilePath && !empty($thumbFilePath)) {
                unlink($thumbFilePath);
                // TODO: what shall we do if we could not delete the thumb file, at this point we cannot recover the original picture...
                //if (!$res) throw new SimpleUserErrorException("Gemälde konnte nicht entfernt werden.");
            }

            $this->dbConn->commitTransaction();
        } catch (Exception $e) {
            $this->dbConn->rollbackTransaction();
            throw $e;
        }

    }

    private function deletePictureDetails($picId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_PICTURE_ID => $picId));

        return $this->sqlManager->delete($sqlBuilder);
    }

    private function getPicturePathForPicture($picId)
    {
        $sqlBuilder= $this->getSqlBuilder()
            ->setQuery("SELECT pic_id, path_id AS pic_path_id FROM galery_pictures WHERE pic_id = :id")
            ->setConditions(array("id" => $picId));

        /** @var Picture $picture */
        $picture = $this->fetchRow($sqlBuilder);
        return $picture->getPath()->getId();
    }

    protected function row2Object($row)
    {
        // create the picture object with all primitive data.
        $picture = new Picture($this->mandant, $this->getValueOrNull($row, self::COL_PICTURE_ID), $this->getValueOrNull($row, self::COL_TITLE), $this->getValueOrNull($row, self::COL_DESCRIPTION), $this->getValueOrNull($row, self::COL_FORMAT), $this->getValueOrNull($row, self::COL_MATERIAL), $this->getValueOrNull($row, self::COL_PRICE), $this->getValueOrNull($row, self::COL_PRICE_PUBLIC), $this->getValueOrNull($row, self::COL_SALABLE), null, $this->getValueOrNull($row, self::COL_DATE_PRODUCED), $this->getValueOrNull($row, self::COL_DATE_CREATED), null, null, null, null);

        // set all complex objects now

        $picture->setCategoriesFromStringList($this->getValueOrNull($row, "categories"), "\t");

        $picture->setPath($this->picPathDAO->row2Object($row));

        return $picture;
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }
}