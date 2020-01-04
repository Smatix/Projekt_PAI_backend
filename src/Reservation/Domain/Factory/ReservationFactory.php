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
use DateTime;

class ReservationFactory
{
    public static function create($id, $reservationDate, $type, $parkingId, $userId)
    {
        return new Reservation(
            $id,
            Reservation::STATUS_PENDING,
            new DateTime('now'),
            DateTime::createFromFormat('Y-m-d', $reservationDate),
            $type,
            $parkingId,
            $userId
        );
    }
}