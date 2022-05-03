<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use App\Service\Interface\IBooking;
use App\Entity\Booking as BookingEntity;
use App\Repository\BookingRepository;

class BookingService implements IBooking
{

    private $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }


    /**
     * @param array $data
     */
    public function addBooking(array $data)
    {
        $filterBy = $data;
        unset($filterBy['work_station_id']);
        $isUserAlreadyBookedOtherStation = $this->bookingRepository->findByFilter($filterBy);

        $filterBy['work_station_id'] = $data['work_station_id'];
        unset($filterBy['user_hash']);
        $isWorkStationBooked = $this->bookingRepository->findByFilter($filterBy);

        if (empty($isWorkStationBooked) &&  empty($isUserAlreadyBookedOtherStation)) {
            $booking = new BookingEntity();
            $booking->setWorkStationId($data['work_station_id']);
            $booking->setUserHash($data['user_hash']);
            $booking->setDate($data['date']);
            $booking->setStartTime($data['start_time']);
            $booking->setEndTime($data['end_time']);
            $booking->setStatus($data['status']);
            $this->bookingRepository->add($booking);
            return Response::HTTP_CREATED;
        }
        return Response::HTTP_BAD_REQUEST;
    }

    public function fetchAllBooking()
    {
        return $this->formatBooking($this->bookingRepository->findAll());
    }

    /**
     * @param array $bookings
     * @return array
     */
    private function formatBooking(array $bookings): array
    {
        $records = [];
        if (!empty($bookings)) {
            foreach ($bookings as $booking) :
                $data = [];
                $data['booking_id'] = $booking->getId();
                $data['work_station_id'] = $booking->getWorkStationId();
                $data['user_hash'] = $booking->getUserHash();
                $data['date'] = $booking->getDate();
                $data['start_time'] = $booking->getStartTime();
                $data['end_time'] = $booking->getEndTime();
                $data['status'] = $booking->getStatus();
                array_push($records, $data);
            endforeach;
        }
        return $records;
    }
}
