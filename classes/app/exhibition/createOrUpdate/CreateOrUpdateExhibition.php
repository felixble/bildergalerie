<?php

namespace App\Exhibition\CreateOrUpdate;

use App\Exhibition\ExhibitionRepository;
use App\Utils\Authenticator;
use App\Utils\InvalidArgumentException;
use App\Utils\NotAuthorizedException;

class CreateOrUpdateExhibition
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
     * CreateOrUpdateExhibition constructor.
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
     * @return Response  
     */
    public function createOrUpdate(Request $request)
    {
        if (!$this->authenticator->isAuthenticated()) {
            throw new NotAuthorizedException();
        }
        if (!isset($request->name)) {
            throw new InvalidArgumentException("Exhibition name required");
        } 
        if (!isset($request->description)) {
            throw new InvalidArgumentException("Exhibition description required");
        } 
        $id = $this->exhibitionRepository->createOrUpdateExhibition($request->id, $request->name, $request->description);
        $response = new Response();
        $response->id = $id;
        return $response;
    }

}