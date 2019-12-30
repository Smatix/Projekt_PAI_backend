<?php

namespace App\Parking\Domain\Model;

use App\Parking\Domain\Parking;
use App\Shared\Domain\Model\ParkingSpaceType;

class PriceList
{
    /**
     * @var integer
     */
    private $id;

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
     * PriceList constructor.
     * @param ParkingSpaceType $type
     * @param int $period
     * @param string $unit
     * @param string $price
     */
    public function __construct(ParkingSpaceType $type, int $period, string $unit, string $price)
    {
        $this->type = $type;
        $this->period = $period;
        $this->unit = $unit;
        $this->price = $price;
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