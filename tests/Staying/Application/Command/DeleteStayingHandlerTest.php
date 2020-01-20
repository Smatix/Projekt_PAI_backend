<?php

namespace App\Tests\Staying\Application\Command;

use App\Shared\Domain\Model\ParkingSpaceType;
use App\Staying\Application\Command\Delete\DeleteStayingCommand;
use App\Staying\Application\Command\Delete\DeleteStayingHandler;
use App\Staying\Domain\Staying;
use App\Staying\Domain\StayingStoreRepositoryInterface;
use App\Staying\Infrastructure\InMemoryStayingStoreRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteStayingHandlerTest extends TestCase
{
    /**
     * @var StayingStoreRepositoryInterface
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();
        $this->repository = new InMemoryStayingStoreRepository();
        $reservation = $this->createStaying();
        $this->repository->save($reservation);

    }

    public function createStaying()
    {
        return new Staying(
            '594f483a-20f0-11ea-978f-2e728ce88125',
            new ParkingSpaceType('car'),
            '594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce8812u'
        );
    }

    public function testDeleteStaying()
    {
        $command = new DeleteStayingCommand('594f483a-20f0-11ea-978f-2e728ce88125',
            '594f483a-20f0-11ea-978f-2e728ce8812u');

        $handler = new DeleteStayingHandler($this->repository);
        $handler($command);

        $staying = $this->repository->getById($command->getId());
        $this->assertNotNull($staying->getDeletedAt());
    }
}