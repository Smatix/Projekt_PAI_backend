<?php

namespace App\Reservation\Domain\Event;

use App\Shared\Domain\Model\ParkingSpaceType;
use DateTime;

class ReservationWasFinish
{
    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var ParkingSpaceType
     */
    private $type;

    /**
     * @var string
     */
    private $parkingId;

    /**
     * @var string
     */
    private $userId;

    /**
     * ReservationWasFinish constructor.
     * @param DateTime $start
     * @param ParkingSpaceType $type
     * @param string $parkingId
     * @param string $userId
     */
    public function __construct(DateTime $start, ParkingSpaceType $type, string $parkingId, string $userId)
    {
        $this->start = $start;
        $this->type = $type;
        $this->parkingId = $parkingId;
        $this->userId = $userId;
    }

    /**
     * @return DateTime
     */
    public function getStart(): DateTime
    {
        return $this->start;
    }

    /**
     * @return ParkingSpaceType
     */
    public function getType(): ParkingSpaceType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getParkingId(): string
    {
        return $this->parkingId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }


}