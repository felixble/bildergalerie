<?php

namespace App\Exhibition\Get;

use App\Exhibition\ExhibitionRepository;
use App\Utils\InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetExhibitionTest extends TestCase
{
    /** @var  ExhibitionRepository|MockObject */
    private $repositoryStub;

    /** @var GetExhibition */
    private $getInteractor;

    /**
     * @before
     */
    public function setupTestobject()
    {
        $this->repositoryStub = $this->createMock(ExhibitionRepository::class);
        $this->getInteractor = new GetExhibition($this->repositoryStub);
    }

    public function testShouldCallGetMethodOfRepository()
    {
        $this->repositoryStub
            ->expects($this->once())
            ->method('getExhibition')
            ->with($this->equalTo(1));
        $request = new Request();
        $request->id = 1;
        $this->getInteractor->get($request);
    }

    public function testGetShouldThrowIfRequestDoesNotContainId()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->getInteractor->get(new Request());
    }

}