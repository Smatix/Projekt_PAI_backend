<?php

namespace App\Reservation\Infrastructure;

use App\Reservation\Domain\Reservation;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReservationReadRepository extends MysqlRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Reservation::class);
    }

    public function getCountOfReservationInDay($parking, $date, $type)
    {
        $data = $this->repository->createQueryBuilder('r')
            ->select('COUNT(r) AS current_reservation')
            ->join('r.type', 't')
            ->where('t.name = :type')
            ->andWhere('r.parkingId = :parking')
            ->andWhere('r.expiredDate = :date')
            ->andWhere('r.status = :active OR r.status = :received')
            ->setParameter('type', $type)
            ->setParameter('parking', $parking)
            ->setParameter('date', $date)
            ->setParameter('active', Reservation::STATUS_ACTIVE)
            ->setParameter('received', Reservation::STATUS_RECEIVED)
            ->getQuery()
            ->getSingleResult();

        return $data;
    }
}