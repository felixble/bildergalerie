<?php

namespace App\Exhibition\ListAll;

use App\Exhibition\ExhibitionRepository;
use App\Utils\InvalidArgumentException;

class ListAllExhibitions
{

    /**
     * @var ExhibitionRepository
     */
    private $exhibitionRepository;

    /**
     * DeleteExhibition constructor.
     * @param ExhibitionRepository $repository
     */
    public function __construct(ExhibitionRepository $repository)
    {
        $this->exhibitionRepository = $repository;
    }

    /**
     * @param $request
     * @return Response
     * @throws InvalidArgumentException
     */
    public function listAll($request) {
        if (!isset($request->mandant)) {
            throw new InvalidArgumentException("Mandant id required");
        }

        $response = new Response();
        $response->exhibitions = $this->exhibitionRepository->listAllExhibitions($request->mandant, $request->limit);

        return $response;
    }
}