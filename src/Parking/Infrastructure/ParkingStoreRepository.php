<?php

namespace App\Parking\Infrastructure;

use App\Parking\Domain\Parking;
use App\Parking\Domain\ParkingStoreRepositoryInterface;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkingStoreRepository extends MysqlRepository implements ParkingStoreRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Parking::class);
    }

    public function findById(string $id)
    {
        return $this->repository->find($id);
    }

    public function save(Parking $parking)
    {
        $this->em->persist($parking);
        $this->em->flush();
    }

    public function remove(Parking $parking)
    {
        $this->em->remove($parking);
        $this->em->flush();
    }
}