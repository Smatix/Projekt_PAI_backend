<?php

namespace App\Parking\Domain\Model;

use App\Parking\Domain\Parking;
use App\Shared\Domain\Model\ParkingSpaceType;

class ParkingSpace
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
    private $count;

    /**
     * @var Parking
     */
    private $parking;

    /**
     * ParkingSpace constructor.
     * @param ParkingSpaceType $type
     * @param int $count
     */
    public function __construct(ParkingSpaceType $type, int $count)
    {
        $this->type = $type;
        $this->count = $count;
    }

    /**
     * @param Parking $parking
     */
    public function setParking(Parking $parking): void
    {
        $this->parking = $parking;
    }


}