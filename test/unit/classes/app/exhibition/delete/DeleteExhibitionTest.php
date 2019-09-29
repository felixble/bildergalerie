<?php

namespace App\Exhibition\Delete;

use App\Exhibition\ExhibitionRepository;
use App\Utils\Authenticator;
use App\Utils\InvalidArgumentException;
use App\Utils\NotAuthorizedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteExhibitionTest extends TestCase
{

    /**
     * @var DeleteExhibition
     */
    private $deleteInteractor;

    /**
     * @var Authenticator|MockObject
     */
    private $authenticatorStub;

    /** @var  ExhibitionRepository|MockObject */
    private $repositoryStub;

    /**
     * @before
     */
    public function setupTestobject()
    {
        $this->authenticatorStub = $this->createMock(Authenticator::class);
        $this->repositoryStub = $this->createMock(ExhibitionRepository::class);

        $this->deleteInteractor = new DeleteExhibition($this->authenticatorStub, $this->repositoryStub);
    }

    public function testDeleteShouldThrowIfRequestDoesNotContainId()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->setIsAuthorized();
        $this->deleteInteractor->delete(new Request());
    }

    public function testDeleteShouldThrowIfNotAuthorized()
    {
        $this->expectException(NotAuthorizedException::class);
        $this->deleteInteractor->delete(new Request());
    }

    public function testShouldCallDeleteMethodOfRepository()
    {
        $this->setIsAuthorized();
        $this->repositoryStub
            ->expects($this->once())
            ->method('deleteExhibitionById')
            ->with($this->equalTo(5));
        $request = new Request();
        $request->id = 5;
        $this->deleteInteractor->delete($request);
    }

    private function setIsAuthorized()
    {
        $this->authenticatorStub
            ->method('isAuthenticated')
            ->willReturn(true);
    }

}