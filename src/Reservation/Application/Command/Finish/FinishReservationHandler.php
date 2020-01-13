<?php

namespace App\Reservation\Application\Command\Finish;

use App\Reservation\Domain\Event\ReservationWasFinish;
use App\Reservation\Domain\Reservation;
use App\Reservation\Domain\ReservationStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;


class FinishReservationHandler implements MessageHandlerInterface
{
    /**
     * @var ReservationStoreRepositoryInterface
     */
    private $repository;

    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * FinishReservationHandler constructor.
     * @param ReservationStoreRepositoryInterface $repository
     * @param MessageBusInterface $eventBus
     */
    public function __construct(ReservationStoreRepositoryInterface $repository, MessageBusInterface $eventBus)
    {
        $this->repository = $repository;
        $this->eventBus = $eventBus;
    }


    public function __invoke(FinishReservationCommand $command)
    {
        /** @var Reservation $reservation */
        $reservation = $this->repository->getById($command->getId());
        if ($reservation->canBeFinish()) {
            $reservation->finish();
            $this->repository->save($reservation);
            $reservationWasFinish = new ReservationWasFinish(
                new \DateTime('now'),
                $reservation->getType(),
                $reservation->getParkingId(),
                $reservation->getUserId()
            );
            $this->eventBus->dispatch($reservationWasFinish);
        }

    }
}