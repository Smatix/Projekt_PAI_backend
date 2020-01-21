<?php

namespace App\Reservation\Infrastructure;

use App\Reservation\Domain\Reservation;
use App\Reservation\Domain\ReservationStoreRepositoryInterface;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Runner\Exception;

class ReservationStoreRepository extends MysqlRepository implements ReservationStoreRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Reservation::class);
    }

    public function getById(string $id)
    {
        return $this->repository->find($id);
    }

    public function save(Reservation $reservation)
    {
        try {
            $this->em->getConnection()->beginTransaction();
            $this->em->persist($reservation);
            $this->em->flush();
            $this->em->getConnection()->commit();
        } catch (Exception $e) {
            $this->em->getConnection()->rollBack();
        }

    }

    public function remove(Reservation $reservation)
    {
        $this->em->remove($reservation);
        $this->em->flush();
    }


}