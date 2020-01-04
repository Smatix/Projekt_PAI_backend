<?php

namespace App\Reservation\Application\Command\Create;

use App\Reservation\Domain\Factory\ReservationFactory;
use App\Reservation\Domain\ReservationStoreRepositoryInterface;
use App\Shared\Infrastructure\Repository\ParkingSpaceTypeRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;


class CreateReservationHandler implements MessageHandlerInterface
{
    /**
     * @var ReservationStoreRepositoryInterface
     */
    private $repository;

    /**
     * @var ParkingSpaceTypeRepository
     */
    private $spaceTypeRepository;

    /**
     * CancelReservationHandler constructor.
     * @param ReservationStoreRepositoryInterface $repository
     * @param ParkingSpaceTypeRepository $spaceTypeRepository
     */
    public function __construct(ReservationStoreRepositoryInterface $repository, ParkingSpaceTypeRepository $spaceTypeRepository)
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
        $this->repository->save($reservation);
    }
}