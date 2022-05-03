<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


use App\Trait\WorkStationTrait;
use App\Service\Interface\IWorkStation;

class WorkStationController extends AbstractController
{
    use WorkStationTrait;

    private $workStationService;

    public function __construct(IWorkStation $workStationService)
    {
        $this->workStationService = $workStationService;
    }

    #[Route('/work/station', name: 'app_work_station_get_all', methods: 'GET')]

    public function getAll(): JsonResponse
    {
        $response = $this->workStationService->fetchAllWorkStations();
        return new JsonResponse($response);
    }

    #[Route('/work/station', name: 'app_work_station_create', methods: 'POST')]

    public function create(Request $request): JsonResponse
    {
        $varifiedParam = $this->hasVaildParams($request->query->all());
        $response = $this->workStationService->addWorkStation($varifiedParam);
        $response =  ($response != '') ? $response : 'Successfully add new work station.';
        return new JsonResponse($response);
    }
}
