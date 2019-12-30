<?php

namespace App\Parking\Application\Command;

use App\Shared\Domain\ValueObject\Address;

class CreateParkingCommand
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $owner;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var array
     */
    private $priceList;

    /**
     * @var array
     */
    private $parkingSpace;

    /**
     * @var array
     */
    private $openingHours;

    /**
     * CreateParkingCommand constructor.
     * @param string $name
     * @param Address $address
     * @param string $owner
     */
    public function __construct(string $name, Address $address, string $owner)
    {
        $this->name = $name;
        $this->owner = $owner;
        $this->address = $address;
    }

    /**
     * @param array $priceList
     */
    public function setPriceList(array $priceList): void
    {
        $this->priceList = $priceList;
    }

    /**
     * @param array $parkingSpace
     */
    public function setParkingSpace(array $parkingSpace): void
    {
        $this->parkingSpace = $parkingSpace;
    }

    /**
     * @param array $openingHours
     */
    public function setOpeningHours(array $openingHours): void
    {
        $this->openingHours = $openingHours;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function getPriceList(): array
    {
        return $this->priceList;
    }

    /**
     * @return array
     */
    public function getParkingSpace(): array
    {
        return $this->parkingSpace;
    }

    /**
     * @return array
     */
    public function getOpeningHours(): array
    {
        return $this->openingHours;
    }

}