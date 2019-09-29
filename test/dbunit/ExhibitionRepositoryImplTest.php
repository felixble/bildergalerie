<?php
require(__DIR__ . '/DbTestCase.php');

use PHPUnit\DbUnit\TestCaseTrait;

class ExhibitionRepositoryImplTest extends DbTestCase
{
    use TestCaseTrait;

    const TABLE = 'galery_categories';

    /** @var \App\Exhibition\ExhibitionRepository */
    private $exhibitionRepo = null;

    /** @var Mandant */
    private $mandant = null;

    /**
     * @return \PHPUnit\DbUnit\DataSet\FlatXmlDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/fixtures/exhibition-seed.xml');
    }

    /**
     * @before
     */
    public function setupTestObject()
    {

        $this->mandant = new Mandant(1);
        $galeryDbConnection = new GaleryMysql(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
        $this->exhibitionRepo = new ExhibitionRepositoryImpl($galeryDbConnection, $this->mandant);
    }


    public function testDeleteShouldRemoveOneEntry()
    {
        $this->checkPrecondition();

        $this->exhibitionRepo->deleteExhibitionById(2);

        $this->assertEquals(1, $this->getConnection()->getRowCount(self::TABLE), "Delete failed");
    }

    public function testCreateOrUpdateExhibitionShouldAddNewExhibition()
    {
        $this->checkPrecondition();

        $this->exhibitionRepo->createOrUpdateExhibition(null, "New Exhibition", "A description");

        $this->assertEquals(3, $this->getConnection()->getRowCount(self::TABLE), "Inserting failed");
    }

    public function testCreateOrUpdateExhibitionShouldUpdateAnExistingExhibition()
    {
        $this->checkPrecondition();
        $this->exhibitionRepo->createOrUpdateExhibition(1, "Updated Exhibition 1", "Updated description");

        $this->assertEquals(2, $this->getConnection()->getRowCount(self::TABLE), "Updating failed");
        $dataSet = $this->getConnection()->createDataSet(['galery_categories']);
        $expectedDataSet = $this->createFlatXmlDataSet(dirname(__FILE__) . '/fixtures/exhibition-expected-update.xml');
        $this->assertDataSetsEqual($expectedDataSet, $dataSet);
    }

    public function testCreateOrUpdateExhibitionShouldThrow()
    {
        $this->expectException("Exception");
        $this->exhibitionRepo->createOrUpdateExhibition(null, null, null);
    }

    public function testListAllShouldReturnBothExhibitions()
    {
        $this->checkPrecondition();

        $exhibitions = $this->exhibitionRepo->listAllExhibitions($this->mandant, 2);
        $this->assertEquals(2, count($exhibitions), "Query failed");
    }

    public function testListAllShouldReturnOnlyOneExhibitions()
    {
        $this->checkPrecondition();

        $exhibitions = $this->exhibitionRepo->listAllExhibitions($this->mandant, 1);
        $this->assertEquals(1, count($exhibitions), "Query failed");
    }

    public function testGetShouldReturnTheDesiredExhibition()
    {
        $this->checkPrecondition();
        /** @var Category $exhibition */
        $exhibition = $this->exhibitionRepo->getExhibition(1);
        $this->assertEquals('Ausstellung 1', $exhibition->getCategoryName());
    }

    private function checkPrecondition()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount(self::TABLE), "Pre-Condition");
    }


}