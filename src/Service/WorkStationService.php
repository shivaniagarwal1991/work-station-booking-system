<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use App\Service\Interface\IWorkStation;
use App\Entity\WorkStation as WorkStationEntity;
use App\Repository\WorkStationRepository;


class WorkStationService implements IWorkStation
{
    private $workStationRepository;

    public function __construct(WorkStationRepository $workStationRepository)
    {
        $this->workStationRepository = $workStationRepository;
    }


    public function fetchAllWorkStations(): array
    {
        return $this->formatWorkStationData($this->workStationRepository->findAll());
    }

    /**
     * @param array $data
     */
    public function addWorkStation(array $data)
    {
        $workStation = new WorkStationEntity();
        $workStation->setName($data['name']);
        $workStation->setType($data['type']);
        $workStation->setStatus($data['status']);
        return $this->workStationRepository->add($workStation);
    }

    /**
     * @param array $workStations
     * @return array
     */
    private function formatWorkStationData(array $workStations): array
    {
        $records = [];
        if (!empty($workStations)) {
            foreach ($workStations as $workStation) :
                $data = [];
                $data['id'] = $workStation->getId();
                $data['name'] = $workStation->getName();
                $data['status'] = $workStation->getStatus();
                array_push($records, $data);
            endforeach;
        }
        return $records;
    }
}
