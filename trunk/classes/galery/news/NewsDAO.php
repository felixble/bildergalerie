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

    const COL_ARTICLE_ID = "articel_id";
    const COL_MANDANT_ID = "mandant_id";
    const COL_CREATED_BY = "created_by";
    const COL_TITLE = "title";
    const COL_CONTENT = "content";
    const COL_DATE_CREATED = "date_created";

    /**
     * @var GaleryMysql
     */
    private $dbConn;

    /**
     * @var UserDAO
     */
    private $userDAO;

    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        parent::__construct($dbConn, $mandant);
        $this->userDAO = new UserDAO($dbConn, $mandant);
    }

    protected function row2Object($row)
    {
        $newsArticle = new NewsArticle($this->getValueOrNull($row, self::COL_TITLE), $this->getValueOrNull($row, self::COL_CONTENT),($this->userDAO->row2object($row)), $this->getValueOrNull($row,self::COL_ARTICLE_ID));
        $newsArticle->setDate($this->getValueOrNull($row, self::COL_DATE_CREATED));
        return $newsArticle;
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

    public function getArticles ()
    {
        $sqlbuilder = $this->getSqlBuilder()
            ->setQuery('SELECT art.*, user.user_id, user.first_name, user.last_name, art.date_created
                        FROM galery_news_articles AS art
                        LEFT JOIN galery_user AS user ON art.created_by = user.user_id
                        WHERE art.mandant_id = :id;')
            ->setConditions(array("id" => $this->mandant->getMandantId()));

         return $newsArticles = $this->fetchRowMany($sqlbuilder);
    }

    /**
     * @return NewsArticle|null
     */
    public function getLatestArticle()
    {
        $sqlbuilder = $this->getSqlBuilder()
            ->setQuery('SELECT art.*, user.user_id, user.first_name, user.last_name, art.date_created
                        FROM galery_news_articles AS art
                        LEFT JOIN galery_user AS user ON art.created_by = user.user_id
                        WHERE art.mandant_id = :id
                        ORDER BY art.date_created DESC
                        LIMIT 1;')
            ->setConditions(array("id" => $this->mandant->getMandantId()));

        return $newsArticles = $this->fetchRow($sqlbuilder);
    }

    public function deleteArticle($articleId)
    {
      //  if (!$res) throw new SimpleUserErrorException("Artikel konnte nicht entfernt werden.");

        try {
            $sqlBuilder = $this->getSqlBuilder()
                ->setConditions(array(self::COL_ARTICLE_ID => $articleId));
            return $this->sqlManager->delete($sqlBuilder);
        } catch (Exception $e) {
            $this->dbConn->rollbackTransaction();
            throw $e;
        }

    }

    public function updateArticle(NewsArticle $article)
    {
        $data = $this->object2array($article);

        $sqlBuilder = $this->getSqlBuilder()
            ->setConditions(array(self::COL_ARTICLE_ID => $article->getId()))
            ->setData($data);

        $res = $this->sqlManager->update($sqlBuilder); // $res: bool, false iff nothing has been updated

        return $res;
    }

    public function getArticleById($articleId)
    {

        $sqlBuilder = $this->getSqlBuilder()
            ->setQuery('SELECT art.*
                        FROM galery_news_articles AS art
                        WHERE art.articel_id = :id;')
            ->setConditions(array("id" => $articleId));

        /** @var NewsArticle $article */
        $article = $this->fetchRow($sqlBuilder);

        return $article;
    }
}