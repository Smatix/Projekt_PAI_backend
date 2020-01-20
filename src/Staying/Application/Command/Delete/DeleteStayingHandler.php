<?php

namespace App\Staying\Application\Command\Delete;

use App\Staying\Domain\Staying;
use App\Staying\Domain\StayingStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteStayingHandler implements MessageHandlerInterface
{
    /**
     * @var StayingStoreRepositoryInterface
     */
    private $repository;

    /**
     * StopStayingHandler constructor.
     * @param StayingStoreRepositoryInterface $repository
     */
    public function __construct(StayingStoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(DeleteStayingCommand $command)
    {
        /** @var Staying $staying */
        $staying = $this->repository->getById($command->getId());

        if ($command->getUserId() === $staying->getUserId()) {
            $staying->delete();
            $this->repository->save($staying);
        }
    }
}