<?php

namespace App\Reservation\Domain;

use App\Shared\Domain\Model\ParkingSpaceType;
use \DateTime;

class Reservation
{
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_FAILED = 3;
    const STATUS_CANCELED = 4;
    const STATUS_FINISHED = 5;
    const STATUS_EXPIRED = 6;

    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $expiredDate;

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
     * Reservation constructor.
     * @param string $id
     * @param string $status
     * @param DateTime $createdAt
     * @param DateTime $expiredDate
     * @param ParkingSpaceType $type
     * @param $parkingId
     * @param $userId
     */
    public function __construct(
        string $id,
        string $status,
        DateTime $createdAt,
        DateTime $expiredDate,
        ParkingSpaceType $type,
        $parkingId,
        $userId
    )
    {
        $this->id = $id;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->expiredDate = $expiredDate;
        $this->type = $type;
        $this->parkingId = $parkingId;
        $this->userId = $userId;
    }


    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getExpiredDate(): DateTime
    {
        return $this->expiredDate;
    }

    public function markAsActive()
    {
        if ($this->getStatus() === self::STATUS_PENDING) {
            $this->status = self::STATUS_ACTIVE;
        }
    }

    public function markAsFailed()
    {
        if ($this->getStatus() === self::STATUS_PENDING) {
            $this->status = self::STATUS_FAILED;
        }
    }

    public function cancel()
    {
        if ($this->getStatus() === self::STATUS_ACTIVE ||
            $this->getStatus() === self::STATUS_PENDING) {
            $this->status = self::STATUS_CANCELED;
        }
    }

    public function markAsExpired()
    {
        if ($this->getStatus() === self::STATUS_ACTIVE) {
            $this->status = self::STATUS_EXPIRED;
        }
    }

    public function finish()
    {
        if ($this->getStatus() === self::STATUS_ACTIVE) {
            $this->status = self::STATUS_FINISHED;
        }
    }

    public function isExpired(): bool
    {
        $now = new DateTime('now');
        return (
            $this->status === Reservation::STATUS_ACTIVE &&
            $this->expiredDate->format('Y-m-j H:i:s') < $now->format('Y-m-j H:i:s'));
    }

    public function canBeShared(): bool
    {
        return $this->status === Reservation::STATUS_ACTIVE;
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

    /**
     * @return ParkingSpaceType
     */
    public function getType(): ParkingSpaceType
    {
        return $this->type;
    }

}