<?php

namespace App\Staying\Infrastructure;

use App\Shared\Infrastructure\Repository\MysqlRepository;
use App\Staying\Domain\Staying;
use Doctrine\ORM\EntityManagerInterface;

class StayingReadRepository extends MysqlRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Staying::class);
    }

    public function getCountOfCurrentStaying(string $parkingId, string $type)
    {
        $data = $this->repository->createQueryBuilder('s')
            ->select('COUNT(s) AS current_staying')
            ->join('s.type', 't')
            ->where('t.name = :type')
            ->andWhere('s.parkingId = :parking')
            ->andWhere('s.end IS NULL')
            ->andWhere('s.status = :active')
            ->setParameter('type', $type)
            ->setParameter('parking', $parkingId)
            ->setParameter('active', Staying::STATUS_ACTIVE)
            ->getQuery()
            ->getSingleResult();

        return $data;
    }

    public function getCurrentStayingByUser($userId)
    {
        $data = $this->repository->createQueryBuilder('s')
            ->select('s.id, t.name as type, s.start, p.name, s.parkingId, s.status')
            ->join('Parking:Parking', 'p', 'WITH','p.id = s.parkingId')
            ->join('s.type', 't', 's.type = t.id')
            ->where('s.userId = :userId')
            ->andWhere('s.status != :finish')
            ->setParameter('userId', $userId)
            ->setParameter('finish', Staying::STATUS_FINISHED)
            ->orderBy('s.start')
            ->getQuery()
            ->getResult();

        return $data;
    }

    public function getFinishedStayingByUser($userId)
    {
        $data = $this->repository->createQueryBuilder('s')
            ->select('s.id, t.name as type, s.start, s.end, p.name as parkingName, p.address.street as street, p.address.number as number, p.address.city as city, s.parkingId')
            ->join('Parking:Parking', 'p', 'WITH','p.id = s.parkingId')
            ->join('s.type', 't', 's.type = t.id')
            ->where('s.userId = :userId')
            ->andWhere('s.end IS NOT NULL')
            ->andWhere('s.status = :finish')
            ->setParameter('userId', $userId)
            ->setParameter('finish', Staying::STATUS_FINISHED)
            ->orderBy('s.start')
            ->getQuery()
            ->getResult();

        return $data;
    }

    public function getStayingToAccept($parkingId)
    {
        $data = $this->repository->createQueryBuilder('s')
            ->select('s.id, t.name as type, u.name, u.surname, u.email')
            ->join('User:User', 'u', 'WITH','s.userId = u.id')
            ->join('s.type', 't', 's.type = t.id')
            ->where('s.parkingId = :parkingId')
            ->andWhere('s.status = :toAccept')
            ->setParameter('parkingId', $parkingId)
            ->setParameter('toAccept', Staying::STATUS_TO_ACCEPT)
            ->getQuery()
            ->getResult();

        return $data;
    }

    public function getStayingToFinish($parkingId)
    {
        $data = $this->repository->createQueryBuilder('s')
            ->select('s.id, t.name as type, u.name, u.surname, u.email, s.start, s.end')
            ->join('User:User', 'u', 'WITH','s.userId = u.id')
            ->join('s.type', 't', 's.type = t.id')
            ->where('s.parkingId = :parkingId')
            ->andWhere('s.status = :toAccept')
            ->setParameter('parkingId', $parkingId)
            ->setParameter('toAccept', Staying::STATUS_STOP)
            ->getQuery()
            ->getResult();

        return $data;
    }

    public function getCurrentStayingByParking($parkingId)
    {
        $data = $this->repository->createQueryBuilder('s')
            ->select('s.id, t.name as type, s.start, u.name, u.surname, u.email')
            ->join('User:User', 'u', 'WITH','s.userId = u.id')
            ->join('s.type', 't', 's.type = t.id')
            ->where('s.parkingId = :parkingId')
            ->andWhere('s.end IS NULL')
            ->andWhere('s.status = :active')
            ->setParameter('parkingId', $parkingId)
            ->setParameter('active', Staying::STATUS_ACTIVE)
            ->orderBy('s.start')
            ->getQuery()
            ->getResult();

        return $data;
    }
}