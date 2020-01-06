<?php

namespace App\Staying\Domain\Event;

class StayingWasFinish
{
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
     * StayingWasFinish constructor.
     * @param string $stayingId
     * @param string $userId
     * @param string $amount
     */
    public function __construct(string $stayingId, string $userId, string $amount)
    {
        $this->stayingId = $stayingId;
        $this->userId = $userId;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getStayingId(): string
    {
        return $this->stayingId;
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