<?php

namespace App\Shared\Infrastructure\Repository;

use App\Shared\Domain\Model\ParkingSpaceType;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkingSpaceTypeRepository extends MysqlRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, ParkingSpaceType::class);
    }

    public function getAll()
    {
        $result = $this->repository->createQueryBuilder('t')
            ->select('t')
            ->getQuery()
            ->getResult();

        $array = [];
        foreach ($result as $item) {
            $array[$item->getName()] = $item;
        }
        return $array;
    }

    public function getByName($name)
    {
        $result = $this->repository->createQueryBuilder('t')
            ->select('t')
            ->where('t.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getSingleResult();

        return $result;
    }
}