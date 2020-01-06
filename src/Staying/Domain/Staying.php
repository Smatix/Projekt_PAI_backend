<?php

namespace App\Staying\Domain;

use App\Shared\Domain\Model\ParkingSpaceType;
use DateTime;

class Staying
{
    /**
     * @var string
     */
    private $id;

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
     * @var DateTime
     */
    private $start;

    /**
     * @var DateTime|null
     */
    private $end;

    /**
     * Staying constructor.
     * @param string $id
     * @param ParkingSpaceType $type
     * @param string $parkingId
     * @param string $userId
     * @param DateTime $start
     */
    public function __construct(string $id, ParkingSpaceType $type, string $parkingId, string $userId, DateTime $start)
    {
        $this->id = $id;
        $this->type = $type;
        $this->parkingId = $parkingId;
        $this->userId = $userId;
        $this->start = $start;
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
     * @return DateTime
     */
    public function getStart(): DateTime
    {
        return $this->start;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    public function isActive()
    {
        return is_null($this->end);
    }

    public function finish()
    {
        if ($this->isActive()) {
            $this->end = new DateTime('now');
        }
    }

}