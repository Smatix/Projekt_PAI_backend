<?php

namespace App\Reservation\Domain;

use \DateTime;

class Reservation
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELED = 'canceled';
    const STATUS_RECEIVED = 'received';
    const STATUS_FINISHED = 'finished';
    const STATUS_EXPIRED = 'expired';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
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

    private $parkingId;

    private $userId;

    /**
     * Reservation constructor.
     * @param string $id
     * @param string $status
     * @param DateTime $createdAt
     * @param DateTime $expiredDate
     * @param $parkingId
     * @param $userId
     */
    public function __construct(string $id, string $status, DateTime $createdAt, DateTime $expiredDate, $parkingId, $userId)
    {
        $this->id = $id;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->expiredDate = $expiredDate;
        $this->parkingId = $parkingId;
        $this->userId = $userId;
    }


    /**
     * @return string
     */
    public function getStatus(): string
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
        if ($this->getStatus() === self::STATUS_ACTIVE) {
            $this->status = self::STATUS_CANCELED;
        }
    }

    public function markAsExpired()
    {
        if ($this->getStatus() === self::STATUS_ACTIVE) {
            $this->status = self::STATUS_EXPIRED;
        }
    }

    public function receive()
    {
        if ($this->getStatus() === self::STATUS_ACTIVE) {
            $this->status = self::STATUS_RECEIVED;
        }
    }

    public function finish()
    {
        if ($this->getStatus() === self::STATUS_RECEIVED) {
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
        return (
            $this->status === Reservation::STATUS_ACTIVE ||
            $this->status === Reservation::STATUS_RECEIVED);
    }
}