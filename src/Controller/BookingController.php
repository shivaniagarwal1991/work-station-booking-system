<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use App\Trait\BookingTrait;
use App\Service\Interface\IBooking;

class BookingController extends AbstractController
{
    use BookingTrait;

    private $bookingService;

    public function __construct(IBooking $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    #[Route('/booking', name: 'app_booking_get_all', methods: 'GET')]

    public function getAll(): JsonResponse
    {
        $response = $this->bookingService->fetchAllBooking();
        //print_r($response);
        return new JsonResponse($response);
    }

    #[Route('/booking', name: 'app_booking_create', methods: 'POST')]

    public function create(Request $request): JsonResponse
    {
        $varifiedParam = $this->hasVaildParams($request->query->all());
        $response = $this->bookingService->addBooking($varifiedParam);
        $msg = ($response == Response::HTTP_BAD_REQUEST) ? 'Record Already Exist.' : 'Successfully booked your work station.';
        return new JsonResponse(['status_code' => $response, 'message' => $msg]);
    }
}
