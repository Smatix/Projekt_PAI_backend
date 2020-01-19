<?php

namespace App\Reservation\Application\Command\Create;

use App\Reservation\Domain\Factory\ReservationFactory;
use App\Reservation\Domain\ReservationStoreRepositoryInterface;
use App\Shared\Infrastructure\Repository\ParkingSpaceTypeRepository;
use App\Shared\Infrastructure\Repository\ParkingSpaceTypeRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;


class CreateReservationHandler implements MessageHandlerInterface
{
    /**
     * @var ReservationStoreRepositoryInterface
     */
    private $repository;

    /**
     * @var ParkingSpaceTypeRepositoryInterface
     */
    private $spaceTypeRepository;

    /**
     * CancelReservationHandler constructor.
     * @param ReservationStoreRepositoryInterface $repository
     * @param ParkingSpaceTypeRepositoryInterface $spaceTypeRepository
     */
    public function __construct(ReservationStoreRepositoryInterface $repository, ParkingSpaceTypeRepositoryInterface $spaceTypeRepository)
    {
        $this->repository = $repository;
        $this->spaceTypeRepository = $spaceTypeRepository;
    }

    public function __invoke(CreateReservationCommand $command)
    {
        $type = $this->spaceTypeRepository->getByName($command->getType());
        $reservation = ReservationFactory::create(
            $command->getId(),
            $command->getReservationDate(),
            $type,
            $command->getParkingId(),
            $command->getUserId()
        );
        //$reservation->markAsActive();
        $this->repository->save($reservation);
    }
}