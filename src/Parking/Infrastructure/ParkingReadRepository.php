<?php

namespace App\Parking\Infrastructure;


use App\Parking\Domain\Employee;
use App\Parking\Domain\Parking;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class ParkingReadRepository extends MysqlRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Parking::class);
    }

    public function getParkingIdByEmployee($userId)
    {
        $data =  $this->repository->createQueryBuilder('parking')
            ->select('parking.id')
            ->join('parking.employees', 'e', 'e.parking = parking.id')
            ->andWhere('e.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();

        return $data[0]['id'];
    }

    public function getPriceListFromParkingBySpaceType($parkingId, $type)
    {
        $data =  $this->repository->createQueryBuilder('parking')
            ->select('priceList.period, priceList.unit, priceList.price')
            ->join('parking.priceList', 'priceList', 'parking.priceList = priceList.id')
            ->join('priceList.type', 'type', 'type.id = priceList.type')
            ->where('parking.id = :parkingId')
            ->andWhere('type.name = :type')
            ->setParameter('parkingId', $parkingId)
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult();

        return $data;
    }
}