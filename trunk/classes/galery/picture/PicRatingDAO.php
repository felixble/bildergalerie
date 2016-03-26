<?php

/**
 * Created by PhpStorm.
 * User: felix
 * Date: 26.03.16
 * Time: 16:07
 */
class PicRatingDAO extends BaseDAO
{

    const TABLE_NAME = "galery_pic_rating";

    const COL_RATING_ID = "rating_id";
    const COL_PIC_ID = "ref_pic_id";
    const COL_RATING_VALUE = "rating_value";
    const COL_VISITOR_ID = "visitor_rating_id";

    /**
     * @var PictureDAO
     */
    private $pictureDAO;

    /**
     * PicRatingDAO constructor.
     * @param GaleryMysql|\Simplon\Mysql\Mysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(\Simplon\Mysql\Mysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn);
        $this->pictureDAO = new PictureDAO($dbConn, $mandant);
    }


    /**
     * Create a new voting entry and returns
     * the auto increment id value.
     *
     * @param $picId
     * @param $votingValue
     * @param $visitorId
     * @return bool|int
     * @throws IllegalStateException
     */
    public function createVotingEntry($picId, $votingValue, $visitorId) {
        // first we check if the picture id exists.
        if (!$this->pictureDAO->checkPictureExists($picId)) {
            throw new IllegalStateException(sprintf("Das Bild mit der Id %s existiert nicht.", $picId));
        }

        $data = $this->getRowArray($picId, $votingValue, $visitorId);

        return $this->create($data);
    }

    public function getRatingIdForVisitor($visitorRatingId, $picId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT rating_id FROM galery_pic_rating
                        WHERE visitor_rating_id = :id AND ref_pic_id = :pid;")
            ->setConditions(array("id" => $visitorRatingId, "pid" => $picId));

        $row = $this->sqlManager->fetchRow($sqlBuilder);
        if (!$this->sqlManager->getRowCount()) return null;
        return $row["rating_id"];
    }

    public function getOverallRatingForPic($picId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery("SELECT ROUND(AVG(rating_value), 1) AS overall_rating_value FROM galery_pic_rating WHERE ref_pic_id = :pid;")
            ->setConditions(array("pid" => $picId));

        $row = $this->sqlManager->fetchRow($sqlBuilder);
        return $row["overall_rating_value"];
    }

    public function updateVotingEntry($ratingeValue, $ratingId)
    {
        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_RATING_ID => $ratingId))
            ->setData(array(self::COL_RATING_VALUE => $ratingeValue));

        return $this->sqlManager->update($sqlBuilder);
    }

    private function getRowArray($picId, $votingValue, $visitorId) {
        return array(
            self::COL_PIC_ID        => $picId,
            self::COL_RATING_VALUE  => $votingValue,
            self::COL_VISITOR_ID    => $visitorId
        );
    }

    protected function row2Object($row)
    {
        // TODO: Implement row2Object() method.
    }

    /**
     * @return string table name.
     */
    protected function getTableName()
    {
        return self::TABLE_NAME;
    }
}