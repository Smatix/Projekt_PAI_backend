<?php

namespace App\Tests\User\Application\Command;

use App\User\Application\Command\ChangeUserDataCommand;
use App\User\Application\Command\ChangeUserDataHandler;
use App\User\Domain\Factory\UserFactory;
use App\User\Domain\Service\PasswordEncoder;
use App\User\Domain\User;
use App\User\Domain\UserStoreRepositoryInterface;
use App\User\Infrastructure\InMemoryUserStoreRepository;
use PHPUnit\Framework\TestCase;

class ChangeUserDataHandlerTest extends TestCase
{
    /**
     * @var UserStoreRepositoryInterface
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();
        $user = $this->createUser();
        $this->repository = new InMemoryUserStoreRepository();
        $this->repository->save($user);
    }

    public function createUser()
    {
        $user = UserFactory::create(
            '1234',
            'xyz@wp.pl',
            'Jan',
            'Nowak',
            1
        );
        return $user;
    }

    public function testChangeUserData()
    {
        $command = new ChangeUserDataCommand();
        $command->setNewEmail('xxx@wp.pl');
        $command->setOldEmail('xyz@wp.pl');
        $command->setNewPassword('2222');
        $command->setOldPassword('1234');

        $handler = new ChangeUserDataHandler($this->repository);
        $handler($command);

        /** @var User $changedUser */
        $changedUser = $this->repository->findByEmail($command->getNewEmail());

        $this->assertNotNull($changedUser);
        $this->assertTrue(PasswordEncoder::verify($command->getNewPassword(), $changedUser->getPassword()));
    }
}