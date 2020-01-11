<?php

namespace App\UI\Controller\Employee;

use App\Parking\Infrastructure\ParkingReadRepository;
use App\Reservation\Application\Command\Accept\AcceptReservationCommand;
use App\Reservation\Infrastructure\ReservationReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{

    /**
     * @var ParkingReadRepository
     */
    private $parkingRepository;

    /**
     * @var ReservationReadRepository
     */
    private $repository;

    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    /**
     * ReservationController constructor.
     * @param ParkingReadRepository $parkingRepository
     * @param ReservationReadRepository $repository
     * @param MessageBusInterface $messageBus
     */
    public function __construct(ParkingReadRepository $parkingRepository, ReservationReadRepository $repository, MessageBusInterface $messageBus)
    {
        $this->parkingRepository = $parkingRepository;
        $this->repository = $repository;
        $this->messageBus = $messageBus;
    }

    /**
     * @Route("/api/employee/reservations", methods="GET", name="get_employee_reservations_to_accept")
     * @return JsonResponse
     */
    public function getReservationToAccept()
    {
        $parkingId = $this->parkingRepository->getParkingIdByEmployee($this->getUser()->getId());
        $data = $this->repository->getReservationToAcceptByParking($parkingId);
        return $this->json($data);
    }

    /**
     * @Route("/api/employee/reservations/all", methods="GET", name="get_employee_reservations")
     * @return JsonResponse
     */
    public function getCurrentReservations()
    {
        $parkingId = $this->parkingRepository->getParkingIdByEmployee($this->getUser()->getId());
        $data = $this->repository->getCurrentReservationsByParking($parkingId);
        return $this->json($data);
    }

    /**
     * @Route("/api/reservations/{id}/accept", methods="PATCH", name="accept_reservation")
     * @param $id
     * @return JsonResponse
     */
    public function acceptReservation($id)
    {
        $command = new AcceptReservationCommand($id);
        $this->messageBus->dispatch($command);
        return $this->json('Reservation was accept', 200);
    }
}