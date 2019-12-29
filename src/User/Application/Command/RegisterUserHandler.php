<?php

namespace App\User\Application\Command;

use App\User\Domain\Factory\UserFactory;
use App\User\Domain\UserStoreRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterUserHandler implements MessageHandlerInterface
{
    private $repository;

    /**
     * RegisterUserHandler constructor.
     * @param UserStoreRepositoryInterface $repository
     */
    public function __construct(UserStoreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RegisterUserCommand $command)
    {
        $user = UserFactory::create(
            $command->getPlainPassword(),
            $command->getEmail(),
            $command->getName(),
            $command->getSurname(),
            $command->getRole()
        );

        $this->repository->save($user);
    }
}