<?php

namespace App\Tests\Reservation\Application\Command;

use App\Reservation\Application\Command\Create\CreateReservationCommand;
use App\Reservation\Application\Command\Create\CreateReservationHandler;
use App\Reservation\Infrastructure\InMemoryReservationStoreRepository;
use App\Shared\Infrastructure\Repository\InMemoryParkingSpaceTypeRepository;
use PHPUnit\Framework\TestCase;

class CreateReservationHandlerTest extends TestCase
{
    public function testCreateReservation()
    {
        $command = new CreateReservationCommand();
        $command->setParkingId('594f483a-20f0-11ea-978f-2e728ce88125');
        $command->setReservationDate('2019-01-19');
        $command->setType('car');
        $command->setUserId('594f483a-20f0-11ea-978f-2e728ce88125');

        $parkingSpaceRepository = new InMemoryParkingSpaceTypeRepository();
        $reservationRepository = new InMemoryReservationStoreRepository();

        $handler = new CreateReservationHandler($reservationRepository, $parkingSpaceRepository);
        $handler($command);

        $reservation = $reservationRepository->getById($command->getId());
        $this->assertNotNull($reservation);
    }
}