<?php

namespace App\Picture\Upload;

use App\Picture\PictureRepository;
use App\Picture\PictureUploader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UploadPictureTest extends TestCase
{
    /** @var UploadPicture */
    private $uploadInteractor;

    /** @var PictureRepository | MockObject */
    private $repositoryStub;

    /**
     * @var \Mandant | MockObject
     */
    private $mandantStub;

    /**
     * @var \User | MockObject
     */
    private $userStub;

    /**
     * @var PictureUploader | MockObject
     */
    private $picturerUploaderStub;

    private $dummyFile = array(
        "tmp_name" => "twitter.png",
        "name" => "twitter"
    );

    /**
     * @before
     */
    public function setupTestobject()
    {
        $this->repositoryStub = $this->createMock(PictureRepository::class);
        $this->picturerUploaderStub = $this->createMock(PictureUploader::class);
        $this->uploadInteractor = new UploadPicture($this->repositoryStub, $this->picturerUploaderStub);
        $this->mandantStub = $this->createMock(\Mandant::class);
        $this->userStub = $this->createMock(\User::class);
    }

    public function testShouldCallUploadPictureMethodOfRepository()
    {
        $this->setReturnValueForFileUpload();
        $this->repositoryStub
            ->expects($this->once())
            ->method('savePicturePath');

        $this->uploadInteractor->upload($this->createRequest());
    }

    public function testShouldCallUploadFileMethodOfPictureUploaderWithTheGivenFile()
    {
        $this->setReturnValueForFileUpload();
        $this->picturerUploaderStub
            ->expects($this->once())
            ->method('uploadFile')
            ->with($this->equalTo($this->dummyFile));

        $this->uploadInteractor->upload($this->createRequest());
    }

    public function testShouldDeleteTheUploadedPictureAgainIfThePathCouldNotBeSaved()
    {
        $this->setReturnValueForFileUpload();
        $this->setReturnValueForSavePicturePath(false);

        $this->picturerUploaderStub
            ->expects($this->once())
            ->method('deleteUploadedFiles');

        $this->uploadInteractor->upload($this->createRequest());
    }

    public function testShouldReturnTrueIfUploadAndSaveWasSuccessful()
    {
        $this->setReturnValueForFileUpload();
        $this->setReturnValueForSavePicturePath();
        $response = $this->uploadInteractor->upload($this->createRequest());
        $this->assertEquals(true, $response->success);
    }

    public function testShouldReturnFalseIfThePathCouldNotBeSaved()
    {
        $this->setReturnValueForFileUpload();
        $this->setReturnValueForSavePicturePath(false);

        $response = $this->uploadInteractor->upload($this->createRequest());
        $this->assertEquals(false, $response->success);
    }

    public function testShouldReturnFalseIfTheFileUploadWasNotSuccessful()
    {
        $this->setReturnValueForFileUpload(false);
        $this->picturerUploaderStub
            ->method('uploadFile')
            ->willReturn(false);
        $response = $this->uploadInteractor->upload($this->createRequest());
        $this->assertEquals(false, $response->success);
    }

    public function testShouldReturnThePicturePathId()
    {
        $this->setReturnValueForFileUpload();
        $picPathId = 5;
        $this->setReturnValueForSavePicturePath($picPathId);
        $response = $this->uploadInteractor->upload($this->createRequest());
        $this->assertEquals($picPathId, $response->picPathId);
    }

    public function testShouldReturnThePicturePath()
    {
        $this->setReturnValueForFileUpload();
        $dummyFilePath = 'filePath';
        $this->picturerUploaderStub
            ->method('getUploadedFilePath')
            ->willReturn($dummyFilePath);
        $this->setReturnValueForSavePicturePath();
        $response = $this->uploadInteractor->upload($this->createRequest());
        $this->assertEquals($dummyFilePath, $response->filePath);
    }

    public function testShouldReturnTheThumbnailPath()
    {
        $this->setReturnValueForFileUpload();
        $dummyThumbFilePath = 'thumbFilePath';
        $this->picturerUploaderStub
            ->method('getThumbFilePath')
            ->willReturn($dummyThumbFilePath);
        $this->setReturnValueForSavePicturePath();
        $response = $this->uploadInteractor->upload($this->createRequest());
        $this->assertEquals($dummyThumbFilePath, $response->thumbPath);
    }

    private function createRequest()
    {
        $request = new Request();
        $request->mandant = $this->mandantStub;
        $request->file = $this->dummyFile;
        $request->loggedInUser = $this->userStub;
        return $request;
    }

    private function setReturnValueForSavePicturePath($returnValue = 5)
    {
        $this->repositoryStub
            ->method('savePicturePath')
            ->willReturn($returnValue);
    }

    private function setReturnValueForFileUpload($returnValue = true)
    {
        $this->picturerUploaderStub
            ->method('uploadFile')
            ->willReturn($returnValue);
    }



}