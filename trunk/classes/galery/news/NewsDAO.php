<?php

/**
 * Created by PhpStorm.
 * User: ottinm
 * Date: 20.03.2016
 * Time: 16:05
 */
class NewsDAO extends BaseMultiClientDAO
{


    const TABLE_NAME = "galery_news_articles";

    const COL_ARTICLE_ID = "article_id";
    const COL_MANDANT_ID = "mandant_id";
    const COL_CREATED_BY = "created_by";
    const COL_TITLE = "title";
    const COL_CONTENT = "content";
    const COL_DATE_CREATED = "date_Created";

    /**
     * @var GaleryMysql
     */
    private $dbConn;

    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
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

    public function createArticle (NewsArticle $newsArticle){
        $data = $this->object2array($newsArticle);

        return $this->sqlManager->insert($this->getSqlBuilder()->setData($data));

    }

    private function object2array(NewsArticle $newsArticle)
    {
        return array(
          self::COL_TITLE       => $newsArticle->getTitle(),
          self::COL_CONTENT     => $newsArticle->getContent(),
          self::COL_MANDANT_ID  => $this->mandant->getMandantId(),
          self::COL_CREATED_BY  => $newsArticle->getOwner()->getUserId()
        );
    }


}