<?php

namespace App\Opinion\Infrastructure;

use App\Opinion\Domain\Opinion;
use App\Opinion\Domain\OpinionStoreRepositoryInterface;
use App\Shared\Infrastructure\Repository\MysqlRepository;
use Doctrine\ORM\EntityManagerInterface;

class OpinionStoreRepository extends MysqlRepository implements OpinionStoreRepositoryInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, Opinion::class);
    }

    public function getById(string $id)
    {
        return $this->repository->find($id);
    }

    public function save(Opinion $opinion)
    {
        $this->em->persist($opinion);
        $this->em->flush();
    }

}