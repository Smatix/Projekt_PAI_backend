<?php

namespace App\Shared\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class MysqlRepository
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * MysqlRepository constructor.
     * @param EntityManagerInterface $entityManager
     * @param string $model
     */
    public function __construct(EntityManagerInterface $entityManager, string $model)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository($model);
    }


}