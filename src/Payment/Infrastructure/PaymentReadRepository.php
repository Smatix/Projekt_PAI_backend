<?php

namespace App\Payment\Infrastructure;


use App\Payment\Domain\Payment;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class PaymentReadRepository extends MysqlRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Payment::class);
    }

    public function getPaymentByUser($userId)
    {
        $data = $this->repository->createQueryBuilder('payment')
            ->select('payment.id, payment.status, payment.amount, p.name as parkingName, p.street, p.number, p.city, t.name as type')
            ->innerJoin('Staying:Staying', 's', 'WITH', 'payment.stayingId = s.id')
            ->join('ParkingSearch:ParkingView', 'p','WITH','s.parkingId = p.id')
            ->join('s.type', 't', 's.type = t.id')
            ->where('payment.userId = :userId')
            ->andWhere('payment.status != :reject')
            ->setParameter('userId', $userId)
            ->setParameter('reject', Payment::STATUS_REJECTED)
            ->getQuery()
            ->getResult();

        return $data;
    }
}