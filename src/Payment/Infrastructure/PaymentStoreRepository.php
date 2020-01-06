<?php

namespace App\Payment\Infrastructure;

use App\Payment\Domain\Payment;
use App\Payment\Domain\PaymentStoreRepositoryInterface;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class PaymentStoreRepository extends MysqlRepository implements PaymentStoreRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Payment::class);
    }

    public function getById(string $id)
    {
        return $this->repository->find($id);
    }

    public function save(Payment $reservation)
    {
        $this->em->persist($reservation);
        $this->em->flush();
    }

}