<?php

namespace App\Reservation\Application\Service;


use App\ParkingSearch\Infrastructure\Repository\ParkingReadRepository;
use App\Reservation\Infrastructure\ReservationReadRepository;
use App\Staying\Infrastructure\StayingReadRepository;

class ReservationCheckService
{
    /**
     * @var ReservationReadRepository
     */
    private $reservationRepository;

    /**
     * @var StayingReadRepository
     */
    private $stayingRepository;

    /**
     * @var ParkingReadRepository
     */
    private $parkingRepository;

    /**
     * ReservationCheckService constructor.
     * @param ReservationReadRepository $reservationRepository
     * @param StayingReadRepository $stayingRepository
     * @param ParkingReadRepository $parkingRepository
     */
    public function __construct(ReservationReadRepository $reservationRepository,
                                StayingReadRepository $stayingRepository,
                                ParkingReadRepository $parkingRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->stayingRepository = $stayingRepository;
        $this->parkingRepository = $parkingRepository;
    }

    public function checkIfReservationIsPossible($parkingId, $date, $type)
    {
        $today = new \DateTime('now');
        if ($date < $today->format('Y-m-d')) {
            return false;
        }
        $parking = $this->parkingRepository->getParkingById($parkingId);
        $spaceCount = 0;
        foreach ($parking->getParkingSpace() as $item) {
            if ($item['type'] === $type) $spaceCount = $item['count'];
        }

        $reservationCount = $this->reservationRepository->getCountOfReservationInDay($parkingId, $date, $type);
        $stayingCount = 0;

        if ($date == $today->format('Y-m-d')) {
            $stayingCount = $this->stayingRepository->getCountOfCurrentStaying($parkingId, $type);
        }

        $sumOfFilledSpace = intval($reservationCount['current_reservation']) + intval($stayingCount['current_staying']);

        return $sumOfFilledSpace < intval($spaceCount);
    }
}