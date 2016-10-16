<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 20.02.16
 * Time: 23:10
 */
class PicturePathDAO extends BaseMultiClientDAO
{
    const TABLE_NAME = "galery_picture_path";

    const COL_MANDANT_ID = "mandant_id";
    const COL_PIC_PATH_ID = "pic_path_id";
    const COL_PATH = "path";
    const COL_THUMB_PATH = "thumb_path";
    const COL_UID_UPLOADED_BY = "uid_uploaded_by";
    const COL_DATE_UPLOADED = "date_uploaded";

    /**
     * PicturePathDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
    }

    public function createPicturePath(PicturePath $path)
    {
        $data = array(
            self::COL_MANDANT_ID        => $this->mandant->getMandantId(),
            self::COL_PATH              => $path->getPath(),
            self::COL_THUMB_PATH        => $path->getThumbPath(),
            self::COL_UID_UPLOADED_BY   => $path->getUploadedBy()->getUserId()
        );

        return $this->create($data);
    }

    /**
     * @param $picPathId
     * @return bool
     */
    public function deletePicturePath($picPathId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_PIC_PATH_ID => $picPathId));

        return $this->sqlManager->delete($sqlBuilder);
    }

    /**
     * @param $picPathId
     * @return PicturePath|null
     */
    public function getPicturePathForId($picPathId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT * FROM galery_picture_path WHERE pic_path_id=:id")
            ->setConditions(array("id" => $picPathId));

        return $this->fetchRow($sqlBuilder);
    }

    /**
     * @return PicturePath[]
     */
    public function getUnlinkedPathes()
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT t_path.*, t_pic.pic_id FROM galery_picture_path AS t_path
                        LEFT JOIN galery_pictures AS t_pic ON t_path.pic_path_id = t_pic.path_id
                        WHERE t_pic.pic_id IS NULL;")
            ->setConditions(array("m_id" => $this->mandant->getMandantId()));

        return $this->fetchRowMany($sqlBuilder);
    }


    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }

    public function row2Object($row)
    {
        return new PicturePath($this->mandant, self::getValueOrNull($row, self::COL_PIC_PATH_ID),
            self::getValueOrNull($row, self::COL_PATH), self::getValueOrNull($row, self::COL_THUMB_PATH),
            /*uploadedby*/ null, self::getValueOrNull($row, self::COL_DATE_UPLOADED));
    }
}