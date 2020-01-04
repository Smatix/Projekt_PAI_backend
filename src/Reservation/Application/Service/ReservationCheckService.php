<?php

namespace App\Reservation\Application\Service;


use App\ParkingSearch\Infrastructure\Repository\ParkingReadRepository;
use App\Reservation\Infrastructure\ReservationReadRepository;

class ReservationCheckService
{
    /**
     * @var ReservationReadRepository
     */
    private $reservationRepository;

    /**
     * @var ParkingReadRepository
     */
    private $parkingRepository;

    /**
     * ReservationCheckService constructor.
     * @param ReservationReadRepository $reservationRepository
     * @param ParkingReadRepository $parkingRepository
     */
    public function __construct(ReservationReadRepository $reservationRepository, ParkingReadRepository $parkingRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->parkingRepository = $parkingRepository;
    }


    public function checkIfReservationIsPossible($parkingId, $date, $type)
    {
        $parking = $this->parkingRepository->getParkingById($parkingId);
        $spaceCount = 0;
        foreach ($parking->getParkingSpace() as $item) {
            if ($item['type'] === $type) $spaceCount = $item['count'];
        }

        $reservationCount = $this->reservationRepository->getCountOfReservationInDay($parkingId, $date, $type);
        return intval($reservationCount['current_reservation']) < intval($spaceCount);
    }
}