<?php


namespace App\Exhibition;


use App\Utils\Authenticator;

class ExhibitionBoundary
{

    /** @var  Authenticator */
    private $authenticator;
    /** @var  ExhibitionRepository */
    private $exhibitionRepository;

    /**
     * ExhibitionBoundary constructor.
     * @param Authenticator $authenticator
     * @param ExhibitionRepository $exhibitionRepository
     */
    public function __construct(Authenticator $authenticator, ExhibitionRepository $exhibitionRepository)
    {
        $this->authenticator = $authenticator;
        $this->exhibitionRepository = $exhibitionRepository;
    }


    public function deleteExhibition(Delete\Request $request)
    {
        $deleteExhibition = new Delete\DeleteExhibition($this->authenticator, $this->exhibitionRepository);
        $deleteExhibition->delete($request);
    }

    /**
     * @param ListAll\Request $request
     * @return ListAll\Response
     * @throws \App\Utils\InvalidArgumentException
     */
    public function listAllExhibitions(ListAll\Request $request)
    {
        $listAllExhibition = new ListAll\ListAllExhibitions($this->exhibitionRepository);
        $response = $listAllExhibition->listAll($request);

        return $response;
    }

    /**
     * @param Get\Request $request
     * @return Get\Response
     * @throws \App\Utils\InvalidArgumentException
     */
    public function getExhibition(Get\Request $request)
    {
        $getExhibition = new Get\GetExhibition($this->exhibitionRepository);
        $response = $getExhibition->get($request);

        return $response;
    }

    /**
     * @param CreateOrUpdate\Request $request
     * @return CreateOrUpdate\Response
     * @throws \App\Utils\InvalidArgumentException
     * @throws \App\Utils\NotAuthorizedException
     */
    public function createOrUpate(CreateOrUpdate\Request $request)
    {
        $handler = new CreateOrUpdate\CreateOrUpdateExhibition($this->authenticator, $this->exhibitionRepository);
        $response = $handler->createOrUpdate($request);
        return $response;
    }

}