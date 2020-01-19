<?php

namespace App\Tests\User\Application\Command;

use App\User\Application\Command\RegisterUserCommand;
use App\User\Application\Command\RegisterUserHandler;
use App\User\Infrastructure\InMemoryUserStoreRepository;
use PHPUnit\Framework\TestCase;

class RegisterUserHandlerTest extends TestCase
{
    public function testRegisterUser()
    {
        $command = new RegisterUserCommand();
        $command->setName('Jan');
        $command->setSurname('Nowak');
        $command->setEmail('xyz@wp.pl');
        $command->setPlainPassword('1234');
        $command->setRole(1);

        $repository = new InMemoryUserStoreRepository();
        $handler = new RegisterUserHandler($repository);

        $handler($command);

        $user = $repository->findByEmail($command->getEmail());
        $this->assertNotNull($user);
    }
}