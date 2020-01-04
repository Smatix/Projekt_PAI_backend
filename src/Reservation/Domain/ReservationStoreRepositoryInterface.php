<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 04.01.2020
 * Time: 08:56
 */

namespace App\Reservation\Domain;


interface ReservationStoreRepositoryInterface
{
    public function getById(string $id);

    public function save(Reservation $reservation);
}