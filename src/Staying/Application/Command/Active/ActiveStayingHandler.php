<?php

namespace App\Staying\Application\Command\Active;

use App\Staying\Domain\Staying;
use App\Staying\Domain\StayingStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ActiveStayingHandler implements MessageHandlerInterface
{
    /**
     * @var StayingStoreRepositoryInterface
     */
    private $repository;

    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * StopStayingHandler constructor.
     * @param StayingStoreRepositoryInterface $repository
     * @param MessageBusInterface $eventBus
     */
    public function __construct(StayingStoreRepositoryInterface $repository, MessageBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }

    public function __invoke(ActiveStayingCommand $command)
    {
        /** @var Staying $staying */
        $staying = $this->repository->getById($command->getId());

        $staying->markAsActive();
        $this->repository->save($staying);
    }
}