<?php

namespace App\Picture\Create;

use App\Picture\PictureRepository;
use App\Utils\Authenticator;
use App\Utils\NotAuthorizedException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CreatePictureTest extends TestCase
{

    /** @var CreatePicture */
    private $createInteractor;

    /** @var Authenticator | MockObject */
    private $authenticatorStub;

    /** @var PictureRepository | MockObject */
    private $repositoryStub;

    /** @var \User | MockObject */
    private $userStub;

    /** @var \Mandant | MockObject */
    private $mandantStub;

    /**
     * @before
     */
    public function setupTestobject()
    {
        $this->authenticatorStub = $this->createMock(Authenticator::class);
        $this->repositoryStub = $this->createMock(PictureRepository::class);
        $this->userStub = $this->createMock(\User::class);
        $this->mandantStub = $this->createMock(\Mandant::class);

        $this->createInteractor = new CreatePicture($this->authenticatorStub, $this->repositoryStub);
    }

    public function testCreateShouldThrowIfNotAuthorized()
    {
        $this->expectException(NotAuthorizedException::class);
        $this->createInteractor->create(new Request());
    }

    public function testShouldCallCreatePictureMethodOfRepository()
    {
        $this->setIsAuthorized();
        $this->repositoryStub
            ->expects($this->once())
            ->method('createPicture')
            ->with($this->callback(function($picture) {
                return $picture->getTitle() == 'Ein Gemälde';
            }));
        $request = new Request();
        $request->title = "Ein Gemälde";
        $request->tags = null;
        $request->descr = "Eine Beschreibung";
        $request->material = "Das Material";
        $request->picPathId = "/uploads/1/image001.png";
        $request->uploadedBy = $this->userStub;
        $request->owner = $this->userStub;
        $request->mandant = $this->mandantStub;
        $request->categoryIds = [1];
        $this->createInteractor->create($request);
    }

    public function testShouldThrowIfTitleIsNull()
    {
        $this->setIsAuthorized();
        $this->expectException(\InvalidInputException::class);
        $request = new Request();
        $request->tags = null;
        $request->descr = "Eine Beschreibung";
        $request->material = "Das Material";
        $request->picPathId = "/uploads/1/image001.png";
        $request->uploadedBy = $this->userStub;
        $request->owner = $this->userStub;
        $request->mandant = $this->mandantStub;
        $request->categoryIds = [1];
        $this->createInteractor->create($request);

    }

    /**public function testShouldThrowIfPathIsNull()
    {
        $this->setIsAuthorized();
        $this->expectException(\InvalidInputException::class);
        $request = new Request();
        $request->title = "Ein Gemälde";
        $request->tags = null;
        $request->descr = "Eine Beschreibung";
        $request->material = "Das Material";
        $request->uploadedBy = $this->userStub;
        $request->owner = $this->userStub;
        $request->mandant = $this->mandantStub;
        $request->categoryIds = [1];
        $this->createInteractor->create($request);
    }**/
    /**public function testShouldThrowIfMandantIsNull()
    {
        $this->expectException(\IllegalStateException::class);
        $this->setIsAuthorized();
        $request = new Request();
        $request->title = "Ein Gemälde";
        $request->tags = null;
        $request->descr = "Eine Beschreibung";
        $request->material = "Das Material";
        $request->picPathId = "/uploads/1/image001.png";
        $request->uploadedBy = $this->userStub;
        $request->owner = $this->userStub;
        $request->categoryIds = [1];
        $request->mandant = null;
        $this->createInteractor->create($request);
    }**/

    private function setIsAuthorized()
    {
        $this->authenticatorStub
            ->method('isAuthenticated')
            ->willReturn(true);
    }
}