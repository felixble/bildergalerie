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
     * @var PicturePathDAO
     */
    private $picPathDAO;

    /**
     * @var CategoryDAO
     */
    private $categoryDAO;

    /**
     * PictureDAO constructor.
     * @param \Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
        $this->picTagMapDAO = new PicTagMapDAO($dbConn, $mandant);
        $this->picPathDAO = new PicturePathDAO($dbConn, $mandant);
        $this->categoryDAO = new CategoryDAO($dbConn, $mandant);
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
     * @param $picId
     * @return null
     */
    public function getPictureById($picId)
    {
        // when fetching a single picture by its id it stands to reason that we need all details of the picture.
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT t_pic.*,t_path.path,t_path.thumb_path,t_path.date_uploaded,category_name
                        FROM galery_pictures AS t_pic
                        LEFT JOIN galery_picture_path AS t_path ON t_pic.path_id=t_path.pic_path_id
                        LEFT JOIN galery_categories AS t_cat ON t_pic.category_id=t_cat.category_id
                        WHERE pic_id = :id;')
            ->setConditions(array("id" => $picId));

        return $this->fetchRow($sqlBuilder);
    }

    protected function row2Object($row)
    {
        // create the picture object with all primitive data.
        $picture = new Picture($this->mandant, $this->getValueOrNull($row, self::COL_PICTURE_ID),
            $this->getValueOrNull($row, self::COL_TITLE), $this->getValueOrNull($row, self::COL_DESCRIPTION),
            $this->getValueOrNull($row, self::COL_FORMAT), $this->getValueOrNull($row, self::COL_MATERIAL),
            $this->getValueOrNull($row, self::COL_PRICE), $this->getValueOrNull($row, self::COL_PRICE_PUBLIC),
            $this->getValueOrNull($row, self::COL_SALABLE), /*path*/ null,
            $this->getValueOrNull($row, self::COL_DATE_PRODUCED), $this->getValueOrNull($row, self::COL_DATE_CREATED),
            /*uploadedBy*/ null, /*owner*/ null, /*cat*/ null, /*artstyle*/ null, /*tags*/ null);

        // set all complex objects now

        $picture->setPath($this->picPathDAO->row2Object($row));
        $picture->setCategory($this->categoryDAO->row2Object($row));

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