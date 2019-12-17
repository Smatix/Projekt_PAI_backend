<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 15.12.2019
 * Time: 16:55
 */

namespace App\Reservation\Domain\Factory;

use App\Reservation\Domain\Reservation;

class ReservationFactory
{
    public static function create($reservationDate, $parkingId, $userId)
    {
        return new Reservation(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            Reservation::STATUS_PENDING,
            new \DateTime('now'),
            $reservationDate,
            $parkingId,
            $userId
        );
    }
}