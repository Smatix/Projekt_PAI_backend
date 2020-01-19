<?php

namespace App\Shared\Infrastructure\Repository;


interface ParkingSpaceTypeRepositoryInterface
{
    public function getAll();

    public function getByName(string $name);
}