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

    public function remove(Reservation $reservation)
    {
        for ($i = 0; $i < count($this->reservations) ; $i++) {
            if ($this->reservations[$i]->getId() === $reservation->getId()) {
                unset($this->reservations[$i]);
            }
        }
    }


}