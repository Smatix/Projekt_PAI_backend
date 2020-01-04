<?php

namespace App\Reservation\Application\Command\Accept;

use App\Reservation\Domain\Reservation;
use App\Reservation\Domain\ReservationStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;


class AcceptReservationHandler implements MessageHandlerInterface
{
    /**
     * @var ReservationStoreRepositoryInterface
     */
    private $repository;

    /**
     * CancelReservationHandler constructor.
     * @param ReservationStoreRepositoryInterface $repository
     */
    public function __construct(ReservationStoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AcceptReservationCommand $command)
    {
        /** @var Reservation $reservation */
        $reservation = $this->repository->getById($command->getId());
        $reservation->markAsActive();
        $this->repository->save($reservation);
    }
}