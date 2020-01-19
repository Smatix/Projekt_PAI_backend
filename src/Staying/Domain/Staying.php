<?php

namespace App\Staying\Domain;

use App\Shared\Domain\Model\ParkingSpaceType;
use DateTime;

class Staying
{
    const STATUS_TO_ACCEPT = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_STOP = 3;
    const STATUS_FINISHED = 4;

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
     * @var int
     */
    private $status;

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
     */
    public function __construct(string $id, ParkingSpaceType $type, string $parkingId, string $userId)
    {
        $this->id = $id;
        $this->type = $type;
        $this->parkingId = $parkingId;
        $this->userId = $userId;
        $this->status = self::STATUS_TO_ACCEPT;
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
     * @return DateTime|null
     */
    public function getEnd(): ?DateTime
    {
        return $this->end;
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
        return $this->status === self::STATUS_ACTIVE;
    }

    public function stopCountingTime()
    {
        if ($this->isActive()) {
            $this->end = new DateTime('now');
            $this->status = self::STATUS_STOP;
        }
    }

    public function resumeCountingTime()
    {
        if (!$this->isActive()) {
            $this->end = null;
            $this->status = self::STATUS_ACTIVE;
        }
    }

    public function markAsFinish()
    {
        $this->stopCountingTime();
        if ($this->status === self::STATUS_STOP) {
            $this->status = self::STATUS_FINISHED;
        }
    }

    public function markAsActive()
    {
        if ($this->status === self::STATUS_TO_ACCEPT) {
            $this->start = new DateTime('now');
            $this->status = self::STATUS_ACTIVE;
        }
    }

}