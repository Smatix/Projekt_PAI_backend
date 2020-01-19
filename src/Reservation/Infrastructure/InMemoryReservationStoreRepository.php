<?php

namespace App\Reservation\Infrastructure;

use App\Reservation\Domain\Reservation;
use App\Reservation\Domain\ReservationStoreRepositoryInterface;

class InMemoryReservationStoreRepository implements ReservationStoreRepositoryInterface
{
    /**
     * @var array
     */
    private $reservations = [];

    public function getById(string $id)
    {
        /** @var Reservation $reservation */
        foreach ($this->reservations as $reservation) {
            if ($reservation->getId() === $id) {
                return $reservation;
            }
        }
        return null;
    }

    public function save(Reservation $reservation)
    {
        $this->reservations[] = $reservation;
    }

}