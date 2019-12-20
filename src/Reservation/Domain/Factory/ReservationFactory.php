<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 15.12.2019
 * Time: 16:55
 */

namespace App\Reservation\Domain\Factory;

use App\Reservation\Domain\Reservation;
use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;

class ReservationFactory
{
    public static function create($reservationDate, $parkingId, $userId)
    {
        return new Reservation(
            RamseyUuidAdapter::generate(),
            Reservation::STATUS_PENDING,
            new \DateTime('now'),
            $reservationDate,
            $parkingId,
            $userId
        );
    }
}