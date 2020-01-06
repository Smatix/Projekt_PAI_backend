<?php

namespace App\Staying\Application\Listener;

use App\Reservation\Domain\Event\ReservationWasFinish;
use App\Shared\Infrastructure\Uuid\RamseyUuidAdapter;
use App\Staying\Domain\Staying;
use App\Staying\Domain\StayingStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateStayingWhenReservationWasFinish implements MessageHandlerInterface
{
    /**
     * @var StayingStoreRepositoryInterface
     */
    private $repository;

    /**
     * CreateStayingWhenReservationWasFinish constructor.
     * @param StayingStoreRepositoryInterface $repository
     */
    public function __construct(StayingStoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(ReservationWasFinish $event)
    {
        $staying = new Staying(
            RamseyUuidAdapter::generate(),
            $event->getType(),
            $event->getParkingId(),
            $event->getUserId(),
            $event->getStart()
        );
        $this->repository->save($staying);
    }
}