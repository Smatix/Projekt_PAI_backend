<?php

namespace App\Parking\Infrastructure\Coordinate;

use App\Parking\Domain\ValueObject\Coordinate;
use App\Shared\Domain\ValueObject\Address;

interface CoordinateInterface
{
    public function convertAddressToCoordinate(Address $address): Coordinate;
}