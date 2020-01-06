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
            ->setParameter('type', $type)
            ->setParameter('parking', $parkingId)
            ->getQuery()
            ->getSingleResult();

        return $data;
    }

    public function getCurrentStayingByUser($userId)
    {
        $data = $this->repository->createQueryBuilder('s')
            ->select('s.id, t.name as type, s.start, p.name, s.parkingId')
            ->join('Parking:Parking', 'p', 'WITH','p.id = s.parkingId')
            ->join('s.type', 't', 's.type = t.id')
            ->where('s.userId = :userId')
            ->andWhere('s.end IS NULL')
            ->setParameter('userId', $userId)
            ->orderBy('s.start')
            ->getQuery()
            ->getResult();

        return $data;
    }
}