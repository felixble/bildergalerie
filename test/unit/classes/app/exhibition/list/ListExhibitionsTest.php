<?php

namespace App\Exhibition\ListAll;

use App\Exhibition\ExhibitionRepository;
use App\Utils\InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListExhibitionsTest extends TestCase
{
    /** @var  ExhibitionRepository|MockObject */
    private $repositoryStub;

    /** @var ListAllExhibitions */
    private $listAllInteractor;

    /**
     * @before
     */
    public function setupTestobject()
    {
        $this->repositoryStub = $this->createMock(ExhibitionRepository::class);
        $this->listAllInteractor = new ListAllExhibitions($this->repositoryStub);
    }

    public function testShouldCallListAllMethodOfRepository()
    {
        $this->repositoryStub
            ->expects($this->once())
            ->method('listAllExhibitions')
            ->with($this->equalTo(1));
        $request = new Request();
        $request->mandant = 1;
        $this->listAllInteractor->listAll($request);
    }

    public function testListAllShouldThrowIfRequestDoesNotContainMandant()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->listAllInteractor->listAll(new Request());
    }

}