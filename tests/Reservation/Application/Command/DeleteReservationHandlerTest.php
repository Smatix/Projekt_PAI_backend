<?php

namespace App\Tests\Reservation\Application\Command;


use App\Reservation\Application\Command\Delete\DeleteReservationCommand;
use App\Reservation\Application\Command\Delete\DeleteReservationHandler;
use App\Reservation\Domain\Factory\ReservationFactory;
use App\Reservation\Domain\ReservationStoreRepositoryInterface;
use App\Reservation\Infrastructure\InMemoryReservationStoreRepository;
use App\Shared\Domain\Model\ParkingSpaceType;
use PHPUnit\Framework\TestCase;

class DeleteReservationHandlerTest extends TestCase
{
    /**
     * @var ReservationStoreRepositoryInterface
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = new InMemoryReservationStoreRepository();
        $reservation = $this->createReservation();
        $this->repository->save($reservation);

    }

    public function createReservation()
    {
        $date = new \DateTime('tomorrow');
        $reservation = ReservationFactory::create(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            $date->format('Y-m-d'),
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce88125');
        return $reservation;
    }

    public function testDeleteReservation()
    {
        $command = new DeleteReservationCommand('594f483a-20f0-11ea-978f-2e728ce88125');
        $handler = new DeleteReservationHandler($this->repository);
        $handler($command);

        $reservation = $this->repository->getById($command->getId());
        $this->assertNull($reservation);
    }
}