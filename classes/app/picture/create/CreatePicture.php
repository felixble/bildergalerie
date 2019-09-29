<?php

namespace App\Picture\Create;

use App\Picture\PictureRepository;
use App\Utils\Authenticator;
use App\Utils\InvalidArgumentException;
use App\Utils\NotAuthorizedException;

class CreatePicture
{

    private $authenticator;
    private $pictureRepository;

    public function __construct(Authenticator $authenticator, PictureRepository $repository)
    {
        $this->authenticator = $authenticator;
        $this->pictureRepository = $repository;
    }

    /**
     * @param Request $request
     * @throws NotAuthorizedException
     * @throws \IllegalStateException
     * @throws \InvalidInputException
     */
    public function create(Request $request)
    {
        if(!$this->authenticator->isAuthenticated()) {
            throw new NotAuthorizedException();
        }
        $picture = new \Picture(
            $request->mandant, $request->editPicId, $request->title, $request->descr, null, $request->material,
            null, null, null, $request->picPathId, null, null,
            $request->uploadedBy, $request->owner, null, $request->tags
        );
        $picture->addCategories($request->categoryIds);
        $picture->validate();
        $this->pictureRepository->createPicture($picture, $request->edit);

    }
}