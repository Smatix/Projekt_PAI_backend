<?php

namespace App\Shared\Infrastructure\Repository;


use App\Shared\Domain\Model\ParkingSpaceType;

class InMemoryParkingSpaceTypeRepository implements ParkingSpaceTypeRepositoryInterface
{
    /**
     * @var array
     */
    private $parkingSpaces;

    /**
     * InMemoryParkingSpaceTypeRepository constructor.
     */
    public function __construct()
    {
        $this->parkingSpaces = [
            'car' => new ParkingSpaceType('car'),
            'motorbike' => new ParkingSpaceType('motorbike')
        ];
    }

    public function getAll()
    {
        return $this->parkingSpaces;
    }

    public function getByName(string $name)
    {
        return $this->parkingSpaces[$name];
    }

}