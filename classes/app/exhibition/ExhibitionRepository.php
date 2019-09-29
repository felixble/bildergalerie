<?php


namespace App\Exhibition; 


interface ExhibitionRepository
{

    /**
     * @param $id
     * @return void
     */
    public function deleteExhibitionById($id);

    /** 
     * @param $id null for create operation, value for update operation
     * @param $name 
     * @param $description 
     * @return id of the exhibition
     */
    public function createOrUpdateExhibition($id, $name, $description);

    /**
     * @param $id
     * @return mixed
     */
    public function getExhibition($id);

    /**
     * @param $mandant
     * @param $limit
     * @return mixed
     */
    public function listAllExhibitions($mandant, $limit);
}