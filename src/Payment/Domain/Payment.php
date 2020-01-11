<?php

namespace App\Payment\Domain;


class Payment
{
    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;
    const STATUS_REJECTED = 3;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $parkingId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var int
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Payment constructor.
     * @param string $id
     * @param string parkingId
     * @param string $userId
     * @param string $amount
     * @param int $status
     * @param \DateTime $createdAt
     */
    public function __construct(string $id, string $parkingId, string $userId, string $amount, int $status, \DateTime $createdAt)
    {
        $this->id = $id;
        $this->parkingId = $parkingId;
        $this->userId = $userId;
        $this->amount = $amount;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }

    public function markAsPaid()
    {
        $this->status = self::STATUS_PAID;
    }
}