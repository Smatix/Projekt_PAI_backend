<?php

namespace App\Opinion\Application\Command;

use App\Opinion\Domain\Opinion;
use App\Opinion\Domain\OpinionStoreRepositoryInterface;
use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOpinionHandler implements MessageHandlerInterface
{
    /**
     * @var OpinionStoreRepositoryInterface
     */
    private $repository;

    /**
     * CreateOpinionHandler constructor.
     * @param OpinionStoreRepositoryInterface $repository
     */
    public function __construct(OpinionStoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateOpinionCommand $command)
    {
        $opinion = new Opinion(
            $command->getId(),
            $command->getRate(),
            $command->getComment(),
            $command->getAuthor(),
            $command->getParkingId()
        );
        $this->repository->save($opinion);
    }
}