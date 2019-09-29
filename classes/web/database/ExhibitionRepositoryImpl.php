<?php


class ExhibitionRepositoryImpl implements \App\Exhibition\ExhibitionRepository
{ 
    private $dao;
    private $mandant;

    /**
     * ExhibitionRepositoryImpl constructor.
     * @param GaleryMysql $dbConn
     * @param Mandant $mandant
     */
    public function __construct(GaleryMysql $dbConn, Mandant $mandant)
    {
        $this->dao = new CategoryDAO($dbConn, $mandant);
        $this->mandant = $mandant;
    }


    /**
     * @param $id
     * @return void
     * @throws Exception
     * @throws SimpleUserErrorException
     */
    public function deleteExhibitionById($id)
    {
        $this->dao->deleteCateogry($id);
    }
  
 
    public function createOrUpdateExhibition($id, $name, $description)
    { 
        $category = new Category($this->mandant, $id, $name, $description );
        try {
            if (null != $id) {
                $this->dao->updateCategory($category);
                $catId = $id;
            } else {
                $catId = $this->dao->createCategory($category);
            }
        } catch(\Simplon\Mysql\MysqlException $e) {
            throw new Exception("Kategorie konnte nicht angelegt oder aktualisiert werden");
        }
        return $catId ;
    }


    /**
     * @param $mandant
     * @param $limit
     * @return mixed
     */
    public function listAllExhibitions($mandant, $limit)
    {
        return $this->dao->getCategoryTeasers($limit);
    }

    /**
     * @param $id
     * @return Category
     */
    public function getExhibition($id)
    {
        return $this->dao->getCategoryById($id);
    }
}