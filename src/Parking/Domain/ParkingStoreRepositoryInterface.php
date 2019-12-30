<?php

namespace App\Parking\Domain;


interface ParkingStoreRepositoryInterface
{
    public function findById(string $id);

    public function save(Parking $parking);
}