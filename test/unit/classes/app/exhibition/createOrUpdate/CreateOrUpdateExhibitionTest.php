<?php

namespace App\Exhibition\CreateOrUpdate;

use App\Exhibition\ExhibitionRepository;
use App\Utils\Authenticator;
use App\Utils\InvalidArgumentException;
use App\Utils\NotAuthorizedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateOrUpdateExhibitionTest extends TestCase
{
 
    /**
     * @var CreateOrUpdateExhibition
     */
    private $interactor;

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
        $this->interactor = new CreateOrUpdateExhibition($this->authenticatorStub, $this->repositoryStub);
    }

    public function testCreateOrUpdateShouldThrowIfRequestDoesNotContainId()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->setIsAuthorized();
        $this->interactor->createOrUpdate(new Request());
    }

    public function testCreateOrUpdateShouldThrowIfNotAuthorized()
    {
        $this->expectException(NotAuthorizedException::class);
        $this->interactor->createOrUpdate(new Request());
    }

    public function testShouldCallCreateOrUpdateMethodOfRepository()
    {
        $this->setIsAuthorized();
        $this->repositoryStub
            ->expects($this->once())
            ->method('createOrUpdateExhibition')
            ->with(
                $this->equalTo(42),
                $this->equalTo("some name here"), 
                $this->equalTo("some description here")
            );
        $request = new Request();
        $request->id = 42;
        $request->name = "some name here";
        $request->description = "some description here";
        $this->interactor->createOrUpdate($request);
    }

    private function setIsAuthorized()
    {
        $this->authenticatorStub
            ->method('isAuthenticated')
            ->willReturn(true);
    }

}