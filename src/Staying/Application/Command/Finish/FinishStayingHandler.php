<?php

namespace App\Staying\Application\Command\Finish;

use App\Staying\Application\Service\StayingPriceCounter;
use App\Staying\Domain\Event\StayingWasFinish;
use App\Staying\Domain\Staying;
use App\Staying\Domain\StayingStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class FinishStayingHandler implements MessageHandlerInterface
{
    /**
     * @var StayingStoreRepositoryInterface
     */
    private $repository;

    /**
     * @var StayingPriceCounter
     */
    private $priceCounter;

    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * FinishStayingHandler constructor.
     * @param StayingStoreRepositoryInterface $repository
     * @param StayingPriceCounter $priceCounter
     * @param MessageBusInterface $eventBus
     */
    public function __construct(StayingStoreRepositoryInterface $repository, StayingPriceCounter $priceCounter, MessageBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->priceCounter = $priceCounter;
        $this->eventBus = $eventBus;
    }

    public function __invoke(FinishStayingCommand $command)
    {
        /** @var Staying $staying */
        $staying = $this->repository->getById($command->getId());
        $amountOfStaying = $this->priceCounter->getAmountOfStaying(
            $staying->getStart(),
            $staying->getType()->getName(),
            $staying->getParkingId()
        );
        $staying->finish();
        $this->repository->save($staying);
        $stayingWasFinish = new StayingWasFinish(
            $command->getId(),
            $staying->getUserId(),
            $amountOfStaying
        );
        $this->eventBus->dispatch($stayingWasFinish);
    }
}