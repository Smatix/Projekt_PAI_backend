<?php

namespace App\ParkingSearch\Infrastructure\Repository;

use App\Parking\Domain\Parking;
use App\ParkingSearch\Domain\ParkingView;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkingReadRepository extends MysqlRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, ParkingView::class);
    }

    public function getParkingsByCity($city)
    {
        /** @var ParkingView[] $data */
        $data = $this->repository->createQueryBuilder('p')
            ->select('p')
            ->where('p.city = :city')
            ->setParameter('city', $city)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($data as $parkingView) {
            $result[] = $parkingView->toArray();
        }
        return $result;
    }

    public function getParkingsByCoordinate($north, $east, $south, $west)
    {
        /** @var ParkingView[] $data */
        $data = $this->repository->createQueryBuilder('p')
            ->select('p')
            ->where('p.lat BETWEEN :south AND :north')
            ->andWhere('p.lng BETWEEN :west AND :east')
            ->setParameter('north', $north)
            ->setParameter('east', $east)
            ->setParameter('south', $south)
            ->setParameter('west', $west)
            ->getQuery()
            ->getResult();

        $result = [];
        foreach ($data as $parkingView) {
            $result[] = $parkingView->toArray();
        }
        return $result;
    }

    public function getParkingById($id)
    {
        /** @var ParkingView $data */
        $data = $this->repository->createQueryBuilder('p')
            ->select('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        return $data;
    }
}