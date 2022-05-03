<?php

namespace App\Service\Interface;

interface IBooking
{
    /**
     * @param array $data
     */
    public function addBooking(array $data);

    public function fetchAllBooking();
}
