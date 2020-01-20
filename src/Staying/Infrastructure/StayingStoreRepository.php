<?php

namespace App\Staying\Infrastructure;

use App\Shared\Infrastructure\Repository\MysqlRepository;
use App\Staying\Domain\Staying;
use App\Staying\Domain\StayingStoreRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class StayingStoreRepository extends MysqlRepository implements StayingStoreRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Staying::class);
    }

    public function getById(string $id)
    {
        return $this->repository->find($id);
    }

    public function save(Staying $staying)
    {
        $this->em->persist($staying);
        $this->em->flush();
    }
}