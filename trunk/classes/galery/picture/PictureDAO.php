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
    const COL_DATE_PRODUCED = "date_produced";
    const COL_DATE_CREATED = "date_created";

    /**
     * @var PicTagMapDAO
     */
    private $picTagMapDAO;

    /**
     * PictureDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
        $this->picTagMapDAO = new PicTagMapDAO($dbConn, $mandant);
    }

    public function createPicture(Picture $picture)
    {
        $data = array(
            self::COL_MANDANT_ID        => $this->mandant->getMandantId(),
            self::COL_PATH_ID           => $picture->getPath()->getId(),
            self::COL_CATEGORY_ID       => $picture->getCategory()->getCategoryId(),
            self::COL_UID_UPLOADED_BY   => $picture->getUploadedBy()->getUserId(),
            self::COL_UID_OWNDER        => $picture->getOwner()->getUserId(),
            self::COL_TITLE             => $picture->getTitle(),
            self::COL_DESCRIPTION       => $picture->getDescription(),
            self::COL_MATERIAL          => $picture->getMaterial()
        );

        $picId = $this->create($data);

        if ($picId) {
            // the pic was created successfully, so we can insert the tags too.
            $this->picTagMapDAO->createEntries($picId, $picture->getTags());
        }

        return $picId;
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }
}