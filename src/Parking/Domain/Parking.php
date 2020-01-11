<?php

namespace App\Parking\Domain;

use App\Parking\Domain\Model\OpeningHours;
use App\Parking\Domain\Model\ParkingSpace;
use App\Parking\Domain\Model\PriceList;
use App\Parking\Domain\Model\SubscriptionList;
use App\Parking\Domain\ValueObject\Coordinate;
use App\Shared\Domain\ValueObject\Address;


class Parking
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Address
     */
    private $address;

    /**
     * @var Coordinate
     */
    private $coordinate;

    /**
     * @var ParkingSpace[]
     */
    private $parkingSpaces = [];

    /**
     * @var PriceList[]
     */
    private $priceList = [];

    /**
     * @var SubscriptionList[]
     */
    private $subscriptionList = [];

    /**
     * @var OpeningHours[]
     */
    private $openingHours = [];

    /**
     * @var Employee[]
     */
    private $employees = [];

    /**
     * @var string
     */
    private $owner;

    /**
     * Parking constructor.
     * @param string $id
     * @param string $name
     * @param Address $address
     * @param string $owner
     */
    public function __construct(string $id, string $name, Address $address, string $owner)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->owner = $owner;
    }

    /**
     * @param Coordinate $coordinate
     */
    public function setCoordinate(Coordinate $coordinate): void
    {
        $this->coordinate = $coordinate;
    }

    public function addParkingSpace(ParkingSpace $parkingSpace): void
    {
        $parkingSpace->setParking($this);
        if (!$this->contains($parkingSpace, $this->parkingSpaces)) {
            $this->parkingSpaces[] = $parkingSpace;
        }
    }

    public  function addPriceList(PriceList $priceList): void
    {
        $priceList->setParking($this);
        if (!$this->contains($priceList, $this->priceList)) {
            $this->priceList[] = $priceList;
        }
    }

    public  function addSubscriptionList(SubscriptionList $subscriptionList): void
    {
        $subscriptionList->setParking($this);
        if (!$this->contains($subscriptionList, $this->subscriptionList)) {
            $this->subscriptionList[] = $subscriptionList;
        }
    }

    public  function addOpeningHours(OpeningHours $openingHours): void
    {
        $openingHours->setParking($this);
        if (!$this->contains($openingHours, $this->openingHours)) {
            $this->openingHours[] = $openingHours;
        }
    }

    public  function addEmployee(string $userId): void
    {
        $employee = new Employee($userId);
        $employee->setParking($this);
        if (!$this->contains($employee, $this->employees)) {
            $this->employees[] = $employee;
        }
    }

    public function contains($item, $list): bool
    {
        return \in_array($item, (array) $list, true);
    }

}