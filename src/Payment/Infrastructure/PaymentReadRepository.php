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
    }
}