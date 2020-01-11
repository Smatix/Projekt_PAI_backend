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
            ->andWhere('r.status = :active')
            ->setParameter('type', $type)
            ->setParameter('parking', $parking)
            ->setParameter('date', $date)
            ->setParameter('active', Reservation::STATUS_ACTIVE)
            ->getQuery()
            ->getSingleResult();

        return $data;
    }

    public function getCurrentReservationByUser($userId)
    {
        $data = $this->repository->createQueryBuilder('r')
            ->select('r.id, r.status, t.name as type, r.expiredDate, p.name')
            ->join('Parking:Parking', 'p', 'WITH','p.id = r.parkingId')
            ->join('r.type', 't', 'r.type = t.id')
            ->where('r.userId = :userId')
            ->andWhere('r.status = :pending OR r.status = :active')
            ->setParameter('userId', $userId)
            ->setParameter('active', Reservation::STATUS_ACTIVE)
            ->setParameter('pending', Reservation::STATUS_PENDING)
            ->orderBy('r.expiredDate')
            ->getQuery()
            ->getResult();

        foreach ($data as &$item) {
            $item['expiredDate'] = $item['expiredDate']->format('d.m.Y');
        }

        return $data;
    }

    public function getFinishedReservationByUser($userId)
    {
        $data = $this->repository->createQueryBuilder('r')
            ->select('r.id, t.name as type, r.expiredDate, p.name as parkingName, p.address.street as street, p.address.number as number, p.address.city as city')
            ->join('Parking:Parking', 'p', 'WITH','p.id = r.parkingId')
            ->join('r.type', 't', 'r.type = t.id')
            ->where('r.userId = :userId')
            ->andWhere('r.status = :finish')
            ->setParameter('userId', $userId)
            ->setParameter('finish', Reservation::STATUS_FINISHED)
            ->orderBy('r.expiredDate')
            ->getQuery()
            ->getResult();

        foreach ($data as &$item) {
            $item['expiredDate'] = $item['expiredDate']->format('d.m.Y');
        }

        return $data;
    }

    public function getReservationToAcceptByParking($parkingId)
    {
        $data = $this->repository->createQueryBuilder('r')
            ->select('r.id, t.name as type, r.expiredDate, u.name, u.surname, u.email')
            ->join('User:User', 'u', 'WITH','r.userId = u.id')
            ->join('r.type', 't', 'r.type = t.id')
            ->where('r.parkingId = :parkingId')
            ->andWhere('r.status = :pending')
            ->setParameter('parkingId', $parkingId)
            ->setParameter('pending', Reservation::STATUS_PENDING)
            ->orderBy('r.expiredDate')
            ->getQuery()
            ->getResult();

        foreach ($data as &$item) {
            $item['expiredDate'] = $item['expiredDate']->format('d.m.Y');
        }

        return $data;
    }

    public function getCurrentReservationsByParking($parkingId)
    {
        $data = $this->repository->createQueryBuilder('r')
            ->select('r.id, t.name as type, r.expiredDate, u.name, u.surname, u.email')
            ->join('User:User', 'u', 'WITH','r.userId = u.id')
            ->join('r.type', 't', 'r.type = t.id')
            ->where('r.parkingId = :parkingId')
            ->andWhere('r.status = :pending')
            ->setParameter('parkingId', $parkingId)
            ->setParameter('pending', Reservation::STATUS_ACTIVE)
            ->orderBy('r.expiredDate')
            ->getQuery()
            ->getResult();

        foreach ($data as &$item) {
            $item['expiredDate'] = $item['expiredDate']->format('d.m.Y');
        }

        return $data;
    }
}