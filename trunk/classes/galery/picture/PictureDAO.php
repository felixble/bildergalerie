<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 19.02.16
 * Time: 22:55
 */
class PictureDAO
{

    const TABLE_NAME = "galery_pictures";

    const COL_MANDANT_ID = "mandant_id";
    const COL_PICTURE_ID = "pic_id";
    const COL_CATEGORY_ID = "category_id";
    const COL_STYLE_ID = "style_id";
    const COL_UID_UPLOADED_BY = "uid_uploaded_by";
    const COL_UID_OWNDER = "uid_owner";
    const COL_TITLE = "title";
    const COL_DESCRIPTION = "description";
    const COL_FORMAT = "format";
    const COL_MATERIAL = "material";
    const COL_PRICE = "price";
    const COL_PRICE_PUBLIC = "price_public";
    const COL_SALABLE = "salable";
    const COL_PATH = "path";
    const COL_PATH_THUMB = "path_thumb";
    const COL_DATE_PRODUCED = "date_produced";
    const COL_DATE_UPLOADED = "date_uploaded";

    /**
     * @var Simplon\Mysql\Manager\SqlManager
     */
    private $sqlManager;

    /**
     * Current mandant
     *
     * @var Mandant
     */
    private $mandant;

    /**
     * PictureDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        $this->sqlManager = new \Simplon\Mysql\Manager\SqlManager($dbConn);
        $this->mandant = $mandant;
    }

    public function createPicture(Picture $picture)
    {
        $data = array(
            self::COL_MANDANT_ID        => $this->mandant->getMandantId(),
            self::COL_CATEGORY_ID       => $picture->getCategory()->getCategoryId(),
            self::COL_UID_UPLOADED_BY   => $picture->getUploadedBy()->getUserId(),
            self::COL_UID_OWNDER        => $picture->getOwner()->getUserId(),
            self::COL_TITLE             => $picture->getTitle(),
            self::COL_DESCRIPTION       => $picture->getDescription(),
            self::COL_MATERIAL          => $picture->getMaterial()
        );

        $sqlBuilder = $this->getSqlBuilder()->setData($data);

        return $this->sqlManager->insert($sqlBuilder);
    }


    private function getSqlBuilder()
    {
        $sqlBuilder = new Simplon\Mysql\Manager\SqlQueryBuilder();

        $sqlBuilder->setTableName(self::TABLE_NAME);
        return $sqlBuilder;
    }

}