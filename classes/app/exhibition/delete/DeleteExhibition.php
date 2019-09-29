<?php

namespace App\Exhibition\Delete;

use App\Exhibition\ExhibitionRepository;
use App\Utils\Authenticator;
use App\Utils\InvalidArgumentException;
use App\Utils\NotAuthorizedException;

class DeleteExhibition
{

    /**
     * @var Authenticator
     */
    private $authenticator;

    /**
     * @var ExhibitionRepository
     */
    private $exhibitionRepository;


    /**
     * DeleteExhibition constructor.
     * @param Authenticator $authenticator
     * @param ExhibitionRepository $repository
     */
    public function __construct(Authenticator $authenticator, ExhibitionRepository $repository)
    {
        $this->authenticator = $authenticator;
        $this->exhibitionRepository = $repository;
    }

    /**
     * @param Request $request
     * @throws InvalidArgumentException
     * @throws NotAuthorizedException
     */
    public function delete(Request $request)
    {
        if (!$this->authenticator->isAuthenticated()) {
            throw new NotAuthorizedException();
        }
        if (!isset($request->id)) {
            throw new InvalidArgumentException("Exhibition id required");
        }

        $this->exhibitionRepository->deleteExhibitionById($request->id);
    }

}