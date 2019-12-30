<?php

namespace App\Parking\Domain\Model;

use App\Parking\Domain\Parking;
use App\Shared\Domain\Model\ParkingSpaceType;

class SubscriptionList
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var ParkingSpaceType
     */
    private $type;

    /**
     * @var integer
     */
    private $period;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var string
     */
    private $price;

    /**
     * @var Parking
     */
    private $parking;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ParkingSpaceType
     */
    public function getType(): ParkingSpaceType
    {
        return $this->type;
    }

    /**
     * @param ParkingSpaceType $type
     */
    public function setType(ParkingSpaceType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getPeriod(): int
    {
        return $this->period;
    }

    /**
     * @param int $period
     */
    public function setPeriod(int $period): void
    {
        $this->period = $period;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Parking
     */
    public function getParking(): Parking
    {
        return $this->parking;
    }

    /**
     * @param Parking $parking
     */
    public function setParking(Parking $parking): void
    {
        $this->parking = $parking;
    }




}