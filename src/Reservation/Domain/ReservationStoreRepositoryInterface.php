<?php

namespace App\Reservation\Domain;


interface ReservationStoreRepositoryInterface
{
    public function getById(string $id);

    public function save(Reservation $reservation);

    public function remove(Reservation $reservation);
}