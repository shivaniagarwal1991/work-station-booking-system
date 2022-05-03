<?php

namespace App\Service\Interface;

interface IWorkStation
{
    /**     
     * @return array
     */
    public function fetchAllWorkStations(): array;

    /**
     * @param array $data    
     */
    public function addWorkStation(array $data);
}
