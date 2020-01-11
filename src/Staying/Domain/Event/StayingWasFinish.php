<?php

namespace App\Staying\Domain\Event;

class StayingWasFinish
{
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
     * StayingWasFinish constructor.
     * @param string $parkingId
     * @param string $userId
     * @param string $amount
     */
    public function __construct(string $parkingId, string $userId, string $amount)
    {
        $this->parkingId = $parkingId;
        $this->userId = $userId;
        $this->amount = $amount;
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
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }


}