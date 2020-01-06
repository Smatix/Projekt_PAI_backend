<?php

namespace App\Reservation\Application\Command\Create;

use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;

class CreateReservationCommand
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $reservationDate;

    /**
     * @var string
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
     * CreateReservationCommand constructor.
     */
    public function __construct()
    {
        $this->id = RamseyUuidAdapter::generate();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getReservationDate(): ?string
    {
        return $this->reservationDate;
    }

    /**
     * @param string $reservationDate
     */
    public function setReservationDate(string $reservationDate): void
    {
        $this->reservationDate = $reservationDate;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getParkingId(): ?string
    {
        return $this->parkingId;
    }

    /**
     * @param string $parkingId
     */
    public function setParkingId(string $parkingId): void
    {
        $this->parkingId = $parkingId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId): void
    {
        $this->userId = $userId;
    }


}