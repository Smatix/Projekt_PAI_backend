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
    private $stayingId;

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
     * @param string $stayingId
     * @param string $userId
     * @param string $amount
     * @param int $status
     * @param \DateTime $createdAt
     */
    public function __construct(string $id, string $stayingId, string $userId, string $amount, int $status, \DateTime $createdAt)
    {
        $this->id = $id;
        $this->stayingId = $stayingId;
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